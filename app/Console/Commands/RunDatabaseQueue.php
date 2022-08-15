<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunDatabaseQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:runDatabaseQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database queue.';

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
     * @return int
     */
    public function handle()
    {
        return $this->call('queue:work', [
            '--stop-when-empty' => null,
        ]);
    }
}
