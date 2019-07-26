<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    private $jwtToken;

    public function __construct($resource, $jwtToken)
    {
        parent::__construct($resource);

        $this->resource = $resource;

        $this->jwtToken = $jwtToken;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            
            'firstName' => $this->first_name,

            'lastName' => $this->last_name,

            'name' => $this->name,

            'username' => $this->username,

            'email' => $this->email,

            'phone' => $this->phone,

            'createdAt' => $this->created_at->toDateTimeString(),

            'updatedAt' => $this->updated_at->toDateTimeString(),

            'profilePic' => $this->profile_picture,

            'token' => $this->jwtToken,
        ];
    }
}
