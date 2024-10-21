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
