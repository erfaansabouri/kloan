<?php

namespace App\Imports;

use App\Models\LoanType;
use App\Models\User;
use App\Models\UserLoan;
use App\Models\UserLoanDeleteLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserLoanDeleteImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        UserLoanDeleteLog::query()->truncate();
        foreach ($rows as $row)
        {
            if($row[0] == 'کد وام')
                continue;
            $loanTypeCode = $row[0];
            $userIdentificationCode = $row[1];
            if(
                empty($loanTypeCode) ||
                empty($userIdentificationCode)
            )
            {
                UserLoanDeleteLog::query()
                    ->create([
                        'log' => "ردیف با اطلاعات شماره پرسنلی $userIdentificationCode و کد وام $loanTypeCode با مشکل مواجه شد ",
                        'status' => "نا موفق",
                    ]);
                continue;
            }

            $user = User::query()->where('identification_code', $userIdentificationCode)->first();
            $loanType = LoanType::query()->where('code', $loanTypeCode)->first();

            if ($user && $loanType)
            {
                //check if user has an active loan of this type
                $hasLoanOfThisType = UserLoan::query()
                    ->where('user_id', $user->id)
                    ->where('loan_type_id', $loanType->id)
                    ->first();

                if($hasLoanOfThisType)
                {
                    $hasLoanOfThisType->delete();
                    UserLoanDeleteLog::query()
                        ->create([
                            'log' => "ردیف با اطلاعات شماره پرسنلی $userIdentificationCode و کد وام $loanTypeCode با موفقیت حذف شد ",
                            'status' => "موفق",
                        ]);

                }

            }

            else{
                UserLoanDeleteLog::query()
                    ->create([
                        'log' => "ردیف با اطلاعات شماره پرسنلی $userIdentificationCode و کد وام $loanTypeCode با مشکل مواجه شد (کد پرسنلی یا وام وجود نداشت) ",
                        'status' => "نا موفق",
                    ]);
            }

        }
    }
}
