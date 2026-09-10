<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\HttpException;
use App\Http\Pagination;
use App\Http\Request;
use App\Http\Url;
use App\Models\Product;
use App\Security\Csrf;
use App\Validation\ProductInput;
use Config\Money;
use Config\SmartyConfig;

// These checks use in-memory inputs and fixtures, never the application's database.
$tests = [];

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function same(mixed $expected, mixed $actual, string $message): void
{
    check($expected === $actual, $message . ': expected ' . var_export($expected, true)
        . ', got ' . var_export($actual, true));
}

function invalidProduct(array $changes): bool
{
    $valid = ['name' => 'Điện thoại', 'price' => '123.45', 'quantity' => '2', 'description' => 'Mô tả'];

    return ProductInput::error(ProductInput::fromArray(array_replace($valid, $changes))) !== '';
}

function renderFixture(string $template, array $variables = []): string
{
    $compileDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'product-cms-tests-' . bin2hex(random_bytes(8));
    if (!mkdir($compileDir, 0700)) {
        throw new RuntimeException('Cannot create isolated Smarty compilation directory');
    }
    $compileRoot = realpath($compileDir);

    try {
        $smarty = SmartyConfig::getSmarty();
        $smarty->setCompileDir($compileDir);
        $smarty->clearAllAssign();
        $smarty->assign(array_replace([
            'username' => 'Tester',
            'loginUsername' => '',
            'csrfToken' => 'fixture-csrf-token',
            'listUrl' => Url::product(),
            'createUrl' => Url::product('create'),
            'editUrl' => Url::product('edit'),
            'deleteUrl' => Url::product('delete'),
            'loginUrl' => Url::login(),
            'logoutUrl' => Url::logout(),
            'products' => [],
            'product' => ['id' => 7, 'name' => '', 'price' => '', 'quantity' => '', 'description' => ''],
            'page' => 1,
            'totalPages' => 1,
            'totalProducts' => 0,
            'summaryProducts' => 0,
            'totalQuantity' => 0,
            'totalValue' => '0',
            'keyword' => '',
            'success' => '',
            'error' => '',
            'pagination' => [],
            'previousUrl' => null,
            'nextUrl' => null,
        ], $variables));

        return $smarty->fetch($template);
    } finally {
        // Only remove files created inside this unique temporary directory.
        if ($compileRoot !== false && realpath($compileDir) === $compileRoot) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($compileRoot, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($files as $file) {
                $path = $file->getPathname();
                check(str_starts_with($path, $compileRoot . DIRECTORY_SEPARATOR), 'Temporary cleanup stays in its directory');
                if ($file->isDir() && !$file->isLink()) {
                    rmdir($path);
                } else {
                    unlink($path);
                }
            }
            rmdir($compileRoot);
        }
    }
}

function parseFixture(string $html): DOMXPath
{
    $document = new DOMDocument();
    check(@$document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING), 'Rendered HTML parses');

    return new DOMXPath($document);
}

function expectHttp(int $status, callable $action): void
{
    try {
        $action();
    } catch (HttpException $error) {
        same($status, $error->status, 'HTTP status');
        return;
    }
    throw new RuntimeException('Expected HTTP ' . $status);
}

// Record actual model bindings without opening a PDO connection or writing rows.
final class RecordingPDO extends PDO
{
    public RecordingStatement $lastStatement;
    public int $affectedRows = 1;

    public function __construct()
    {
    }

    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        preg_match_all('/:[a-z_]+/', $query, $matches);
        if (count($matches[0]) !== count(array_unique($matches[0]))) {
            throw new PDOException('Native prepares do not support repeated named placeholders');
        }
        return $this->lastStatement = new RecordingStatement($query, $this->affectedRows);
    }
}

final class RecordingStatement extends PDOStatement
{
    public array $bindings = [];

    public function __construct(public string $sql, private int $affectedRows)
    {
    }

    public function bindValue(string|int $param, mixed $value, int $type = PDO::PARAM_STR): bool
    {
        $this->bindings[$param] = ['value' => $value, 'type' => $type];
        return true;
    }

    public function execute(?array $params = null): bool
    {
        return true;
    }

    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): array
    {
        return [];
    }

    public function rowCount(): int
    {
        return $this->affectedRows;
    }
}

$tests['request strings preserve Unicode and reject array parameters'] = static function (): void {
    $_GET = ['keyword' => 'Điện thoại & phụ kiện', 'bad' => ['value']];
    $_POST = ['name' => 'Sản phẩm', 'bad' => ['value']];
    same('Điện thoại & phụ kiện', Request::queryString('keyword'), 'Query string');
    same('Sản phẩm', Request::postString('name'), 'POST string');
    same('fallback', Request::queryString('absent', 'fallback'), 'Missing string default');

    foreach ([fn () => Request::queryString('bad'), fn () => Request::postString('bad')] as $read) {
        expectHttp(400, $read);
    }
};

$tests['request integers never silently truncate malformed numbers'] = static function (): void {
    foreach (['1.5', '1e3', '12items', '', str_repeat('9', 30)] as $invalid) {
        $_GET = ['page' => $invalid];
        $_POST = ['id' => $invalid];
        same(7, Request::queryInt('page', 7), 'Invalid query integer ' . $invalid);
        same(7, Request::postInt('id', 7), 'Invalid POST integer ' . $invalid);
    }
    $_GET = ['page' => (string) PHP_INT_MAX];
    same(PHP_INT_MAX, Request::queryInt('page'), 'Largest supported integer');
};

$tests['pagination clamps empty and out-of-range requests before computing offsets'] = static function (): void {
    $empty = new Pagination(0, PHP_INT_MAX);
    same(1, $empty->page, 'Empty results page');
    same(0, $empty->offset, 'Empty results offset');
    check(!$empty->previousUrl() && !$empty->nextUrl(), 'Empty results have no adjacent pages');

    $last = new Pagination(11, PHP_INT_MAX);
    same(3, $last->page, 'Last page clamp');
    same(3, $last->totalPages, 'Five products per page');
    same(10, $last->offset, 'Last page offset');
    check(!$last->nextUrl(), 'Last page has no next URL');
    same(1, (new Pagination(11, -100))->page, 'Negative request clamps to first page');
};

$tests['pagination remains bounded and preserves search text in every link'] = static function (): void {
    $keyword = 'điện thoại & a+b / ? " <script>';
    $pagination = new Pagination(1000000, 50000);
    $links = $pagination->links($keyword);
    check(count($links) <= 11, 'Navigation must not grow with all 200,000 pages');
    $active = 0;
    $pages = [];
    foreach ($links as $link) {
        if ($link['page'] === null) {
            continue;
        }
        $pages[] = $link['page'];
        parse_str((string) parse_url($link['url'], PHP_URL_QUERY), $query);
        same($keyword, $query['keyword'] ?? null, 'Keyword survives URL encoding');
        same((string) $link['page'], (string) ($query['page'] ?? ''), 'URL points to displayed page');
        $active += (int) $link['active'];
    }
    same(1, $active, 'Exactly one current page');
    check(in_array(1, $pages, true), 'First page remains accessible');
    check(in_array(200000, $pages, true), 'Last page remains accessible');
    same(count($pages), count(array_unique($pages)), 'No duplicate page links');

    foreach ([$pagination->previousUrl($keyword), $pagination->nextUrl($keyword)] as $url) {
        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        same($keyword, $query['keyword'] ?? null, 'Adjacent link preserves keyword');
    }
};

$tests['pagination handles large integer totals without floating point rounding'] = static function (): void {
    $pagination = new Pagination(PHP_INT_MAX, PHP_INT_MAX);
    $expectedPages = intdiv(PHP_INT_MAX, 5) + (PHP_INT_MAX % 5 === 0 ? 0 : 1);
    same($expectedPages, $pagination->totalPages, 'Exact total page count');
    same(($expectedPages - 1) * 5, $pagination->offset, 'Exact large offset');
};

$tests['product URLs preserve route and query parameters'] = static function (): void {
    $keyword = 'A&B + Điện thoại';
    $url = Url::product('list', ['page' => 2, 'keyword' => $keyword]);
    same('/admin.php', parse_url($url, PHP_URL_PATH), 'Admin entry point');
    parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
    same('manage', $query['module'] ?? null, 'Management module');
    same('product', $query['entity'] ?? null, 'Product entity');
    same('list', $query['action'] ?? null, 'List action');
    same($keyword, $query['keyword'] ?? null, 'Keyword round trip');
    same('2', $query['page'] ?? null, 'Page round trip');
};

$tests['product validation accepts decimal strings within the existing database limits'] = static function (): void {
    foreach (['0', '12', '12.3', '12.34', '9999999999.99'] as $price) {
        check(!invalidProduct(['price' => $price]), 'Valid exact price rejected: ' . $price);
    }
    foreach (['0', '2147483647'] as $quantity) {
        check(!invalidProduct(['quantity' => $quantity]), 'Valid quantity rejected');
    }
};

$tests['product validation rejects invalid prices and quantities rather than casting to zero'] = static function (): void {
    foreach (['', 'garbage', '-1', '1e3', 'NaN', '1.234', '10000000000.00'] as $price) {
        check(invalidProduct(['price' => $price]), 'Invalid price accepted: ' . $price);
    }
    foreach (['', '-1', '1.5', '1e3', '2147483648', str_repeat('9', 30)] as $quantity) {
        check(invalidProduct(['quantity' => $quantity]), 'Invalid quantity accepted: ' . $quantity);
    }
};

$tests['product validation bounds Unicode names and description bytes'] = static function (): void {
    check(!invalidProduct(['name' => str_repeat('đ', 255)]), '255 Unicode characters fit the name field');
    check(invalidProduct(['name' => str_repeat('đ', 256)]), 'Oversized Unicode name rejected');
    check(invalidProduct(['name' => '   ']), 'Whitespace-only name rejected');
    check(!invalidProduct(['description' => str_repeat('a', 65535)]), 'Description at byte limit accepted');
    check(invalidProduct(['description' => str_repeat('đ', 32768)]), 'Description byte overflow rejected');
};

$tests['product validation handles malicious array fields without TypeError'] = static function (): void {
    foreach (['name', 'price', 'quantity', 'description'] as $field) {
        check(invalidProduct([$field => ['injected']]), 'Array ' . $field . ' rejected');
    }
};

$tests['CSRF validates session-bound scalar tokens only'] = static function (): void {
    $_SESSION = [];
    $token = Csrf::token();
    check(strlen($token) >= 32, 'Token has enough random data');
    same($token, Csrf::token(), 'Token persists within the session');
    check(Csrf::validate($token), 'Current session token accepted');
    foreach ([null, '', ['token' => $token], 'different-token'] as $invalid) {
        check(!Csrf::validate($invalid), 'Missing, array, and incorrect tokens rejected');
    }
    $_SESSION = [];
    check(!Csrf::validate($token), 'A token from a previous session is invalid');
};

$tests['POST protection rejects wrong methods and invalid tokens before processing form data'] = static function (): void {
    $_SESSION = [];
    $_POST = ['csrf_token' => Csrf::token()];
    $_SERVER['REQUEST_METHOD'] = 'GET';
    expectHttp(405, fn () => Csrf::requirePost());
    $_SERVER['REQUEST_METHOD'] = 'POST';
    Csrf::requirePost();
    $_POST['csrf_token'] = ['malformed'];
    expectHttp(403, fn () => Csrf::requirePost());
    $_POST = [];
    expectHttp(403, fn () => Csrf::requirePost());
};

$tests['product writes preserve exact price strings and integer bindings'] = static function (): void {
    $pdo = new RecordingPDO();
    $model = new Product($pdo);
    $model->insert('Điện thoại', '9999999999.99', 4, 'Mô tả');
    same(['value' => '9999999999.99', 'type' => PDO::PARAM_STR], $pdo->lastStatement->bindings[':price'], 'Insert exact decimal');
    same(['value' => 4, 'type' => PDO::PARAM_INT], $pdo->lastStatement->bindings[':quantity'], 'Insert integer quantity');
    $model->update(7, 'Điện thoại', '1234567890.01', 3, 'Mô tả');
    same(['value' => '1234567890.01', 'type' => PDO::PARAM_STR], $pdo->lastStatement->bindings[':price'], 'Update exact decimal');
};

$tests['search remains parameterized and compatible with native PDO pagination'] = static function (): void {
    $pdo = new RecordingPDO();
    $model = new Product($pdo);
    $keyword = "' OR 1=1 --";
    $model->getPaginated(5, 10, $keyword);
    check(!str_contains($pdo->lastStatement->sql, $keyword), 'Search input never becomes SQL text');
    same(['value' => 5, 'type' => PDO::PARAM_INT], $pdo->lastStatement->bindings[':limit'], 'LIMIT bound as integer');
    same(['value' => 10, 'type' => PDO::PARAM_INT], $pdo->lastStatement->bindings[':offset'], 'OFFSET bound as integer');
    $searchValues = array_filter($pdo->lastStatement->bindings, static fn (array $binding): bool => $binding['value'] === '%' . $keyword . '%');
    same(2, count($searchValues), 'Name and description each bind a separate search placeholder');
    $model->search($keyword);
};

$tests['delete reports a missing product instead of a false success'] = static function (): void {
    $pdo = new RecordingPDO();
    $model = new Product($pdo);
    $pdo->affectedRows = 0;
    check(!$model->delete(404), 'No affected rows means product was missing');
    $pdo->affectedRows = 1;
    check($model->delete(7), 'A deleted row means success');
};

$tests['money formatting rounds decimal strings without losing large integer precision'] = static function (): void {
    same('0', Money::format('0.00'), 'Zero money');
    same('1.234', Money::format('1234.49'), 'Round below half');
    same('1.235', Money::format('1234.50'), 'Round half up');
    same('1.000', Money::format('999.99'), 'Carry into next group');
    same('9.007.199.254.740.993', Money::format('9007199254740993.01'), 'Beyond floating point safe integer range');
    same('100.000.000.000.000.000.000', Money::format('99999999999999999999.99'), 'Large rounding carry');
};

$tests['list template escapes product data and preserves zero search filter'] = static function (): void {
    $attack = '<script>alert("xss")</script>';
    $html = renderFixture('product_list.tpl', [
        'products' => [['id' => 7, 'name' => $attack, 'price' => '10.00', 'quantity' => 2, 'description' => $attack]],
        'username' => $attack,
        'keyword' => '0',
        'totalProducts' => 1,
        'summaryProducts' => 25,
        'totalQuantity' => 50,
        'totalValue' => '9007199254740993.01',
    ]);
    $xpath = parseFixture($html);
    same(0, $xpath->query('//script')->length, 'No injected script elements');
    check(str_contains($html, '&lt;script&gt;'), 'Product text escaped');
    same('0', $xpath->evaluate('string(//input[@name="keyword"]/@value)'), 'Zero keyword retained');
    same(1, $xpath->query('//a[contains(@class,"clear-button")]')->length, 'Zero keyword still offers clear filter');
    check(str_contains($html, '9.007.199.254.740.993'), 'Summary rendered with exact money formatter');
    same(1, $xpath->query('//html')->length, 'Single rendered HTML document');
};

$tests['create and edit templates preserve invalid form values safely'] = static function (): void {
    $attack = '\" onmouseover=\"alert(1)';
    $product = ['id' => 7, 'name' => '<b>Điện thoại</b>', 'price' => $attack,
        'quantity' => $attack, 'description' => '</textarea><script>alert(1)</script>'];
    foreach (['product_create.tpl', 'product_edit.tpl'] as $template) {
        $xpath = parseFixture(renderFixture($template, ['product' => $product, 'error' => '<b>Lỗi</b>']));
        foreach (['name', 'price', 'quantity'] as $field) {
            same($product[$field], $xpath->evaluate('string(//input[@name="' . $field . '"]/@value)'), $template . ' preserves ' . $field);
        }
        same($product['description'], $xpath->evaluate('string(//textarea[@name="description"])'), 'Description round trip');
        same(0, $xpath->query('//*[@onmouseover] | //script')->length, 'Form values cannot inject attributes or scripts');
        same('fixture-csrf-token', $xpath->evaluate('string(//input[@name="csrf_token"]/@value)'), 'CSRF token present');
    }
};

$tests['login template preserves username and keeps the password empty'] = static function (): void {
    $username = '\" autofocus onfocus=\"alert(1)';
    $xpath = parseFixture(renderFixture('login.tpl', ['loginUsername' => $username, 'error' => 'Đăng nhập thất bại']));
    same($username, $xpath->evaluate('string(//input[@name="username"]/@value)'), 'Username retained safely');
    same('', $xpath->evaluate('string(//input[@name="password"]/@value)'), 'Password never reflected');
    same(0, $xpath->query('//*[@onfocus]')->length, 'No username attribute injection');
    same(Url::login(), $xpath->evaluate('string(//form/@action)'), 'Canonical login URL');
};

$tests['rendered pagination uses a bounded window and keeps search on adjacent links'] = static function (): void {
    $keyword = 'Điện thoại & phụ kiện';
    $pagination = new Pagination(1000000, 50000);
    $xpath = parseFixture(renderFixture('product_list.tpl', [
        'page' => $pagination->page,
        'totalPages' => $pagination->totalPages,
        'totalProducts' => 1000000,
        'keyword' => $keyword,
        'pagination' => $pagination->links($keyword),
        'previousUrl' => $pagination->previousUrl($keyword),
        'nextUrl' => $pagination->nextUrl($keyword),
    ]));
    $links = $xpath->query('//nav[contains(@class,"pagination")]//a');
    check($links->length > 2 && $links->length <= 12, 'Rendered links remain bounded');
    foreach ($links as $link) {
        parse_str((string) parse_url($link->getAttribute('href'), PHP_URL_QUERY), $query);
        same($keyword, $query['keyword'] ?? null, 'Rendered link preserves encoded keyword');
        same('list', $query['action'] ?? null, 'Rendered pagination stays on module list');
    }
};

$failures = 0;
$results = [];
set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

foreach ($tests as $name => $test) {
    $globals = [$_GET, $_POST, $_SERVER, $_SESSION ?? []];
    try {
        $test();
        $results[] = 'PASS ' . $name;
    } catch (Throwable $error) {
        ++$failures;
        $results[] = 'FAIL ' . $name . ': ' . $error->getMessage();
    } finally {
        [$_GET, $_POST, $_SERVER, $_SESSION] = $globals;
    }
}

restore_error_handler();
echo implode(PHP_EOL, $results) . PHP_EOL;
echo count($tests) . ' tests, ' . $failures . ' failures.' . PHP_EOL;
exit($failures === 0 ? 0 : 1);
