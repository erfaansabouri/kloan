<?php

namespace App\Exports;

use App\Models\LoanType;
use App\Models\Saving;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class twoMonthDiffExport implements WithMultipleSheets
{
    protected $firstMonth;
    protected $firstYear;
    protected $secondMonth;
    protected $secondYear;

    public function __construct($firstMonth,$firstYear,$secondMonth,$secondYear)
    {
        $this->firstMonth = $firstMonth;
        $this->firstYear = $firstYear;
        $this->secondMonth = $secondMonth;
        $this->secondYear = $secondYear;
    }

    public function sheets(): array
    {

        $firstMonth = $this->firstMonth;
        $firstYear = $this->firstYear;
        $secondMonth = $this->secondMonth;
        $secondYear = $this->secondYear;


        $parentLoanTypes = LoanType::query()
            ->parent()
            ->get();

        $sheets = [];

        foreach ($parentLoanTypes as $parentLoanType)
        {
            $sheets[] = new twoMonthDiffPerLoanTypeSheet($firstMonth,$firstYear,$secondMonth,$secondYear,$parentLoanType);
        }
        $sheets[] = new twoMonthDiffSavingsSheet($firstMonth,$firstYear,$secondMonth,$secondYear);

        return $sheets;

    }
}
