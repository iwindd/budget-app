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
        'type',
        'expense_id',
        'days',
        'total',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function expense() {
        return $this->belongsTo(Expense::class);
    }
}
