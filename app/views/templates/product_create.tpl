<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thêm sản phẩm - Product CMS</title>

    <link rel="stylesheet" href="/assets/css/product_create.css">
</head>

<body>

<!-- HEADER -->
<div class="header">

    <h2>Product CMS</h2>

    <div class="user-info">

        <span>
            Xin chào,
            <strong>{$username|escape}</strong>
        </span>

        <form method="POST" action="{$logoutUrl|escape}">
            <input type="hidden" name="csrf_token" value="{$csrfToken|escape}">
            <button type="submit" class="logout">Đăng xuất</button>
        </form>

    </div>

</div>


<!-- MAIN -->
<div class="container">

    <!-- TITLE -->
    <div class="title-row">

        <h1>Thêm sản phẩm</h1>

        <a href="{$listUrl|escape}" class="back-button">
            ← Quay lại
        </a>

    </div>


    <!-- FORM -->
    <div class="form-card">

        <p class="form-description">
            Nhập thông tin sản phẩm mới vào hệ thống.
        </p>


        <!-- ERROR -->
        {if $error}

            <div class="error" role="alert">
                {$error|escape}
            </div>

        {/if}


        <form
            method="POST"
            action="{$createUrl|escape}"
        >
            <input type="hidden" name="csrf_token" value="{$csrfToken|escape}">

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
                    value="{$product.name|escape}"
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
                    value="{$product.price|escape}"
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
                    value="{$product.quantity|escape}"
                    min="0"
                    step="1"
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
                >{$product.description|escape}</textarea>

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
                    href="{$listUrl|escape}"
                    class="cancel-button"
                >
                    Hủy
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
