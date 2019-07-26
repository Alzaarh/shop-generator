<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SelectAuthType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'select:auth {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select Which Authentication Types Want To Use';

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
        DB::table('auth_type')->truncate();

        DB::table('auth_type')->insert(['auth_type' => $this->argument('type')]);

        $this->info('Success!');
    }
}
