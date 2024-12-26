<?php

namespace App\Console\Commands;

use App\Http\Controllers\ModsController;
use Illuminate\Console\Command;

class RegenerateMods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mods:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerates mods from BunnyCDN.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mods_controller = new ModsController;
        $mods_controller->regenerate_mods();

        return Command::SUCCESS;
    }
}
