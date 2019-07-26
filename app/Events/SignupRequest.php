<?php

namespace App\Events;

class SignupRequest extends Event
{
    public $userData;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->userData = $data;
    }
}
