<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user= User::find($this->id);

        return [
            'id' => $this->id,
            'surname' => $this->surname,
            'first_name' => ucfirst($this->first_name),
            'last_name' => ucfirst($this->last_name),
            'username' => $this->username,
            'email' => $this->email,
            'business_id' => $this->business_id,
            'language' => $this->language,
            'roles' =>$this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->map(function($value){
                return $value->name;
            }),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'user_business_location' => auth()->user()->Business?auth()->user()->Business->location:'',
        ];
    }
}
