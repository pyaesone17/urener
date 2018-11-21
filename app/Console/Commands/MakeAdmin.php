<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;
use App\ValidationRules\AdminFormRule;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the admin user for api';

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
    public function handle(Factory $validator) : void
    {
        $name = $this->ask("What is your name");
        $email = $this->ask("What is your email");
        $password = $this->ask("What is your password");

        try {
            $result = $validator->make(
                ['name' => $name,'email' => $email, 'password' => $password],
                AdminFormRule::rules("POST")
            )->validate();

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'email_verified_at' => now()
            ]);

            $this->info("Successfully created a new admin");
        } catch (ValidationException $validationException) {
            $errors = $validationException->validator->errors();

            foreach ($errors->all() as $message) {
                $this->error($message);
            }
        }
    }
}
