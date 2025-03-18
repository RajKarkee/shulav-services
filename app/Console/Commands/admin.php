<?php

namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class admin extends Command
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
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Admin command executed');
        $this->info('Creating admin user...');

        $name = $this->ask('Enter your name');
        $email = $this->ask('Enter your email');
        $password = $this->ask('Enter your password');









        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email $email already exists.");
            return 1;
        }

        try {
            // Create admin user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'role' => 1,
            ]);

            $this->info('Admin user created successfully.');
            $this->info("Name: {$user->name}");
            $this->info("Email: {$user->email}");

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return 1;
        }
    }
}
