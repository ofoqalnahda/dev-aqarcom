<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return [
            'name' => $this->name,
            'show_outside' => $this->show_outside,
            'type' => $this->type,
            'image' => get_file($this->image),
            // 'values' => $this->type == 'multi' ? $this->translateValues($this->pivot->values): [(object) json_decode($this->pivot->values)],
            'values' => $this->type == 'multi' ?json_decode($this->pivot->values): [(object) json_decode($this->pivot->values)],

        ];
    }
    // protected function translateValues($valuesJson)
    // {
    //     $values = json_decode($valuesJson, true);
    //     $currentLocale = app()->getLocale();
    //     $fallbackLocale = config('app.fallback_locale', 'en');
    //     $translatedValues = [];

    //     foreach ($values as $value) {
    //         $translatedValue = $value[$currentLocale] ?? $value[$fallbackLocale] ?? null;
    //         if ($translatedValue !== null) {
    //             $translatedValues[] = $translatedValue;
    //         }
    //     }

    //     return $translatedValues;
    // }
}
