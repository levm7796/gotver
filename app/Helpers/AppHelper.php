<?php

namespace App\Helpers;

use Carbon\Carbon;

class AppHelper
{
    public function formatDate($date)
    {
        return Carbon::parse($date)->locale('ru')->isoFormat('D MMMM YYYY');
    }

    public static function instance()
    {
        return new AppHelper();
    }

    function groupOldValues($default = []) {
        // Получаем старые значения формы
        $oldValues = old();

        // Фильтруем значения, которые начинаются с place_ или icon_
        $filtered = array_filter($oldValues, function ($key) {
            return str_starts_with($key, 'place_') || str_starts_with($key, 'icon_');
        }, ARRAY_FILTER_USE_KEY);

        // Инициализируем массив для сгруппированных данных
        $grouped = [];

        // Группируем значения по их индексу
        foreach ($filtered as $key => $value) {
            // Извлекаем индекс из ключа (например, place_1 и icon_1 -> 1)
            $index = str_replace(['place_', 'icon_'], '', $key);

            if (!isset($grouped[$index])) {
                $grouped[$index] = ['place' => null, 'icon' => null];
            }

            if (str_starts_with($key, 'place_')) {
                $grouped[$index]['place'] = $value;
            } elseif (str_starts_with($key, 'icon_')) {
                $grouped[$index]['icon'] = $value;
            }
        }

        // Возвращаем сгруппированные данные или параметры по умолчанию, если массив пустой
        return !empty($grouped) ? $grouped : $default;
    }
}
