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

    public function installments()
    {
        return $this->hasMany(Installment::class);
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

    public function getTotalReceivedInstallmentAmountAttribute()
    {
        return Installment::query()
            ->where('user_loan_id', $this->id)
            ->sum('received_amount');
    }

    public function getTotalRemainedInstallmentAmountAttribute()
    {
        return $this->total_amount - Installment::query()
            ->where('user_loan_id', $this->id)
            ->sum('received_amount');
    }

    public function getRemainedInstallmentCountAttribute()
    {
        return $this->installment_count - Installment::query()
                ->where('user_loan_id', $this->id)->count();
    }

    public function getLastInstallmentAttribute()
    {
        $lastInstallment = Installment::query()
            ->where('user_loan_id', $this->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->first();

        if($lastInstallment)
        {
            return $lastInstallment;
        }

        return null;
    }

    public function scopeVisible($query)
    {
        return $query->where('archive_at', '=', null);
    }

    public function calculateReceivedAmount()
    {
        $remainedAmount = $this->getTotalRemainedInstallmentAmountAttribute();

        if($remainedAmount <= $this->installment_amount)
            return $remainedAmount;
        return $this->installment_amount;
    }
}
