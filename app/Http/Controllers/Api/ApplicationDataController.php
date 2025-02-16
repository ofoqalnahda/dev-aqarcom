<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationDataResource;
use App\Models\Setting;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ApplicationDataController extends Controller
{
    use ResponseTrait;
    public function __invoke()
    {
        $appData = server_cache(class_basename(Setting::class), 'long', fn() =>
            Setting::first()
        );

        return $this->successResponse(data:ApplicationDataResource::make($appData));
    }
}
