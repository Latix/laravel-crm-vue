<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        http://workwise.local/storage/images/companies/b788ded6_CHCOFE416DSN.png?mod=1614093176
        return [
            'id'   => $this->id,
            'logo'   => asset('/storage/images/companies/'.$this->logo),
            'name' => $this->name,
            'email' => $this->email,
            'url'   => $this->url
        ];
    }
}
