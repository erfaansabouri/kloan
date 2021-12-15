<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertOldSitesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:sites';

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
        Site::query()->truncate();
        $oldSites = DB::connection('mysql2')
            ->table('sh')
            ->get();

        foreach ($oldSites as $oldSite)
        {
            $alreadyExists = Site::query()
                ->where('title', $oldSite->name)->first();

            if(!$alreadyExists)
            {
                $newSite = new Site();
                $newSite->code = $oldSite->codsh;
                $newSite->title = $oldSite->name;
                $newSite->save();
            }

            else{
                $this->info($oldSite->codsh . " Duplicate alert.");
            }
        }
        $this->info("Converting ". $this->signature . " Done!");
    }
}
