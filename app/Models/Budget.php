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
        'date',
        'value',
        'user_id',
        'invitation_id',
        'office_id'
    ];

    public static function getAddressList() {
        return collect([
            ['id' => 1, 'label' => 'บ้านพัก'],
            ['id' => 2, 'label' => 'สำนักงาน'],
            ['id' => 3, 'label' => 'ประเทศไทย']
        ]);
    }

    private static function getDatesBetween($fromDate, $toDate)
    {
        $fromDate = Carbon::parse($fromDate);
        $toDate = Carbon::parse($toDate);

        $dates = [];
        while ($fromDate->lte($toDate)) {
            $dates[] = $fromDate->copy(); // Customize the format as needed
            $fromDate->addDay();
        }

        return collect($dates);
    }

    public static function SortAddresses($item) {
        return Carbon::parse($item['from_date']);
    }

    public static function MinimizeAddresses($payload) {
        $payload = collect($payload)->sortBy('from_date')->values();
        $minimize = collect([]);
        $skipped = [];

        $payload->map(function($address, $index) use ($payload, $minimize, &$skipped){
            if (in_array($index, $skipped)) return false;
            $fromDate = Carbon::parse($address['from_date']);
            $backDate = Carbon::parse($address['back_date']);
            $stacked = $payload->slice($index+1, $payload->count() - $index - 1)->map(function($a, $i) use ($fromDate, $backDate, $index, &$skipped){
                $tempFromDate = $fromDate->copy()->addDay($i - $index)->format('Y-m-d H:i');
                $tempBackDate = $backDate->copy()->addDay($i - $index)->format('Y-m-d H:i');

                if ($tempFromDate == $a['from_date'] && $tempBackDate == $a['back_date']){
                    $skipped[] = $i;
                    return $a;
                }
            })->filter();

            $minimize->push([
                'back_date' => $stacked->isNotEmpty() ?
                    $stacked->last()['back_date'] :
                    $address['back_date'],
                'multiple' => $stacked->isNotEmpty()
            ] + $address);
        });

        return $minimize->sortBy('from_date')->values();
    }

    public static function ExtractAddresses($payload) {
        $payload = collect($payload)->sortBy('from_date')->values();
        $extract = collect([]);

        collect($payload)->map(function($address) use ($extract) {
            $fromDate = Carbon::parse($address['from_date']);
            $backDate = Carbon::parse($address['back_date']);

            if ($address['multiple']){
                self::getDatesBetween($fromDate, $backDate)->map(function($date) use ($extract, $address, $fromDate, $backDate){
                    $extract->push([
                        'from_date' => $date->copy()->setTimeFromTimeString($fromDate->format("H:i"))->format('Y-m-d H:i'),
                        'back_date' => $date->copy()->setTimeFromTimeString($backDate->format("H:i"))->format('Y-m-d H:i'),
                    ] + $address);
                });
            }else{
                $extract->push($address);
            }
        });

        return $extract->sortBy('from_date')->values();
    }

    public static function GetEventBetween($extract, $carbonStart, $carbonEnd) {
        return $extract->filter(function($a) use ($carbonStart, $carbonEnd){
            $fromDate = Carbon::parse($a['from_date']);
            $backDate = Carbon::parse($a['back_date']);

            return $fromDate->between($carbonEnd, $carbonEnd) || $backDate->between($carbonStart, $carbonEnd);
        });
    }

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

/*     public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    } */
}
