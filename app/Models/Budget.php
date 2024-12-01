<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'value' => 'decimal:2', 
    ];

    public static function getExpenses(Budget $budget) {
        return Expense::whereHas('budgetExpenses', function ($query) use ($budget) {
            $query->where('budget_id', $budget->id); // Filter by budget_id in BudgetExpense
        });
    }

    public static function getSummaryExpenses(Budget $budget) {
        return $budget->expenses()
            ->whereHas('expense', function($query) {
                $query->where('merge', false);
                $query->where('default', false);
            })
            ->orderBy('days', 'desc')
            ->get()
            ->groupBy('expense_id')->map(function ($group) use($budget) {
            $mainExpense = $group->firstWhere('user_id', $budget->user_id) ?? $group->first(); 
            $mainExpense->total = $group->sum('total');
            return $mainExpense;
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
        return $this->hasMany(BudgetAddress::class)->orderBy('from_date');;
    }

    public function expenses() {
        return $this->hasMany(BudgetExpense::class);
    }
}
