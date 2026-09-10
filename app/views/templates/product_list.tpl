<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product CMS</title>

    <link rel="stylesheet" href="/assets/css/product_list.css">
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

                <form method="POST" action="{$logoutUrl|escape}">
                    <input type="hidden" name="csrf_token" value="{$csrfToken|escape}">
                    <button type="submit" class="logout-button">Đăng xuất</button>
                </form>
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

            <a href="{$createUrl|escape}" class="add-button">
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
                <div class="summary-value">{$summaryProducts|escape}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Tổng số lượng</div>
                <div class="summary-value">{$totalQuantity|escape}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Giá trị hàng hóa</div>
                <div class="summary-value">
                    {$totalValue|money} VNĐ
                </div>
            </div>
        </section>

        <section class="search-box">
            <form method="GET" action="/admin.php">
                <input type="hidden" name="module" value="manage">
                <input type="hidden" name="entity" value="product">
                <input type="hidden" name="action" value="list">
                <input
                    type="text"
                    name="keyword"
                    value="{$keyword|escape}"
                    placeholder="Tìm theo tên hoặc mô tả..."
                    aria-label="Tìm theo tên hoặc mô tả sản phẩm"
                >

                <button type="submit" class="search-button">
                    Tìm kiếm
                </button>

                {if $keyword !== ''}
                    <a href="{$listUrl|escape}" class="clear-button">
                        Xóa lọc
                    </a>
                {/if}
            </form>
        </section>

        <div class="result-count">
            Tìm thấy <strong>{$totalProducts|escape}</strong> sản phẩm
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
                                <td>{$product.id|escape}</td>

                                <td>
                                    <strong>{$product.name|escape}</strong>
                                </td>

                                <td class="price">
                                    {$product.price|money}
                                    VNĐ
                                </td>

                                <td>
                                    <span class="quantity-badge">
                                        {$product.quantity|escape}
                                    </span>
                                </td>

                                <td>
                                    <div class="description">
                                        {$product.description|escape}
                                    </div>
                                </td>

                                <td class="actions">
                                    <a
                                        href="{$editUrl|escape}&amp;id={$product.id|escape}"
                                        class="edit-button"
                                    >
                                        Sửa
                                    </a>

                                    <form
                                        method="POST"
                                        action="{$deleteUrl|escape}"
                                        class="delete-form"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                                    >
                                        <input type="hidden" name="csrf_token" value="{$csrfToken|escape}">
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="{$product.id|escape}"
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
            <nav class="pagination" aria-label="Phân trang sản phẩm">
                {if $previousUrl}
                    <a href="{$previousUrl|escape}" rel="prev">
                        Trước
                    </a>
                {/if}

                {foreach $pagination as $item}
                    {if $item.page === null}
                        <span class="ellipsis" aria-hidden="true">…</span>
                    {elseif $item.active}
                        <span class="active" aria-current="page">{$item.page|escape}</span>
                    {else}
                        <a href="{$item.url|escape}">
                            {$item.page|escape}
                        </a>
                    {/if}
                {/foreach}

                {if $nextUrl}
                    <a href="{$nextUrl|escape}" rel="next">
                        Sau
                    </a>
                {/if}
            </nav>
        {/if}
    </main>
</body>
</html>
