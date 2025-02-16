<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValRequest;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ValLicenseController extends Controller
{
    use ResponseTrait;

    public function store(ValRequest $request)
    {
        $user = auth()->user();
        $path = $request->file('val_license')->store('val_licenses', 'public_uploads');
        if ($user->val_license) {
            Storage::disk('public_uploads')->delete($user->val_license);
        }
        if ($path) {
            $user->update([
                'val_license' => $path,
            ]);
        } else {
            return $this->failedResponse(__('something_went_wrong'));
        }
        return $this->successResponse(__('added_successfully'), ['val_license' => get_file($user->val_license)]);

    }

}
