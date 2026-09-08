<?php
/* Smarty version 5.8.4, created on 2026-09-08 07:33:21
  from 'file:product_edit.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.4',
  'unifunc' => 'content_6a9fba4198da01_77838276',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b53af34f7058e94b965808b4ad19fffd600608f' => 
    array (
      0 => 'product_edit.tpl',
      1 => 1788852643,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a9fba4198da01_77838276 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\product-cms\\app\\views\\templates';
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sửa sản phẩm - Product CMS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
            color: #333;
        }

        .header {
            background: #333;
            color: white;
            padding: 18px 40px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .container {
            max-width: 750px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .page-title {
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 26px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .error {
            background: #ffe0e0;
            color: #c00;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #ddd;
            color: #000;
        }

        .btn-secondary:hover {
            background: #ccc;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Product CMS</h1>
</div>

<div class="container">

    <div class="card">

        <h2 class="page-title">Sửa sản phẩm</h2>

        <?php if ($_smarty_tpl->getValue('error')) {?>
            <div class="error">
                <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('error'), ENT_QUOTES, 'UTF-8', true);?>

            </div>
        <?php }?>

        <form method="POST" action="/products/edit?id=<?php echo $_smarty_tpl->getValue('product')['id'];?>
">

            <div class="form-group">
                <label for="name">Tên sản phẩm</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('product')['name'], ENT_QUOTES, 'UTF-8', true);?>
"
                    required
                >
            </div>

            <div class="form-group">
                <label for="price">Giá</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="<?php echo $_smarty_tpl->getValue('product')['price'];?>
"
                    min="0"
                    step="0.01"
                    required
                >
            </div>

            <div class="form-group">
                <label for="quantity">Số lượng</label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="<?php echo $_smarty_tpl->getValue('product')['quantity'];?>
"
                    min="0"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>

                <textarea
                    id="description"
                    name="description"
                ><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('product')['description'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
            </div>

            <div class="buttons">

                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>

                <a href="/" class="btn btn-secondary">
                    Quay lại
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html><?php }
}
