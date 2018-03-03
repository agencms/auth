<?php

namespace Silvanite\AgencmsAuth\Commands;

use Silvanite\AgencmsAuth\User;
use Illuminate\Console\Command;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agencms:make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user account';

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
        if (!$user = User::create([
            'name' => $this->ask('Full name'),
            'email' => $this->ask('Email address'),
            'password' => $this->secret('Password'),
            'active' => true,
            'api_token' => bcrypt(str_random()),
        ])) {
            $this->error('Could not create user account');
        }

        $this->info('A new user account has been created');
    }
}
