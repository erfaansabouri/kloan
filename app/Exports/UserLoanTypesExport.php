<?php

namespace App\Exports;

use App\Models\LoanType;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UserLoanTypesExport implements FromView
{
    protected $identification_code;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($identification_code)
    {
        $this->identification_code = $identification_code;
    }

    public function view(): View
    {
        $user = User::query()
            ->where('identification_code', $this->identification_code)
            ->firstOrFail();

        $loanTypes = LoanType::query()
            ->parent()
            ->get();

        return view('exports.user_loan_types', [
            'user' => $user,
            'loanTypes' => $loanTypes,
        ]);
    }
}
