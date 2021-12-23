<?php

namespace App\Exports;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UserSavingsExport implements FromView
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

        $savings = Saving::query()
            ->whereHas('user', function ($q) use ($user){
                $q->where('identification_code', $user->identification_code);
            })
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('exports.user_savings', [
            'user' => $user,
            'savings' => $savings,
        ]);
    }
}
