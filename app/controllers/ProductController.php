<?php

namespace App\Controllers;

use App\Models\Product;
use Config\SmartyConfig;

class ProductController
{
    public function index(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $productModel = new Product();

    // Từ khóa tìm kiếm
    $keyword = trim($_GET['keyword'] ?? '');

    // Trang hiện tại
    $page = max(1, (int) ($_GET['page'] ?? 1));

    // Số sản phẩm trên mỗi trang
    $limit = 5;

    // Vị trí bắt đầu
    $offset = ($page - 1) * $limit;

    // Tổng số sản phẩm phù hợp với từ khóa
    $totalProducts = $productModel->getTotal($keyword);

    // Tổng số trang
    $totalPages = (int) ceil($totalProducts / $limit);

    // Nếu page vượt quá số trang thì đưa về trang cuối
    if ($totalPages > 0 && $page > $totalPages) {
        $page = $totalPages;
        $offset = ($page - 1) * $limit;
    }

    // Lấy sản phẩm theo trang
    $products = $productModel->getPaginated(
        $limit,
        $offset,
        $keyword
    );

    $smarty = SmartyConfig::getSmarty();

    $smarty->assign('products', $products);
    $smarty->assign('username', $_SESSION['username'] ?? '');

    // Dữ liệu phân trang
    $smarty->assign('page', $page);
    $smarty->assign('totalPages', $totalPages);
    $smarty->assign('totalProducts', $totalProducts);
    $smarty->assign('keyword', $keyword);

    // Thông báo thành công
    $success = $_SESSION['success'] ?? '';
    unset($_SESSION['success']);

    $smarty->assign('success', $success);

    $smarty->display('product_list.tpl');
}

    public function create(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = trim($_POST['name'] ?? '');
        $price = (float) ($_POST['price'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {

            $error = 'Vui lòng nhập tên sản phẩm.';

        } elseif ($price < 0) {

            $error = 'Giá sản phẩm không hợp lệ.';

        } elseif ($quantity < 0) {

            $error = 'Số lượng không hợp lệ.';

        } else {

            $productModel = new Product();

            try {

                $productModel->insert(
                    $name,
                    $price,
                    $quantity,
                    $description
                );

                $_SESSION['success'] = 'created';

                header('Location: /');
                exit;

            } catch (\PDOException $e) {

                $error = 'Không thể thêm sản phẩm. Vui lòng kiểm tra lại dữ liệu.';
            }
        }
    }

    $smarty = SmartyConfig::getSmarty();

    $smarty->assign('error', $error);

    $smarty->display('product_create.tpl');
}

    public function edit(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);

    if ($id <= 0) {
        header('Location: /');
        exit;
    }

    $productModel = new Product();

    $product = $productModel->getById($id);

    if (!$product) {
        http_response_code(404);
        echo 'Không tìm thấy sản phẩm.';
        exit;
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = trim($_POST['name'] ?? '');
        $price = (float) ($_POST['price'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {

            $error = 'Vui lòng nhập tên sản phẩm.';

        } elseif ($price < 0) {

            $error = 'Giá sản phẩm không hợp lệ.';

        } elseif ($quantity < 0) {

            $error = 'Số lượng không hợp lệ.';

        } else {

            try {

                $productModel->update(
                    $id,
                    $name,
                    $price,
                    $quantity,
                    $description
                );

                $_SESSION['success'] = 'updated';

                header('Location: /');
                exit;

            } catch (\PDOException $e) {

                $error = 'Không thể cập nhật sản phẩm. Vui lòng kiểm tra lại dữ liệu.';
            }
        }

        // Giữ lại dữ liệu người dùng vừa nhập nếu có lỗi
        $product['name'] = $name;
        $product['price'] = $price;
        $product['quantity'] = $quantity;
        $product['description'] = $description;
    }

    $smarty = SmartyConfig::getSmarty();

    $smarty->assign('product', $product);
    $smarty->assign('error', $error);

    $smarty->display('product_edit.tpl');
}

   public function delete(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);

    if ($id <= 0) {
        header('Location: /');
        exit;
    }

    $productModel = new Product();

    $product = $productModel->getById($id);

    if (!$product) {
        http_response_code(404);
        echo 'Không tìm thấy sản phẩm.';
        exit;
    }

    $productModel->delete($id);

    $_SESSION['success'] = 'deleted';

    header('Location: /');
    exit;
}
}