<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeAllCommand extends Command
{
    protected $signature = 'make:all {name}';
    protected $description = 'Generate model, migration, factory, seeder, policy, request, and resource controller';

    public function handle()
    {
        $name = $this->argument('name');

        // Membuat Model dengan Migration & Factory
        $this->call('make:model', ['name' => $name, '--migration' => true, '--factory' => true]);

        // Membuat Seeder secara terpisah
        $this->call('make:seeder', ['name' => $name . 'Seeder']);

        // Membuat Resource Controller
        $this->call('make:controller', ['name' => $name . 'Controller', '--resource' => true]);

        // Membuat Policy
        $this->call('make:policy', ['name' => $name . 'Policy', '--model' => $name]);

        // Membuat Form Request
        $this->call('make:request', ['name' => $name . 'Request']);

        $this->info('✅ Semua file telah berhasil dibuat untuk: ' . $name);
    }
}
