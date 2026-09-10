<?php

namespace App\Controllers;

use App\Http\HttpException;
use App\Http\Pagination;
use App\Http\Request;
use App\Http\Response;
use App\Http\Url;
use App\Models\Product;
use App\Security\Csrf;
use App\Validation\ProductInput;
use PDOException;

class ProductController extends Controller
{
    public function __construct(private ?Product $model = null)
    {
    }

    private function products(): Product
    {
        return $this->model ??= new Product();
    }

    public function index(): void
    {
        Request::requireMethods(['GET']);
        $this->requireAuth();
        $keyword = trim(Request::queryString('keyword'));
        $summary = $this->products()->getSummary();
        $total = $keyword === '' ? (int) $summary['total_products'] : $this->products()->getTotal($keyword);
        $pagination = new Pagination($total, Request::queryInt('page', 1));
        $success = $_SESSION['success'] ?? '';
        unset($_SESSION['success']);

        $this->render('product_list.tpl', [
            'products' => $this->products()->getPaginated($pagination->perPage, $pagination->offset, $keyword),
            'keyword' => $keyword,
            'totalProducts' => $total,
            'summaryProducts' => (int) $summary['total_products'],
            'totalQuantity' => $summary['total_quantity'],
            'totalValue' => $summary['total_value'],
            'page' => $pagination->page,
            'totalPages' => $pagination->totalPages,
            'pagination' => $pagination->links($keyword),
            'previousUrl' => $pagination->previousUrl($keyword),
            'nextUrl' => $pagination->nextUrl($keyword),
            'success' => $success,
        ]);
    }

    public function create(): void
    {
        Request::requireMethods(['GET', 'POST']);
        $this->requireAuth();
        $product = ProductInput::fromArray([]);
        $error = '';

        if (Request::method() === 'POST') {
            Csrf::requirePost();
            $product = ProductInput::fromArray($_POST);
            $error = ProductInput::error($product);
            if ($error === '') {
                try {
                    $this->products()->insert(
                        $product['name'], $product['price'], (int) $product['quantity'], $product['description']
                    );
                    $this->completed('created');
                } catch (PDOException $e) {
                    error_log((string) $e);
                    http_response_code(500);
                    $error = 'Không thể thêm sản phẩm. Vui lòng thử lại sau.';
                }
            } else {
                http_response_code(422);
            }
        }

        $this->render('product_create.tpl', ['product' => $product, 'error' => $error]);
    }

    public function edit(): void
    {
        Request::requireMethods(['GET', 'POST']);
        $this->requireAuth();
        if (Request::method() === 'POST') {
            Csrf::requirePost();
        }

        $id = Request::queryInt('id');
        if ($id <= 0) {
            Response::redirect(Url::product());
        }
        $product = $this->products()->getById($id);
        if ($product === null) {
            throw new HttpException(404, 'Không tìm thấy sản phẩm.');
        }

        $error = '';
        if (Request::method() === 'POST') {
            $values = ProductInput::fromArray($_POST);
            $product = array_replace($product, $values);
            $error = ProductInput::error($values);
            if ($error === '') {
                try {
                    $this->products()->update(
                        $id, $values['name'], $values['price'], (int) $values['quantity'], $values['description']
                    );
                    $this->completed('updated');
                } catch (PDOException $e) {
                    error_log((string) $e);
                    http_response_code(500);
                    $error = 'Không thể cập nhật sản phẩm. Vui lòng thử lại sau.';
                }
            } else {
                http_response_code(422);
            }
        }

        $this->render('product_edit.tpl', ['product' => $product, 'error' => $error]);
    }

    public function delete(): void
    {
        Request::requireMethods(['POST']);
        $this->requireAuth();
        Csrf::requirePost();
        $id = Request::postInt('id');
        if ($id <= 0) {
            Response::redirect(Url::product());
        }
        if (!$this->products()->delete($id)) {
            throw new HttpException(404, 'Không tìm thấy sản phẩm.');
        }
        $this->completed('deleted');
    }

    private function completed(string $action): never
    {
        $_SESSION['success'] = $action;
        Response::redirect(Url::product());
    }
}
