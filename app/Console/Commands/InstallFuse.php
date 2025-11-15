<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallFuse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fuse:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install FuseCMS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Later on we will check if FuseCMS is installed, and if so, we will prompt
        // the user to wipe the database and re-install.
        // For now, during development, we always re-install.
        $this->call('migrate:fresh');
        $this->call('fuse:sync-permissions');
        $this->call('db:seed');
    }
}
