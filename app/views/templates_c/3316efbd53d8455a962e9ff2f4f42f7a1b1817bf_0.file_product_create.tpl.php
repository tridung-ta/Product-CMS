<?php
/* Smarty version 5.8.4, created on 2026-09-08 08:18:57
  from 'file:product_create.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.4',
  'unifunc' => 'content_6a9fc4f18eba08_93437415',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3316efbd53d8455a962e9ff2f4f42f7a1b1817bf' => 
    array (
      0 => 'product_create.tpl',
      1 => 1788855514,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a9fc4f18eba08_93437415 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\product-cms\\app\\views\\templates';
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thêm sản phẩm - Product CMS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        /* HEADER */
        .header {
            background: #212529;
            color: white;
            padding: 18px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout {
            color: white;
            text-decoration: none;
            background: #dc3545;
            padding: 8px 14px;
            border-radius: 5px;
        }

        .logout:hover {
            background: #bb2d3b;
        }

        /* CONTAINER */
        .container {
            max-width: 850px;
            margin: 35px auto;
            padding: 0 20px;
        }

        /* TITLE */
        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .title-row h1 {
            margin: 0;
            font-size: 28px;
        }

        .back-button {
            display: inline-block;
            background: #6c757d;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-button:hover {
            background: #5c636a;
        }

        /* FORM CARD */
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;

            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .form-description {
            margin-top: 0;
            margin-bottom: 25px;
            color: #6c757d;
            font-size: 14px;
        }

        /* ERROR */
        .error {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;

            padding: 12px 16px;
            margin-bottom: 20px;

            border-radius: 6px;
        }

        /* FORM */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;

            font-weight: bold;
            color: #343a40;
        }

        .required {
            color: #dc3545;
        }

        input,
        textarea {
            width: 100%;

            padding: 11px 13px;

            border: 1px solid #ced4da;
            border-radius: 6px;

            font-family: Arial, sans-serif;
            font-size: 15px;

            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        textarea:focus {
            outline: none;

            border-color: #0d6efd;

            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .help-text {
            display: block;

            margin-top: 5px;

            font-size: 13px;
            color: #6c757d;
        }

        /* BUTTONS */
        .buttons {
            display: flex;
            gap: 10px;

            margin-top: 25px;
            padding-top: 20px;

            border-top: 1px solid #eee;
        }

        .submit-button {
            border: none;

            background: #198754;
            color: white;

            padding: 11px 20px;

            border-radius: 6px;

            cursor: pointer;

            font-size: 15px;
            font-weight: bold;
        }

        .submit-button:hover {
            background: #157347;
        }

        .cancel-button {
            display: inline-block;

            background: #6c757d;
            color: white;

            padding: 11px 20px;

            text-decoration: none;

            border-radius: 6px;

            font-size: 15px;
        }

        .cancel-button:hover {
            background: #5c636a;
        }

        /* MOBILE */
        @media (max-width: 768px) {

            .header {
                padding: 15px 20px;
            }

            .user-info span {
                display: none;
            }

            .container {
                margin-top: 25px;
            }

            .title-row {
                flex-direction: column;
                align-items: flex-start;

                gap: 15px;
            }

            .form-card {
                padding: 20px;
            }

            .buttons {
                flex-direction: column;
            }

            .submit-button,
            .cancel-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">

    <h2>Product CMS</h2>

    <div class="user-info">

        <span>
            Xin chào,
            <strong><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('username'), ENT_QUOTES, 'UTF-8', true);?>
</strong>
        </span>

        <a href="/logout" class="logout">
            Đăng xuất
        </a>

    </div>

</div>


<!-- MAIN -->
<div class="container">

    <!-- TITLE -->
    <div class="title-row">

        <h1>Thêm sản phẩm</h1>

        <a href="/" class="back-button">
            ← Quay lại
        </a>

    </div>


    <!-- FORM -->
    <div class="form-card">

        <p class="form-description">
            Nhập thông tin sản phẩm mới vào hệ thống.
        </p>


        <!-- ERROR -->
        <?php if ($_smarty_tpl->getValue('error')) {?>

            <div class="error">
                <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('error'), ENT_QUOTES, 'UTF-8', true);?>

            </div>

        <?php }?>


        <form
            method="POST"
            action="/products/create"
        >

            <!-- NAME -->
            <div class="form-group">

                <label for="name">
                    Tên sản phẩm
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Nhập tên sản phẩm"
                    required
                >

            </div>


            <!-- PRICE -->
            <div class="form-group">

                <label for="price">
                    Giá
                    <span class="required">*</span>
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    min="0"
                    step="0.01"
                    placeholder="Nhập giá sản phẩm"
                    required
                >

                <span class="help-text">
                    Giá sản phẩm tính bằng VNĐ.
                </span>

            </div>


            <!-- QUANTITY -->
            <div class="form-group">

                <label for="quantity">
                    Số lượng
                    <span class="required">*</span>
                </label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="0"
                    placeholder="Nhập số lượng"
                    required
                >

            </div>


            <!-- DESCRIPTION -->
            <div class="form-group">

                <label for="description">
                    Mô tả
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Nhập mô tả sản phẩm..."
                ></textarea>

            </div>


            <!-- BUTTONS -->
            <div class="buttons">

                <button
                    type="submit"
                    class="submit-button"
                >
                    + Thêm sản phẩm
                </button>

                <a
                    href="/"
                    class="cancel-button"
                >
                    Hủy
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html><?php }
}
