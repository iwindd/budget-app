<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetExpense extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'expense_id',
        'days',
        'total',
        'user_id', 
        'type',
    ];

    protected $casts = [
        'total' => 'decimal:2', 
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function expense() {
        return $this->belongsTo(Expense::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
