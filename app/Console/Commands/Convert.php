<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class Convert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->call('convert:sites');
        $this->call('convert:users');
        $this->call('convert:savings');
        $this->call('convert:loans');
        Setting::query()
            ->create([
                'key' => 'monthly_saving_amount',
                'value' => "1000000",
            ]);
    }
}
