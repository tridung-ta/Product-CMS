<?php

namespace App\Validation;

final class ProductInput
{
    public static function fromArray(array $input): array
    {
        $values = [];
        foreach (['name', 'price', 'quantity', 'description'] as $field) {
            $raw = $input[$field] ?? '';
            $values[$field] = is_string($raw) ? trim($raw) : '';
            if (array_key_exists($field, $input) && !is_string($raw)) {
                $values['_invalid'] = true;
            }
        }
        return $values;
    }

    public static function error(array $values): string
    {
        if (!empty($values['_invalid'])) {
            return 'Dữ liệu sản phẩm không hợp lệ.';
        }
        $name = $values['name'] ?? '';
        $price = $values['price'] ?? '';
        $quantity = $values['quantity'] ?? '';
        $description = $values['description'] ?? '';

        if ($name === '') {
            return 'Vui lòng nhập tên sản phẩm.';
        }
        if (!mb_check_encoding($name, 'UTF-8') || mb_strlen($name, 'UTF-8') > 255) {
            return 'Tên sản phẩm không được vượt quá 255 ký tự.';
        }
        if (!preg_match('/\A[0-9]+(?:\.[0-9]{1,2})?\z/', $price)
            || strlen(ltrim(explode('.', $price, 2)[0], '0')) > 10) {
            return 'Giá phải từ 0 đến 9.999.999.999,99 và có tối đa 2 chữ số thập phân.';
        }
        $digits = ltrim($quantity, '0');
        if (!preg_match('/\A[0-9]+\z/', $quantity) || strlen($digits) > 10
            || (strlen($digits) === 10 && strcmp($digits, '2147483647') > 0)) {
            return 'Số lượng phải là số nguyên từ 0 đến 2.147.483.647.';
        }
        if (!mb_check_encoding($description, 'UTF-8') || strlen($description) > 65535) {
            return 'Mô tả sản phẩm quá dài hoặc không hợp lệ.';
        }
        return '';
    }
}
