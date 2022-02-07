<?php

namespace App\Imports;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\SavingImportLog;
use App\Models\User;
use App\Models\UserLoan;
use App\Models\UserLoanImportLog;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Morilog\Jalali\Jalalian;

class SavingImport implements ToCollection
{



    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

    }


    public function collection(Collection $rows)
    {
        SavingImportLog::query()->truncate();
        foreach ($rows as $row)
        {
            if($row[0] == 'کد پرسنلی')
                continue;
            $userIdentificationCode = $row[0];
            $userSavingAmount = $row[1];
            if(
                empty($userIdentificationCode) ||
                empty($userSavingAmount)
            )
            {
                SavingImportLog::query()
                    ->create([
                        'log' => "ردیف با اطلاعات شماره پرسنلی $userIdentificationCode و مبلغ $userSavingAmount با مشکل مواجه شد ",
                        'status' => "نا موفق",
                    ]);
                continue;
            }

            $user = User::query()->where('identification_code', $userIdentificationCode)->first();

            if ($user)
            {
                $oldSaving = Saving::query()
                    ->where('user_id', $user->id)
                    ->where('year', 1300)
                    ->where('month', 1)
                    ->first();

                if($oldSaving)
                {
                    $oldSaving->amount = $oldSaving->amount + $userSavingAmount;
                    $oldSaving->save();
                }
                else{
                    Saving::query()
                        ->create([
                            'user_id' => $user->id,
                            'year' => 1300,
                            'month' => 1,
                            'amount' => $userSavingAmount,
                        ]);
                }

                SavingImportLog::query()
                    ->create([
                        'log' => "ردیف با اطلاعات شماره پرسنلی $userIdentificationCode و مبلغ $userSavingAmount با موفقیت وارد شد. ",
                        'status' => "موفق"
                    ]);
            }

            else{
                SavingImportLog::query()
                    ->create([
                        'log' => "ردیف با اطلاعات شماره پرسنلی $userIdentificationCode و مبلغ $userSavingAmount با مشکل مواجه شد ",
                        'status' => "نا موفق",
                    ]);
            }

        }
    }
}
