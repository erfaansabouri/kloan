<?php

namespace App\Exports;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AllUserBedehiExport implements FromView
{
    protected $identification_code;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct()
    {
    }

    public function view(): View
    {

        $users = User::query()
            ->get();

        $loanTypes = LoanType::query()
            ->where('parent_id', null)
            ->get();

        return view('exports.all_user_bedehi', [
            'users' => $users,
            'loanTypes' => $loanTypes,
        ]);
    }
}
