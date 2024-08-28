<?php

namespace App\Helpers;

class FakerHelper
{
    public static function fieldTypes(): array
    {
        $objects = \Auth::user()->endpointObjects()->get()->pluck('name')->toArray();
        return ['Number', 'String', ...array_values($objects)];
    }
    public static function methods(): array
    {
        return ['name', 'email', 'date'];
    }
}
