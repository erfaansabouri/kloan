<?php

namespace App\Console\Commands;

use App\Models\Saving;
use App\Models\Site;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertOldSavingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:savings';

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
        Saving::query()->truncate();
        $oldSavings = DB::connection('mysql2')
            ->table('savings')
            ->get();

        foreach ($oldSavings as $oldSaving)
        {
            Saving::query()
                ->create([
                    'month' => '4',
                    'year' => '1400',
                    'amount' => $oldSaving->saving,
                    'user_id' => $this->getUserIdWithIdentificationCode($oldSaving->identification_code),
                ]);
        }

        $this->info('converting savings done.');
    }

    private function getUserIdWithIdentificationCode($idCode)
    {
        return User::query()
            ->where('identification_code', $idCode)
            ->firstOrFail()
            ->id;
    }


    private function arabicToPersian($string)
    {
        $characters = [
            'ك' => 'ک',
            'دِ' => 'د',
            'بِ' => 'ب',
            'زِ' => 'ز',
            'ذِ' => 'ذ',
            'شِ' => 'ش',
            'سِ' => 'س',
            'ى' => 'ی',
            'ي' => 'ی',
            '١' => '۱',
            '٢' => '۲',
            '٣' => '۳',
            '٤' => '۴',
            '٥' => '۵',
            '٦' => '۶',
            '٧' => '۷',
            '٨' => '۸',
            '٩' => '۹',
            '٠' => '۰',
        ];
        return str_replace(array_keys($characters), array_values($characters),$string);
    }
}
