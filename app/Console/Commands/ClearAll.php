<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     * @author Jaynil Parekh
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all cache & temp files';

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
        $this->comment(PHP_EOL . 'Clearing All' . PHP_EOL);
//        \Artisan::call('optimize');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
//        \Artisan::call('config:cache');
        \Artisan::call('queue:restart');
        exec('composer dump-autoload');
        $this->info('Cache and temp data successfully cleared.');
    }
}
