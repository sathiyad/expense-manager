<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ExpenseDetail extends Model
{
    protected $fillable = [
        'expense_id',
        'user_id',
        'amount',
        'paid_at'
    ];

    /**
     * Get the expense that owns the detail.
     * 
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    /**
     * Get the user that owns the detail.
     * 
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get and set the amount attribute.
     * 
     * return float
     */
    protected function amount() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format((float)($value/100), 2, '.', ''),
            set: fn ($value) => $value * 100,
        );
    }
}
