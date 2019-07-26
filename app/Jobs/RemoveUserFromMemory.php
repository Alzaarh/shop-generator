<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;

class RemoveUserFromMemory extends Job
{
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::del('tempUser:' . $this->email);
    }
}
