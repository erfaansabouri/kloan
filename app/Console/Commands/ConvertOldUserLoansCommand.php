<?php

namespace App\Console\Commands;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\Site;
use App\Models\User;
use App\Models\UserLoan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertOldUserLoansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:loans';

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
        UserLoan::query()->truncate();
        $oldBimeLoans = DB::connection('mysql2')
            ->table('bime')
            ->get();
        // Bime
        $parentBime = LoanType::query()
            ->create([
                'title' => 'بیمه خودرو',
                'code' => "3000"
            ]);

        $childBime1 = LoanType::query()
            ->create([
                'parent_id' => $parentBime->id,
                'title' => 'بیمه خودرو یک',
                'code' => "3001",
            ]);

        $childBime2 = LoanType::query()
            ->create([
                'parent_id' => $parentBime->id,
                'title' => 'بیمه خودرو دو',
                'code' => "3002",
            ]);

        foreach ($oldBimeLoans as $oldBimeLoan)
        {
            $userId = $this->getUserIdWithIdentificationCode($oldBimeLoan->identification_code);
            if(UserLoan::query()->where('user_id', $userId)->where('loan_type_id',$childBime1->id)->first())
            {
                UserLoan::query()
                    ->create([
                        'user_id' => $userId,
                        'loan_type_id' => $childBime2->id,
                        'total_amount' => $oldBimeLoan->total_remained_amount,
                        'installment_count' => $oldBimeLoan->installment_count,
                        'installment_amount' => $oldBimeLoan->installment_amount,
                        'first_installment_received_at' => Carbon::parse('2021-08-22'),
                        'loan_paid_to_user_at' => Carbon::parse('2021-07-22'),
                        'archive_at' => null,
                    ]);

                continue;
            }

            UserLoan::query()
                ->create([
                    'user_id' => $userId,
                    'loan_type_id' => $childBime1->id,
                    'total_amount' => $oldBimeLoan->total_remained_amount,
                    'installment_count' => $oldBimeLoan->installment_count,
                    'installment_amount' => $oldBimeLoan->installment_amount,
                    'first_installment_received_at' => Carbon::parse('2021-08-22'),
                    'loan_paid_to_user_at' => Carbon::parse('2021-07-22'),
                    'archive_at' => null,
                ]);

        }
        $this->info('converting loans (bime) done.');


        // gharzol
        $oldGharzolLoans = DB::connection('mysql2')
            ->table('gharzol')
            ->get();

        $parentGharzol = LoanType::query()
            ->create([
                'title' => 'قرض الحسنه',
                'code' => "2000"
            ]);

        $childGharzol1 = LoanType::query()
            ->create([
                'parent_id' => $parentGharzol->id,
                'title' => 'قرض الحسنه یک',
                'code' => "2001",
            ]);

        $childGharzol2 = LoanType::query()
            ->create([
                'parent_id' => $parentGharzol->id,
                'title' => 'قرض الحسنه دو',
                'code' => "2002",
            ]);

        foreach ($oldGharzolLoans as $oldGharzolLoan)
        {
            $userId = $this->getUserIdWithIdentificationCode($oldGharzolLoan->identification_code);
            if(UserLoan::query()->where('user_id', $userId)->where('loan_type_id',$childGharzol1->id)->first())
            {
                UserLoan::query()
                    ->create([
                        'user_id' => $userId,
                        'loan_type_id' => $childGharzol2->id,
                        'total_amount' => $oldGharzolLoan->total_remained_amount,
                        'installment_count' => $oldGharzolLoan->installment_count,
                        'installment_amount' => $oldGharzolLoan->installment_amount,
                        'first_installment_received_at' => Carbon::parse('2021-08-22'),
                        'loan_paid_to_user_at' => Carbon::parse('2021-07-22'),
                        'archive_at' => null,
                    ]);

                continue;
            }

            UserLoan::query()
                ->create([
                    'user_id' => $userId,
                    'loan_type_id' => $childGharzol1->id,
                    'total_amount' => $oldGharzolLoan->total_remained_amount,
                    'installment_count' => $oldGharzolLoan->installment_count,
                    'installment_amount' => $oldGharzolLoan->installment_amount,
                    'first_installment_received_at' => Carbon::parse('2021-08-22'),
                    'loan_paid_to_user_at' => Carbon::parse('2021-07-22'),
                    'archive_at' => null,
                ]);

        }
        $this->info('converting loans (gharzol) done.');


        // lavazem
        $oldLavazemLoans = DB::connection('mysql2')
            ->table('lavazem')
            ->get();

        $parentLavazem = LoanType::query()
            ->create([
                'title' => 'لوازم خانگی',
                'code' => "1000"
            ]);

        $childLavazem1 = LoanType::query()
            ->create([
                'parent_id' => $parentLavazem->id,
                'title' => 'لوازم خانگی یک',
                'code' => "1001",
            ]);

        $childLavazem2 = LoanType::query()
            ->create([
                'parent_id' => $parentLavazem->id,
                'title' => 'لوازم خانگی دو',
                'code' => "1002",
            ]);

        $childLavazem3 = LoanType::query()
            ->create([
                'parent_id' => $parentLavazem->id,
                'title' => 'لوازم خانگی سه',
                'code' => "1003",
            ]);

        foreach ($oldLavazemLoans as $oldLavazemLoan)
        {
            $userId = $this->getUserIdWithIdentificationCode($oldLavazemLoan->identification_code);
            if(UserLoan::query()->where('user_id', $userId)->where('loan_type_id',$childLavazem1->id)->first())
            {
                UserLoan::query()
                    ->create([
                        'user_id' => $userId,
                        'loan_type_id' => $childLavazem2->id,
                        'total_amount' => $oldLavazemLoan->total_remained_amount,
                        'installment_count' => $oldLavazemLoan->installment_count,
                        'installment_amount' => $oldLavazemLoan->installment_amount,
                        'first_installment_received_at' => Carbon::parse('2021-08-22'),
                        'loan_paid_to_user_at' => Carbon::parse('2021-07-22'),
                        'archive_at' => null,
                    ]);

                continue;
            }

            UserLoan::query()
                ->create([
                    'user_id' => $userId,
                    'loan_type_id' => $childLavazem1->id,
                    'total_amount' => $oldLavazemLoan->total_remained_amount,
                    'installment_count' => $oldLavazemLoan->installment_count,
                    'installment_amount' => $oldLavazemLoan->installment_amount,
                    'first_installment_received_at' => Carbon::parse('2021-08-22'),
                    'loan_paid_to_user_at' => Carbon::parse('2021-07-22'),
                    'archive_at' => null,
                ]);

        }
        $this->info('converting loans (lavazem) done.');

    }

    private function getUserIdWithIdentificationCode($idCode)
    {

        $user = User::query()
            ->where('identification_code', $idCode)
            ->first();

        if(!$user)
        {
            $this->info('error new user '. $idCode);

            $newUser = User::query()
                ->create([
                    'identification_code' => $idCode,
                ]);

            return $newUser->id;
        }
        return $user->id;
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
