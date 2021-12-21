<?php
namespace App\Exports;

use App\Models\Installment;
use App\Models\LoanType;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class OneUserInstallmentsPerLoanSheet implements FromView, WithTitle
{
    private $userLoan;
    private $user;

    public function __construct($user,$userLoan)
    {
        $this->user = $user;
        $this->userLoan = $userLoan;
    }


    public function view(): View
    {
        $installments = Installment::query()
            ->where('user_loan_id', $this->userLoan->id)
            ->get();
        return view('exports.one_user_installments', [
            'installments' => $installments,
            'user' => $this->user,
            'loan_type' => LoanType::query()->where('id', $this->userLoan->loan_type_id)->first(),
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return LoanType::query()->where('id', $this->userLoan->loan_type_id)->first()->title;
    }
}