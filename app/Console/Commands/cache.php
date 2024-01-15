<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class cache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('optimize');
        $this->call('view:clear');
        $this->call('event:cache');
    }
}
