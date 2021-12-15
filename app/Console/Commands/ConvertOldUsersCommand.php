<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertOldUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:users';

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
        User::query()->truncate();
        $oldUsers = DB::connection('mysql2')
            ->table('per')
            ->get();

        foreach ($oldUsers as $oldUser)
        {
            $alreadyExists = User::query()
                ->where('identification_code', $oldUser->codh)
                ->first();

            if(!$alreadyExists)
            {
                $newUser = new User();
                $newUser->first_name = $oldUser->name;
                $newUser->last_name = $oldUser->lname;
                $newUser->status = $oldUser->vz == "True" ? false : true;
                $newUser->identification_code = $oldUser->codh;
                $newUser->site_id = $this->getSiteId($oldUser->nsh);
                $newUser->save();
            }

            else{
                $this->info($oldUser->codh . " Duplicate alert.");

            }

        }
        $this->info("Converting ". $this->signature . " Done!");

    }

    private function getSiteId($siteTitle)
    {
        $alreadyExits = Site::query()
            ->where('title', $siteTitle)
            ->first();

        if(!$alreadyExits)
        {
            $newSite = Site::query()
                ->create([
                    'code' => null,
                    'title' => $siteTitle
                ]);

            return $newSite->id;
        }

        return $alreadyExits->id;
    }
}
