<?php
namespace App\Exports;

use App\Models\Installment;
use App\Models\LoanType;
use App\Models\User;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class twoMonthDiffSavingsSheet implements FromView, WithTitle
{
    private $firstMonth;
    private $firstYear;
    private $secondMonth;
    private $secondYear;

    public function __construct($firstMonth,$firstYear,$secondMonth,$secondYear)
    {
        $this->firstMonth = $firstMonth;
        $this->firstYear = $firstYear;
        $this->secondMonth = $secondMonth;
        $this->secondYear = $secondYear;
    }


    public function view(): View
    {

        $firstMonth = $this->firstMonth;
        $firstYear = $this->firstYear;
        $secondMonth = $this->secondMonth;
        $secondYear = $this->secondYear;

        $users = User::query()
            ->whereHas('savings', function ($q) use ($firstMonth,$firstYear,$secondMonth,$secondYear){
                $q->whereIn('month', [$firstMonth, $secondMonth]);
                $q->whereIn('year', [$firstYear, $secondYear]);
            })->get();
        foreach ($users as $user)
        {
            $user['total_first_date'] = $user->getTotalSavingsOfDate($this->firstMonth, $this->firstYear);
            $user['total_second_date'] = $user->getTotalSavingsOfDate($this->secondMonth, $this->secondYear);
        }

        $result = [];
        foreach ($users as $user)
        {
            if($user['total_first_date'] != $user['total_second_date'])
                $result[] = $user;
        }
        return view('exports.two_month_savings_sheet', [
            'users' => $result,
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
        return 'پس انداز';
    }
}
