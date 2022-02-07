<?php

namespace App\Exports;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AllUserSavingsExport implements FromView
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
            ->get()
            ->each
            ->append(['total_saving_amount']);

        return view('exports.all_user_savings', [
            'users' => $users
        ]);
    }
}
