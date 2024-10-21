<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'label',
    ];

    /**
     * setDefault
     *
     * @return void
    */
    public static function setDefault(Expense $expense) {
        self::where('default', true)->update(['default' => false]);
        $expense->default = true;
        $expense->save();
    }

    public static function getDefault() {
        return Expense::where('default', true)->firstOrFail();
    }

    public static function createDefaultBudgetItemExpense(BudgetItem $budgetItem) : BudgetItemExpense {
        $default = self::getDefault();
        $budgetItemExpense = new BudgetItemExpense();
        $budgetItemExpense->fill([
            'budget_item_id' => $budgetItem->id,
            'expense_id' => $default->id,
            'days' => null,
            'total' => $budgetItem->budgetItemExpenses
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
     * Get the budget item expenses
    */
    public function budgetItemExpenses()
    {
        return $this->hasMany(BudgetItemExpense::class);
    }
}
