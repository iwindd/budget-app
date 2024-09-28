<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Check if budget item has address.
     *
     * @return Boolean
     */
    public static function isHasAddresses(BudgetItem $budget) {
        return $budget->budgetItemAddresses()->count() > 0;
    }

    /**
     * Check if budget item has expense.
     *
     * @return Boolean
     */
    public static function isHasExpenses(BudgetItem $budget) {
        return $budget->budgetItemExpenses()->count() > 0;
    }

    /**
     * Check if budget item has data.
     *
     * @return Boolean
     */
    public static function isHasData(BudgetItem $budget) {
        if (!self::isHasAddresses($budget)) return false;
        if (!self::isHasExpenses($budget)) return false;

        return true;
    }

    /**
     * get From back
     *
     * @return array
     */
    public static function getFromBack(BudgetItem $budget) {
        return [
            'from' => $budget->budgetItemAddresses->first()->from_date ?? null,
            'back' => $budget->budgetItemAddresses->last()->back_date ?? null
        ];
    }

    /**
     * Get the user that created
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * Get the address
    */
    public function budgetItemAddresses()
    {
        return $this->hasMany(BudgetItemAddress::class, 'budget_item_id');
    }

    /**
     * Get the expenses
    */
    public function budgetItemExpenses()
    {
        return $this->hasMany(BudgetItemExpense::class, 'budget_item_id', 'id');
    }
}
