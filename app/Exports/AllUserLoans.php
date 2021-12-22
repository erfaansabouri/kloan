<?php

namespace App\Exports;

use App\Models\Installment;
use App\Models\LoanType;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AllUserLoans implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        $userLoans = UserLoan::query()
            ->orderByDesc('id')
            ->visible()
            ->with(['user', 'loan'])
            ->get();
        return view('exports.all_user_loans', [
            'userLoans' => $userLoans,
        ]);
    }
}
