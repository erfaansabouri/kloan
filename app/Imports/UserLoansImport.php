<?php

namespace App\Imports;

use App\Models\LoanType;
use App\Models\User;
use App\Models\UserLoan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Morilog\Jalali\Jalalian;

class UserLoansImport implements ToCollection
{



    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UserLoan([
            'user_id'     => $row[0],
            'loan_type_id'    => $row[1],
            'total_amount' => $row[2],
            'installment_count' => $row[3],
            'installment_amount' => $row[4],
            'first_installment_received_at' => $row[5],
            'loan_paid_to_user_at' => $row[6],
            'archive_at' => null,
        ]);
    }


    public function collection(Collection $rows)
    {

        foreach ($rows as $row)
        {
            $loanTypeCode = $row[0];
            $userIdentificationCode = $row[1];
            $userLoanTotalAmount = $row[2];
            $userLoanInstallmentCount = $row[3];
            $userLoanPaidToUserYear = $row[4];
            $userLoanPaidToUserMonth = $row[5];
            $userLoanPaidToUserDay = $row[6];
            $userLoanFirstInstallmentReceivedYear = $row[7];
            $userLoanFirstInstallmentReceivedMonth = $row[8];
            $userLoanFirstInstallmentReceivedDay = $row[9];

            if(
                empty($loanTypeCode) ||
                empty($userIdentificationCode) ||
                empty($userLoanTotalAmount) ||
                empty($userLoanInstallmentCount) ||
                empty($userLoanPaidToUserYear) ||
                empty($userLoanPaidToUserMonth) ||
                empty($userLoanPaidToUserDay) ||
                empty($userLoanFirstInstallmentReceivedYear) ||
                empty($userLoanFirstInstallmentReceivedMonth) ||
                empty($userLoanFirstInstallmentReceivedDay) ||
                $userLoanInstallmentCount == 0
            )
            {
                continue;
            }

            $user = User::query()->where('identification_code', $userIdentificationCode)->first();
            $loanType = LoanType::query()->where('code', $loanTypeCode)->first();
            $totalAmount = $userLoanTotalAmount;
            $installmentCount = $userLoanInstallmentCount;
            $installmentAmount = $totalAmount / $installmentCount;

            $carbonFirstInstallmentDate = (new Jalalian($userLoanFirstInstallmentReceivedYear, $userLoanFirstInstallmentReceivedMonth, $userLoanFirstInstallmentReceivedDay, 00, 00, 0))->toCarbon()->toDateTimeString();
            $carbonUserLoanPaidDate =  (new Jalalian($userLoanPaidToUserYear, $userLoanPaidToUserMonth, $userLoanPaidToUserDay, 00, 00, 0))->toCarbon()->toDateTimeString();



            if ($user && $loanType)
            {
                UserLoan::query()->create([
                    'user_id'     => $user->id,
                    'loan_type_id'    => $loanType->id,
                    'total_amount' => $totalAmount,
                    'installment_count' => $installmentCount,
                    'installment_amount' => $installmentAmount,
                    'first_installment_received_at' => $carbonFirstInstallmentDate,
                    'loan_paid_to_user_at' => $carbonUserLoanPaidDate,
                    'archive_at' => null,
                ]);
            }

        }
    }
}
