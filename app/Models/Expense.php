<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'label'
    ];

    public static function getDefault($fields = '*') {
        return Expense::where('id', 4)->first($fields);
    }

    public static function getStaticExpenses() {
        return self::where('id', '<=', 3)->orderBy('id', 'asc');
    }

    public static function createDefaultBudgetItemExpense(Budget $budget) : BudgetExpense {
        $budgetItemExpense = new BudgetExpense();
        $budgetItemExpense->fill([
            'budget_id' => $budget->id,
            'expense_id' => 4,
            'days' => null,
            'total' => $budget->expenses
                ->filter(function ($budgetItemExpense) {
                    return $budgetItemExpense->expense->merge == true;
                })
                ->sum(function ($budgetItemExpense) {
                    return $budgetItemExpense->total * ($budgetItemExpense->days ?? 1);
                })
        ]);

        return $budgetItemExpense;
    }

    /**
     * Get the user that created
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the budget expenses
    */
    public function budgetExpenses()
    {
        return $this->hasMany(BudgetExpense::class);
    }

    public function getDefaultAttribute()
    {
        return $this->id == 4;
    }

    public function getMergeAttribute()
    {
        return $this->id > 4;
    }
}
