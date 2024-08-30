<?php

namespace App\Http\Controllers;

use App\Helpers\FakerHelper;
use App\Models\Endpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    public function response(Request $request)
    {
        $url = str_replace('api/', '', $request->route()->uri());
        $endpoint = Endpoint::where('url', $url)->first();
        return FakerHelper::transform($endpoint->data);
        do
        {
            $data = FakerHelper::transform($endpoint->data);
        }
        while (FakerHelper::transformJson($endpoint->data) != $data);

        return $data;
    }
}
