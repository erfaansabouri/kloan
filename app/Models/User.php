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

    public function getTotalInstallmentOfDate($month, $year)
    {
        return Installment::query()
            ->where('user_id', $this->id)
            ->where('month', $month)
            ->where('year', $year)
            ->sum('received_amount');
    }
}
