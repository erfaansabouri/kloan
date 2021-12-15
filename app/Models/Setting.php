<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public static function getMonthlySavingAmount()
    {
        return self::query()
            ->where('key', 'monthly_saving_amount')
            ->first()->value;
    }
}
