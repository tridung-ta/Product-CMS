<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sửa sản phẩm - Product CMS</title>

    <link rel="stylesheet" href="/assets/css/product_edit.css">
</head>

<body>

<div class="header">
    <h1>Product CMS</h1>
</div>

<div class="container">

    <div class="card">

        <h2 class="page-title">Sửa sản phẩm</h2>

        {if $error}
            <div class="error" role="alert">
                {$error|escape}
            </div>
        {/if}

        <form method="POST" action="{$editUrl|escape}&amp;id={$product.id|escape}">
            <input type="hidden" name="csrf_token" value="{$csrfToken|escape}">

            <div class="form-group">
                <label for="name">Tên sản phẩm</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{$product.name|escape}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="price">Giá</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{$product.price|escape}"
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
                    value="{$product.quantity|escape}"
                    min="0"
                    step="1"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>

                <textarea
                    id="description"
                    name="description"
                >{$product.description|escape}</textarea>
            </div>

            <div class="buttons">

                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>

                <a href="{$listUrl|escape}" class="btn btn-secondary">
                    Quay lại
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
