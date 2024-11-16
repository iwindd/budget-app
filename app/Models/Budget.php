<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Budget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'serial',
        'finish_at',
        'value',
        'order',
        'date',
        'header',
        'subject',
        'user_id',
        'invitation_id',
        'office_id'
    ];

    /**
     * Get user's budget item by serial number with optional customizations.
     *
     * @param string $serial
     * @param int $user_id
     * @param array|null $budgetColumns Optional columns for the Budget model (select all if null)
     * @param array|null $budgetItemColumns Optional columns for the BudgetItem model (select all if null)
     * @param array|null $withRelations Optional relationships to eager load with specific columns (e.g. ['user:id,name', 'budget:title'])
     * @return BudgetItem|null
     */
    public static function getUserBudgetBySerial($serial, $user_id, $budgetColumns = null, $budgetItemColumns = null, $withRelations = ['user:id,name'])
    {
        // If no specific columns are provided, select all for Budget
        $budgetQuery = self::where('serial', $serial);

        if ($budgetColumns) {
            $budgetQuery->select($budgetColumns);
        }

        // Add dynamic relationships with specified columns
        $budgetQuery->with([
            'budgetItems' => function ($query) use ($user_id, $budgetItemColumns) {
                $query->where('user_id', $user_id);
                if ($budgetItemColumns) {
                    $query->select($budgetItemColumns);
                }
            },
            ...$withRelations // Load additional relationships with specific columns
        ]);

        $budget = $budgetQuery->first();

        // Return the first matching budget item or null
        return $budget ? $budget->budgetItems->first() : null;
    }

    /**
     * Get owner budget item
     *
     * @param Budget $budget
     * @return BudgetItem|null
    */
    public static function getOwnerBudget(Budget $budget) {
        return $budget->budgetItems()->where('user_id', $budget->user_id);
    }

    public static function getItemExpenses(Budget $budget) {
        return BudgetItemExpense::whereIn('budget_item_id', $budget->budgetItems()->pluck('id'));
    }

    public static function getExpenses(Budget $budget) {
        return Expense::whereHas('budgetItemExpenses.budgetItem', function ($query) use ($budget) {
            $query->where('budget_id', $budget->id); // Correctly filter by budget_id in BudgetItem
        });
    }

    public static function getTotalHours(Budget $budget) {
        $addresses = $budget->addresses;
        $hours = 0;

        $addresses->map(function($address) use (&$hours){
            $from = Carbon::parse($address->from_date);
            $back = Carbon::parse($address->back_date);

            if ($address->multiple){
                $days = $back->diffInDays($back);
                $back = $from->clone()->setTimeFromTimeString($back->toTimeString());

                $hours += ($back->diffInHours($from) * ($days <= 0 ? 1 : $days));
            }else{
                $hours += $back->diffInHours($from);
            }
        });

        return $hours;
    }

    /**
     * Get the user that created
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function companions() {
        return $this->hasMany(BudgetCompanion::class);
    }

    public function addresses() {
        return $this->hasMany(BudgetAddress::class);
    }

    public function expenses() {
        return $this->hasMany(BudgetExpense::class);
    }
}
