<?php

namespace App\Console\Commands;

use App\Models\LoanType;
use App\Models\Site;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertLoanTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:loan_types';

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
        LoanType::query()->truncate();
        $oldLoanGroups = DB::connection('mysql2')
            ->table('goroh')
            ->get();



        foreach ($oldLoanGroups as $oldLoanGroup)
        {
            $newLoanType = new LoanType();
            $newLoanType->parent_id = null;
            $newLoanType->code = $oldLoanGroup->codg;
            $newLoanType->title = $this->arabicToPersian($oldLoanGroup->gh);
            $newLoanType->save();

            // add sub groups
            $oldLoanSubGroups = DB::connection('mysql2')
                ->table('nb')
                ->where('codg' , $oldLoanGroup->codg)
                ->get();

            foreach ($oldLoanSubGroups as $oldLoanSubGroup)
            {
                $newSubLoanType = new LoanType();
                $newSubLoanType->parent_id = $newLoanType->id;
                $newSubLoanType->code = $oldLoanSubGroup->codb;
                $newSubLoanType->title = $this->arabicToPersian($oldLoanSubGroup->nb);
                $newSubLoanType->save();
            }
        }
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
