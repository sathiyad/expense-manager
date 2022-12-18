<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'amount',
        'type'
    ];
    
    /**
     * Get the details for the expense.
     * 
     * return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(ExpenseDetail::class);
    }

    /**
     * Get the user that owns the expense.
     * 
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the amount from the details.
     * 
     * return float
     */
    public function amountFromDetail()
    {
        return $this->details()->sum('amount');
    }

    /**
     * Get and set the amount attribute.
     * 
     * return float
     */
    protected function amount():Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format((float)($value/100), 2, '.', ''),
            set: fn ($value) => $value*100,
        );
    }

}
