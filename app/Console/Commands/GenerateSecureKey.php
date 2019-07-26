<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSecureKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Secure Secret Key For JWT Authentication';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $envFile = base_path('.env');

        if(file_exists($envFile))
        {
            $key = bin2hex(random_bytes(32));

            $contents = file_get_contents($envFile);

            if(strpos($contents, 'JWT_KEY='))
            {
                $this->info('You Already Have The Key!');
            }
            else
            {
                file_put_contents($envFile, 'JWT_KEY=' . $key, FILE_APPEND);

                $this->info('Key Was Created Successfuly!');
            }
        }
        else
        {
            $this->error('Environment File Does Not Exists.Create It First!');
        }
    }
}
