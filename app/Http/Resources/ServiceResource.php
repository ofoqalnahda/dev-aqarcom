<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City;
class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return =[
            'id' => $this->id,
            'name' => $this->name,
            'image' => get_file($this->image),
            'is_val_required'=> $this->is_val_required,
//            'type' => $this->type,
        ];
        
        if($request->input('without') != 'users'){
            $return['users'] = UserWithoutSubscription::collection($this->users()->when($request->city_id , function ($q) use ($request){ 
                $q->where('user_service.city_id', $request->city_id);
                })->when( $request->text != null ,function ($q) use ($request){
                return $q->where('name','like', '%' . $request->text . '%')->orwhere(function ($q_u) use ($request){
                    $q_u->wherehas('servicesCity',function ($q_serv) use ($request){ 
                        $q_serv->whereTranslationLike('name', '%' . $request->text . '%');
                    });
                } );
                
            })->get()->unique('id'));
        }
        return $return;
    }
}
