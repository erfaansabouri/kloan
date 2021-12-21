<?php

namespace App\Exports;

use App\Exports\OneUserInstallmentsPerLoanSheet;
use App\Models\Installment;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OneUserLoans implements WithMultipleSheets
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $userLoans = UserLoan::query()
            ->where('user_id', $this->user->id)
            ->get();
        $sheets = [];

        foreach ($userLoans as $userLoan)
        {
            $sheets[] = new OneUserInstallmentsPerLoanSheet($this->user,$userLoan);
        }


        return $sheets;
    }
}
