<?php

namespace App\Helpers;

use App\Models\EndpointObject;

class FakerHelper
{
    public static function fieldTypes(): array
    {
        $objects = \Auth::user()->endpointObjects()->get()->pluck('name')->toArray();
        return ['Number', 'String', ...array_values($objects)];
    }

    public static function transform($json)
    {
        // Декодируем входной JSON
        $data = json_decode($json, true);

        $result = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Определяем тип данных
                if ($key === 'Number') {
                    // Если это числа, добавляем их как есть
                    $result[$value[0]] = (int)$value[1];
                } elseif ($key === 'String') {
                    // Если это строки, добавляем их как пары ключ-значение
                    $result[$value[0]] = $value[1];
                }
            } else {
                // Обработка объектов
                $endpointObject = EndpointObject::where('name', $key)->first();
                if ($endpointObject) {
                    $result[$key] = $endpointObject->data;
                } else {
                    $result[$key] = 'Object not found';
                }
            }
        }

        // Кодируем результат в JSON
        return json_encode($result);
    }
    public static function patterns(): array
    {
        return ['name', 'email', 'date'];
    }
}
