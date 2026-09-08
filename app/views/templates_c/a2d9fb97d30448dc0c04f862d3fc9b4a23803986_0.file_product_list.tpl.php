<?php
/* Smarty version 5.8.4, created on 2026-09-08 08:44:35
  from 'file:product_list.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.4',
  'unifunc' => 'content_6a9fcaf3e2a474_09434277',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a2d9fb97d30448dc0c04f862d3fc9b4a23803986' => 
    array (
      0 => 'product_list.tpl',
      1 => 1788857069,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a9fcaf3e2a474_09434277 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\product-cms\\app\\views\\templates';
?><!DOCTYPE html>
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
                    <strong><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('username'), ENT_QUOTES, 'UTF-8', true);?>
</strong>
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

        <?php if ($_smarty_tpl->getValue('success') == 'created') {?>
            <div class="success">
                Thêm sản phẩm thành công.
            </div>
        <?php }?>

        <?php if ($_smarty_tpl->getValue('success') == 'updated') {?>
            <div class="success">
                Cập nhật sản phẩm thành công.
            </div>
        <?php }?>

        <?php if ($_smarty_tpl->getValue('success') == 'deleted') {?>
            <div class="success">
                Xóa sản phẩm thành công.
            </div>
        <?php }?>

        <section class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Tổng sản phẩm</div>
                <div class="summary-value"><?php echo $_smarty_tpl->getValue('totalProducts');?>
</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Tổng số lượng</div>
                <div class="summary-value"><?php echo $_smarty_tpl->getValue('totalQuantity');?>
</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Giá trị hàng hóa</div>
                <div class="summary-value">
                    <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('totalValue'),0,',','.');?>
 VNĐ
                </div>
            </div>
        </section>

        <section class="search-box">
            <form method="GET" action="/">
                <input
                    type="text"
                    name="keyword"
                    value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('keyword'), ENT_QUOTES, 'UTF-8', true);?>
"
                    placeholder="Tìm theo tên hoặc mô tả..."
                >

                <button type="submit" class="search-button">
                    Tìm kiếm
                </button>

                <?php if ($_smarty_tpl->getValue('keyword')) {?>
                    <a href="/" class="clear-button">
                        Xóa lọc
                    </a>
                <?php }?>
            </form>
        </section>

        <div class="result-count">
            Tìm thấy <strong><?php echo $_smarty_tpl->getValue('totalProducts');?>
</strong> sản phẩm
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
                    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('products')) > 0) {?>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('products'), 'product');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('product')->value) {
$foreach0DoElse = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->getValue('product')['id'];?>
</td>

                                <td>
                                    <strong><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('product')['name'], ENT_QUOTES, 'UTF-8', true);?>
</strong>
                                </td>

                                <td class="price">
                                    <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('product')['price'],0,',','.');?>

                                    VNĐ
                                </td>

                                <td>
                                    <span class="quantity-badge">
                                        <?php echo $_smarty_tpl->getValue('product')['quantity'];?>

                                    </span>
                                </td>

                                <td>
                                    <div class="description">
                                        <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('product')['description'], ENT_QUOTES, 'UTF-8', true);?>

                                    </div>
                                </td>

                                <td class="actions">
                                    <a
                                        href="/products/edit?id=<?php echo $_smarty_tpl->getValue('product')['id'];?>
"
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
                                            value="<?php echo $_smarty_tpl->getValue('product')['id'];?>
"
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
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="empty">
                                Không tìm thấy sản phẩm nào.
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </section>

        <?php if ($_smarty_tpl->getValue('totalPages') > 1) {?>
            <nav class="pagination">
                <?php if ($_smarty_tpl->getValue('page') > 1) {?>
                    <a href="/?page=<?php echo $_smarty_tpl->getValue('page')-1;?>
&keyword=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('keyword'), ENT_QUOTES, 'UTF-8', true);?>
">
                        Trước
                    </a>
                <?php }?>

                <?php
$_smarty_tpl->assign('i', []);$_smarty_tpl->getVariable('i')->step = 1;$_smarty_tpl->getVariable('i')->total = (int) ceil(($_smarty_tpl->getVariable('i')->step > 0 ? $_smarty_tpl->getValue('totalPages')+1 - (1) : 1-($_smarty_tpl->getValue('totalPages'))+1)/abs($_smarty_tpl->getVariable('i')->step));
if ($_smarty_tpl->getVariable('i')->total > 0) {
for ($_smarty_tpl->getVariable('i')->value = 1, $_smarty_tpl->getVariable('i')->iteration = 1;$_smarty_tpl->getVariable('i')->iteration <= $_smarty_tpl->getVariable('i')->total;$_smarty_tpl->getVariable('i')->value += $_smarty_tpl->getVariable('i')->step, $_smarty_tpl->getVariable('i')->iteration++) {
$_smarty_tpl->getVariable('i')->first = $_smarty_tpl->getVariable('i')->iteration === 1;$_smarty_tpl->getVariable('i')->last = $_smarty_tpl->getVariable('i')->iteration === $_smarty_tpl->getVariable('i')->total;?>
                    <?php if ($_smarty_tpl->getValue('i') == $_smarty_tpl->getValue('page')) {?>
                        <span class="active"><?php echo $_smarty_tpl->getValue('i');?>
</span>
                    <?php } else { ?>
                        <a href="/?page=<?php echo $_smarty_tpl->getValue('i');?>
&keyword=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('keyword'), ENT_QUOTES, 'UTF-8', true);?>
">
                            <?php echo $_smarty_tpl->getValue('i');?>

                        </a>
                    <?php }?>
                <?php }
}
?>

                <?php if ($_smarty_tpl->getValue('page') < $_smarty_tpl->getValue('totalPages')) {?>
                    <a href="/?page=<?php echo $_smarty_tpl->getValue('page')+1;?>
&keyword=<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('keyword'), ENT_QUOTES, 'UTF-8', true);?>
">
                        Sau
                    </a>
                <?php }?>
            </nav>
        <?php }?>
    </main>
</body>
</html><?php }
}
