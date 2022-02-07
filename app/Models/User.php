<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* Relations */

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    public function hasPaidSaving($month, $year)
    {
        $condition = Saving::query()
            ->where('user_id', $this->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if($condition) return true;
        return false;
    }

    public function getTotalReceivedLoansAttribute()
    {
        $loanTypes = LoanType::query()
            ->parent()
            ->get();

        $result = [];

        foreach ($loanTypes as $loanType)
        {
            $childrenIds = $loanType->children()->pluck('id');
            $totalAmount = UserLoan::query()
                ->where('user_id', $this->id)
                ->whereIn('loan_type_id', $childrenIds)
                ->sum('total_amount');
            $result[$loanType->title] = $totalAmount;
        }

        return $result;
    }


    public function getTotalPaidInstallmentsByGroup($month, $year)
    {
        $loanTypes = LoanType::query()
            ->parent()
            ->get();

        $result = [];

        foreach ($loanTypes as $loanType)
        {
            $result[$loanType->title] = 0;
        }

        foreach ($loanTypes as $loanType)
        {
            $childrenIds = $loanType->children()->pluck('id');
            $userLoans = UserLoan::query()
                ->where('user_id', $this->id)
                ->whereIn('loan_type_id', $childrenIds)
                ->get();

            foreach ($userLoans as $userLoan)
            {
                $currentMonthInstallments = Installment::query()
                    ->where('user_id', $this->id)
                    ->where('user_loan_id', $userLoan->id)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->sum('received_amount');
                $result[$loanType->title] += $currentMonthInstallments;
            }

        }

        return $result;
    }


    public function getTotalInstallmentOfDate($month, $year)
    {
        return Installment::query()
            ->where('user_id', $this->id)
            ->where('month', $month)
            ->where('year', $year)
            ->sum('received_amount');
    }

    public function getTotalInstallmentOfDateWithParentLoanType($month, $year, $parentLoanTypeId)
    {
        $childIds = LoanType::query()->where('parent_id', $parentLoanTypeId)->get()->pluck('id');
        return Installment::query()
            ->select('installments.*', 'user_loan.user_loan_id', 'user_loan.loan_type_id')
            ->leftJoin('user_loan', 'user_loan.id', '=', 'installments.user_loan_id')
            ->whereIn('user_loan.loan_type_id', $childIds)
            ->where('installments.user_id', $this->id)
            ->where('installments.month', $month)
            ->where('installments.year', $year)
            ->sum('installments.received_amount');
    }


    public function getTotalSavingsOfDate($month, $year)
    {
        return Saving::query()
            ->where('user_id', $this->id)
            ->where('month', $month)
            ->where('year', $year)
            ->sum('amount');
    }

    public function getTotalSavingsDate($month, $year)
    {
        return Saving::query()
            ->where('user_id', $this->id)
            ->where('month', $month)
            ->where('year', $year)
            ->sum('amount');
    }

    public function getTotalSavingAmountAttribute()
    {
        return Saving::query()
            ->where('user_id', $this->id)
            ->sum('amount');
    }

    public function getBedehiOfLoanTypeId($loanTypeId)
    {
        $subLoanTypeIds = LoanType::query()
            ->where('parent_id', $loanTypeId)
            ->get()->pluck('id');

        $userLoans = UserLoan::query()
            ->where('user_id', $this->id)
            ->whereIn('loan_type_id', $subLoanTypeIds)
            ->sum('total_amount');

        $installmentsOfThisTypeOfLoan = Installment::query()
            ->leftJoin('user_loan','user_loan.id', '=', 'installments.user_loan_id')
            ->where('installments.user_id', $this->id)
            ->whereIn('user_loan.loan_type_id', $subLoanTypeIds)
            ->sum('installments.received_amount');

        return $userLoans - $installmentsOfThisTypeOfLoan;
    }
}
