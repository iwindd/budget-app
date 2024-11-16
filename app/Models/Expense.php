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
        'merge',
        'default',
        'static',
        'split'
    ];

    protected $casts = [
        'default' => 'boolean',
        'merge' => 'boolean',
        'static' => 'boolean',
        'split' => 'boolean',
    ];

    public static function deactivated() {
        return self::where('default', true)->update(['default' => false]);
    }

    public static function getStaticExpenses() {
        return self::where([
            ['static', true],
            ['default', false]
        ])->orderBy('default', 'asc')->get();
    }

    /**
     * setDefault
     *
     * @return void
    */
    public static function setDefault(Expense $expense) {
        self::deactivated();
        return $expense->update(['default' => true]);
    }

    public static function getDefault() {
        return Expense::where('default', true)->firstOrFail();
    }

    public static function createDefaultBudgetItemExpense(Budget $budget) : BudgetExpense {
        $default = self::getDefault();
        $budgetItemExpense = new BudgetExpense();
        $budgetItemExpense->fill([
            'budget_id' => $budget->id,
            'expense_id' => $default->id,
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
     * Get the budget item expenses
    */
    public function budgetItemExpenses()
    {
        return $this->hasMany(BudgetItemExpense::class);
    }
}
