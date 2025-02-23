<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears cache, view, route, config, events, and compiled files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commands = [
            'cache:clear',
            'view:clear',
            'route:clear',
            'config:clear',
            'event:clear',
            'clear-compiled',
            'optimize:clear',
        ];

        foreach ($commands as $command) {
            $this->call($command);
        }

        $this->info('All caches cleared successfully!');
    }
}
