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
        return [
            'id'   => $this->id,
            'logo'   => storage_path().'/public/images/companies'.$this->logo,
            'name' => $this->name,
            'email' => $this->email,
            'url'   => $this->url
        ];
    }
}
