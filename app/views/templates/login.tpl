<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập - Product CMS</title>

    <link rel="stylesheet" href="/assets/css/login.css">
</head>

<body>

<div class="galaxy" aria-hidden="true"></div>

<div class="login-box">

    <div class="logo">
        ✦
    </div>

    <h1>Product CMS</h1>

    <div class="subtitle">
        Đăng nhập vào hệ thống quản lý
    </div>

    {if $error}
        <div class="error" role="alert">
            {$error|escape}
        </div>
    {/if}

    <form method="POST" action="{$loginUrl|escape}">
        <input type="hidden" name="csrf_token" value="{$csrfToken|escape}">

        <div class="input-group">

            <label for="username">
                Tên đăng nhập
            </label>

            <input
                type="text"
                id="username"
                name="username"
                value="{$loginUsername|escape}"
                placeholder="Nhập tên đăng nhập"
                autocomplete="username"
                required
            >

        </div>

        <div class="input-group">

            <label for="password">
                Mật khẩu
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Nhập mật khẩu"
                autocomplete="current-password"
                required
            >

        </div>

        <button type="submit">
            Đăng nhập
        </button>

    </form>

    <div class="footer">
        Product CMS &copy; 2026
    </div>

</div>

</body>
</html>
