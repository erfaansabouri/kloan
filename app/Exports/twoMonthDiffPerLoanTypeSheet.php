<?php
namespace App\Exports;

use App\Models\Installment;
use App\Models\LoanType;
use App\Models\User;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class twoMonthDiffPerLoanTypeSheet implements FromView, WithTitle
{
    private $firstMonth;
    private $firstYear;
    private $secondMonth;
    private $secondYear;
    private $parentLoanType;

    public function __construct($firstMonth,$firstYear,$secondMonth,$secondYear,$parentLoanType)
    {
        $this->firstMonth = $firstMonth;
        $this->firstYear = $firstYear;
        $this->secondMonth = $secondMonth;
        $this->secondYear = $secondYear;
        $this->parentLoanType = $parentLoanType;
    }


    public function view(): View
    {

        $firstMonth = $this->firstMonth;
        $firstYear = $this->firstYear;
        $secondMonth = $this->secondMonth;
        $secondYear = $this->secondYear;

        $users = User::query()
            ->whereHas('installments', function ($q) use ($firstMonth,$firstYear,$secondMonth,$secondYear){
                $q->whereIn('month', [$firstMonth, $secondMonth]);
                $q->whereIn('year', [$firstYear, $secondYear]);
            })->get();
        foreach ($users as $user)
        {
            $user['total_first_date'] = $user->getTotalInstallmentOfDateWithParentLoanType($this->firstMonth, $this->firstYear, $this->parentLoanType->id);
            $user['total_second_date'] = $user->getTotalInstallmentOfDateWithParentLoanType($this->secondMonth, $this->secondYear, $this->parentLoanType->id);
        }

        return view('exports.two_month_sheet', [
            'users' => $users,
            'firstMonth' => $firstMonth,
            'firstYear' => $firstYear,
            'secondMonth' => $secondMonth,
            'secondYear' => $secondYear,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->parentLoanType->title;
    }
}
