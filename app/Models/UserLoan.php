<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoan extends Model
{
    protected $table = 'user_loan';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan()
    {
        return $this->belongsTo(LoanType::class, 'loan_type_id');
    }

    public function isReceivedCompletely()
    {
        $totalInstallmentReceivedAmount = Installment::query()
            ->where('user_loan_id', $this->id)
            ->sum('received_amount');

        if($totalInstallmentReceivedAmount >= $this->total_amount)
            return true;
        return false;
    }

    public function isInstallmentReceivedForMonthYear($month, $year)
    {
        $isReceived = Installment::query()
            ->where('user_loan_id', $this->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if($isReceived) return true;
        return false;
    }
}
