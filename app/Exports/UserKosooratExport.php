<?php

namespace App\Exports;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UserKosooratExport implements FromView
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $month = $this->month;
        $year = $this->year;

        $users = User::query()
            ->whereHas('installments', function ($q) use ($month, $year){
                $q->where('month', $month)->where('year', $year);
            })->orWhereHas('savings', function ($q2) use ($month, $year){
                $q2->where('month', $month)->where('year', $year);
            })->get();

        foreach ($users as $user)
        {
            $user['total_saving'] = $user->getTotalSavingsDate($month,$year);
            $user['total_installments'] = $user->getTotalPaidInstallmentsByGroup($month, $year);
        }

        $loanTypes = LoanType::query()
            ->parent()
            ->get();


        return view('exports.user_kosoorat', [
            'users' => $users,
            'loanTypes' => $loanTypes,
            'month' => $month,
            'year' => $year,
        ]);
    }
}
