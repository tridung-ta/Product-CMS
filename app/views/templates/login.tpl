<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập - Product CMS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            width: 100%;
            min-height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;

            background:
                radial-gradient(circle at 20% 20%, rgba(91, 33, 182, 0.45), transparent 30%),
                radial-gradient(circle at 80% 30%, rgba(37, 99, 235, 0.35), transparent 30%),
                radial-gradient(circle at 50% 80%, rgba(124, 58, 237, 0.3), transparent 35%),
                linear-gradient(135deg, #020617, #0f172a 45%, #111827);
        }

        /* Galaxy stars */
        body::before {
            content: "";
            position: absolute;
            inset: 0;

            background-image:
                radial-gradient(circle, white 1px, transparent 1px),
                radial-gradient(circle, rgba(255,255,255,0.8) 1px, transparent 1px),
                radial-gradient(circle, rgba(147,197,253,0.8) 1px, transparent 1px);

            background-size:
                90px 90px,
                140px 140px,
                200px 200px;

            background-position:
                10px 20px,
                40px 80px,
                100px 30px;

            opacity: 0.35;
            pointer-events: none;
        }

        /* Galaxy glow */
        .galaxy {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;

            background:
                radial-gradient(
                    ellipse,
                    rgba(139, 92, 246, 0.18),
                    rgba(59, 130, 246, 0.08) 40%,
                    transparent 70%
                );

            filter: blur(20px);
            transform: rotate(-25deg);
        }

        .login-box {
            position: relative;
            z-index: 2;

            width: 400px;
            padding: 40px;

            background: rgba(15, 23, 42, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 18px;

            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.45),
                0 0 40px rgba(99, 102, 241, 0.15);

            color: white;
        }

        .logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                linear-gradient(135deg, #6366f1, #8b5cf6);

            box-shadow:
                0 0 25px rgba(99, 102, 241, 0.65);

            font-size: 30px;
        }

        h1 {
            text-align: center;
            margin: 0;

            font-size: 28px;
            letter-spacing: 0.5px;
        }

        .subtitle {
            text-align: center;
            color: #cbd5e1;
            margin-top: 8px;
            margin-bottom: 30px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 8px;

            color: #e2e8f0;
            font-size: 14px;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 13px 15px;

            background: rgba(255, 255, 255, 0.07);
            color: white;

            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 8px;

            font-size: 15px;

            transition: 0.2s;
        }

        input::placeholder {
            color: #94a3b8;
        }

        input:focus {
            outline: none;

            border-color: #818cf8;

            background: rgba(255, 255, 255, 0.1);

            box-shadow:
                0 0 0 3px rgba(99, 102, 241, 0.15),
                0 0 15px rgba(99, 102, 241, 0.15);
        }

        button {
            width: 100%;
            padding: 13px;

            border: none;
            border-radius: 8px;

            background:
                linear-gradient(135deg, #4f46e5, #7c3aed);

            color: white;

            font-size: 16px;
            font-weight: bold;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(79, 70, 229, 0.35);

            transition: 0.2s;
        }

        button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 10px 25px rgba(99, 102, 241, 0.5);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            padding: 12px 14px;
            margin-bottom: 20px;

            border-radius: 8px;

            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(248, 113, 113, 0.35);

            color: #fca5a5;

            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;

            color: #64748b;
            font-size: 12px;
        }

        @media (max-width: 500px) {
            .login-box {
                width: calc(100% - 30px);
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>

<div class="galaxy"></div>

<div class="login-box">

    <div class="logo">
        ✦
    </div>

    <h1>Product CMS</h1>

    <div class="subtitle">
        Đăng nhập vào hệ thống quản lý
    </div>

    {if $error}
        <div class="error">
            {$error|escape}
        </div>
    {/if}

    <form method="POST" action="/login">

        <div class="input-group">

            <label for="username">
                Tên đăng nhập
            </label>

            <input
                type="text"
                id="username"
                name="username"
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