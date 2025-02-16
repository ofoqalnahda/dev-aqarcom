<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;
use \Illuminate\Support\Facades\Storage;

function get_file($filename): string
{

    $logo = Cache::remember('logo', 300, function () {
        return Setting::first()->default_image ?? 'adDefault.png';
    });

    if (!$filename) {
        return url("uploads/{$logo}");
    }

    return url('uploads/' . $filename);
}

function file_uploader($file, $folder = '/'): string
{
    return Storage::disk('public_uploads')->putFile($folder, $file);
}

function image_uploader_with_resize($file, $folder = '', $width = 300, $height = 300): string
{
    $path = 'uploads/' . $folder;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    Image::make($file)
        ->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($path . '/' . $file->hashName()));
    return $folder . '/' . $file->hashName();
}

function image_uploader_without_resize($file, $folder = '', $oldFile = null): string
{
    if ($oldFile) {
        Storage::disk('public_uploads')->delete($oldFile);
    }

    $path = 'uploads/' . $folder;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    $img = Image::make($file)->save(public_path($path . '/' . $file->hashName()));

    return $folder . '/' . $file->hashName();
}

function format_field_names($name, $details)
{
    return [
        'name' => $name,
        'details' => $details,
    ];
}

function deleteFiles(?array $files)
{
    if (!$files) {
        return;
    }

    foreach ($files as $file) {
        Storage::disk('public_uploads')->delete($file);
    }

}

function generate_verification_code(): int
{
    return rand(1000, 9999);
}

function convert_to_english_numbers($number)
{
    return (int) strtr($number, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
}

function getNearest($model, $lat, $lng)
{
    $items = new $model();
    return $items->select("*", DB::raw("6371 * acos(cos(radians(" . $lat . "))
        * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))
        + sin(radians(" . $lat . ")) * sin(radians(lat))) AS distance"));
    //->having("distance", "<", $radius)

}

function distance($lat1, $lon1, $lat2, $lon2): float
{
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lon1 *= $pi80;
    $lat2 *= $pi80;
    $lon2 *= $pi80;
    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;
    //echo ' '.$km;
    return $km;
}

function appendPathToImages(?array $images): array
{
    $imagesWithPath = [];

    foreach ((array) $images as $image) {
        $imagesWithPath[] = get_file($image);
    }

    if (empty($imagesWithPath)) {
        $imagesWithPath[] = get_file('');
    }

    return $imagesWithPath;
}


function appendPathToImagesWithId(?array $images): array
{
    $imagesWithPath = [];

    foreach ($images as $key=>$image) {
        $imagesWithPath[$key] = get_file($image);
    }
    
    return $imagesWithPath;
}
function appendPathToImagesGallery(?array $images): array
{
    $imagesWithPath = [];
//    dd($images[0]->image);
    foreach ((array) $images as $key =>$image) {
        if($image instanceof stdClass){
            $title = $image->title;
            $image = $image->image;
        }
        else{
            $title='';
        }
        $imagesWithPath[$key]['image'] = get_file($image);
        $imagesWithPath[$key]['title'] = $title;
    }
//    dd($imagesWithPath);
    return $imagesWithPath;
}

function generateRandomString(): string
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $numbers = '0123456789';
    $numbersLength = strlen($numbers);
    $randomString = '';
    while (\App\Models\Marketer::where('code', $randomString)->count() || $randomString == '') {
        $randomString = '';
        $randomString .= $numbers[random_int(0, $numbersLength - 1)];
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    }

    return $randomString;
}

function changeLocale(string $locale)
{
    return [
        'ar' => 'en',
        'en' => 'ar',
    ][$locale];
}

function categorizePermissions()
{
    $groupedPermissions = [];

    $permissions = Permission::get();

    foreach ($permissions as $value) {
        $parts = explode('-', $value->name);

        $key = $parts[0];
        if (count($parts) > 1) {
            $action = $parts[1];

            if (in_array($action, ['index', 'create', 'edit', 'destroy', 'show', 'update', 'store'])) {
                $groupedPermissions[$key][$action] = $value;
            } else {
                $groupedPermissions[$key]['extra'][] = $value;
            }
        } else {
            $groupedPermissions[$key]['extra'][] = $value;
        }
    }

    return $groupedPermissions;
}
function actions()
{
    $actions=[
        'index',
        'create',
        'edit',
        'destroy',
        'show',
        'extra',
    ];
    return $actions;
}


function server_cache($key, $time, $callback)
{

//    dd(request()->query->count());
    if (!env('CACHE_ENABLED') || request()->query->count()) {
        return $callback();
    }

    $time = env( $time == 'long' ? "CACHE_LONG_TIME" : "CACHE_SHORT_TIME" , 60);

    return Cache::remember($key, $time, $callback);
}
