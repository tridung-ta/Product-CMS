<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product CMS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #1f2937;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .header {
            color: white;
            padding: 18px 5%;
            background: #172033;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1280px;
            margin: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 21px;
            font-weight: bold;
        }

        .brand-mark {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            color: #172033;
            background: #fbbf24;
            border-radius: 10px;
            font-weight: bold;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 14px;
        }

        .logout-button {
            padding: 9px 14px;
            color: white;
            background: #ef4444;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-button:hover {
            background: #dc2626;
        }

        .container {
            width: min(1280px, calc(100% - 32px));
            margin: 32px auto;
        }

        .title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .title-row h1 {
            margin: 0;
            font-size: 28px;
        }

        .subtitle {
            margin: 7px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .add-button {
            padding: 11px 16px;
            color: white;
            background: #16a34a;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .add-button:hover {
            background: #15803d;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .summary-card {
            padding: 20px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
        }

        .summary-label {
            color: #6b7280;
            font-size: 13px;
        }

        .summary-value {
            margin-top: 8px;
            color: #172033;
            font-size: 25px;
            font-weight: bold;
        }

        .success {
            margin-bottom: 20px;
            padding: 13px 16px;
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            padding: 18px;
            margin-bottom: 20px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        .search-box form {
            display: flex;
            flex: 1;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            min-width: 0;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 15px;
        }

        .search-box input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .search-button,
        .clear-button {
            padding: 11px 16px;
            border: 0;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
        }

        .search-button {
            color: white;
            background: #2563eb;
        }

        .clear-button {
            color: #374151;
            background: #e5e7eb;
        }

        .table-card {
            overflow-x: auto;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        th {
            padding: 14px 16px;
            color: white;
            background: #172033;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #eef0f3;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .price {
            color: #15803d;
            font-weight: bold;
            white-space: nowrap;
        }

        .quantity-badge {
            display: inline-block;
            min-width: 42px;
            padding: 5px 9px;
            color: #1d4ed8;
            background: #dbeafe;
            border-radius: 999px;
            text-align: center;
            font-weight: bold;
        }

        .description {
            max-width: 260px;
            overflow: hidden;
            color: #6b7280;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .actions {
            white-space: nowrap;
        }

        .edit-button,
        .delete-button {
            display: inline-block;
            padding: 8px 12px;
            border: 0;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
        }

        .edit-button {
            background: #2563eb;
        }

        .delete-button {
            margin-left: 5px;
            background: #dc2626;
        }

        .edit-button:hover {
            background: #1d4ed8;
        }

        .delete-button:hover {
            background: #b91c1c;
        }

        .empty {
            padding: 40px;
            color: #6b7280;
            text-align: center;
        }

        .result-count {
            margin: 14px 0;
            color: #6b7280;
            font-size: 14px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 24px;
        }

        .pagination a,
        .pagination span {
            display: grid;
            min-width: 38px;
            height: 38px;
            padding: 0 11px;
            place-items: center;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            color: #2563eb;
            background: white;
            text-decoration: none;
        }

        .pagination .active {
            color: white;
            background: #2563eb;
            border-color: #2563eb;
            font-weight: bold;
        }

        @media (max-width: 700px) {
            .header-content,
            .title-row,
            .user-area {
                align-items: flex-start;
            }

            .header-content,
            .title-row {
                flex-direction: column;
            }

            .user-area {
                width: 100%;
                justify-content: space-between;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .search-box form {
                flex-direction: column;
            }

            .search-button,
            .clear-button {
                width: 100%;
                text-align: center;
            }

            .container {
                width: min(100% - 20px, 1280px);
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <div class="brand">
                <span class="brand-mark">P</span>
                <span>Product CMS</span>
            </div>

            <div class="user-area">
                <span>
                    Xin chào,
                    <strong>{$username|escape}</strong>
                </span>

                <a href="/logout" class="logout-button">
                    Đăng xuất
                </a>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="title-row">
            <div>
                <h1>Quản lý sản phẩm</h1>
                <p class="subtitle">
                    Theo dõi sản phẩm và giá trị kho hàng
                </p>
            </div>

            <a href="/products/create" class="add-button">
                + Thêm sản phẩm
            </a>
        </div>

        {if $success == 'created'}
            <div class="success">
                Thêm sản phẩm thành công.
            </div>
        {/if}

        {if $success == 'updated'}
            <div class="success">
                Cập nhật sản phẩm thành công.
            </div>
        {/if}

        {if $success == 'deleted'}
            <div class="success">
                Xóa sản phẩm thành công.
            </div>
        {/if}

        <section class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Tổng sản phẩm</div>
                <div class="summary-value">{$totalProducts}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Tổng số lượng</div>
                <div class="summary-value">{$totalQuantity}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Giá trị hàng hóa</div>
                <div class="summary-value">
                    {$totalValue|number_format:0:',':'.'} VNĐ
                </div>
            </div>
        </section>

        <section class="search-box">
            <form method="GET" action="/">
                <input
                    type="text"
                    name="keyword"
                    value="{$keyword|escape}"
                    placeholder="Tìm theo tên hoặc mô tả..."
                >

                <button type="submit" class="search-button">
                    Tìm kiếm
                </button>

                {if $keyword}
                    <a href="/" class="clear-button">
                        Xóa lọc
                    </a>
                {/if}
            </form>
        </section>

        <div class="result-count">
            Tìm thấy <strong>{$totalProducts}</strong> sản phẩm
        </div>

        <section class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    {if $products|@count > 0}
                        {foreach $products as $product}
                            <tr>
                                <td>{$product.id}</td>

                                <td>
                                    <strong>{$product.name|escape}</strong>
                                </td>

                                <td class="price">
                                    {$product.price|number_format:0:',':'.'}
                                    VNĐ
                                </td>

                                <td>
                                    <span class="quantity-badge">
                                        {$product.quantity}
                                    </span>
                                </td>

                                <td>
                                    <div class="description">
                                        {$product.description|escape}
                                    </div>
                                </td>

                                <td class="actions">
                                    <a
                                        href="/products/edit?id={$product.id}"
                                        class="edit-button"
                                    >
                                        Sửa
                                    </a>

                                    <form
                                        method="POST"
                                        action="/products/delete"
                                        style="display: inline;"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                                    >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="{$product.id}"
                                        >

                                        <button
                                            type="submit"
                                            class="delete-button"
                                        >
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr>
                            <td colspan="6" class="empty">
                                Không tìm thấy sản phẩm nào.
                            </td>
                        </tr>
                    {/if}
                </tbody>
            </table>
        </section>

        {if $totalPages > 1}
            <nav class="pagination">
                {if $page > 1}
                    <a href="/?page={$page-1}&keyword={$keyword|escape}">
                        Trước
                    </a>
                {/if}

                {for $i=1 to $totalPages}
                    {if $i == $page}
                        <span class="active">{$i}</span>
                    {else}
                        <a href="/?page={$i}&keyword={$keyword|escape}">
                            {$i}
                        </a>
                    {/if}
                {/for}

                {if $page < $totalPages}
                    <a href="/?page={$page+1}&keyword={$keyword|escape}">
                        Sau
                    </a>
                {/if}
            </nav>
        {/if}
    </main>
</body>
</html>