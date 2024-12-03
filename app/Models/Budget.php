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
                $query->where('id', '<=', 3);
            })
            ->orderBy('id', 'asc')
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

    private static function sortAddresses($a, $b) {
        $dateA = Carbon::parse($a['from_date']);
        $dateB = Carbon::parse($b['from_date']);

        if ($dateA->isBefore($dateB)) {
            return -1;
        } elseif ($dateA->isAfter($dateB)) {
            return 1;
        }
        return 0;
    }

    public static function getExtractAddresses(array $addresses) {
        $result    = collect([]);
        $addresses = collect($addresses)
            ->sort(fn($a, $b) => self::sortAddresses($a, $b))
            ->values();

        if ($addresses->count() <= 0) return $result;

        $addresses->map(function ($address) use ($result){
            $from = Carbon::parse($address['from_date']);
            $back = Carbon::parse($address['back_date']);

            if ($address['multiple']){
                $tempDate = Carbon::parse($from);

                while ($tempDate->lte($back)) {
                    $result->push([
                        'from_date' => $tempDate
                            ->clone()
                            ->setTimeFromTimeString($from->format('H:i'))
                            ->format('Y-m-d H:i'),
                        'back_date' => $tempDate
                            ->clone()
                            ->setTimeFromTimeString($back->format('H:i'))
                            ->format('Y-m-d H:i'),
                        'multiple' => true
                    ] + $address);
                    $tempDate->addDay();
                }
            }else{
                $result->push([
                    'multiple' => $from->isSameDay($back) ? true : $address['multiple']
                ] + $address);
            }
        });

        return $result;
    }

    public static function getMinimizedAddresses($raw, $noCheck = []) {
        $payload = [];
        $data    = collect($raw)
                    ->sort(fn($a, $b) => self::sortAddresses($a, $b))
                    ->values();
        $skipped = [];
        foreach ($data as $index => $address) {
            if (in_array($index, $skipped)) {
                continue;
            }

            $fromDate = Carbon::parse($address['from_date']);
            $backDate = Carbon::parse($address['back_date']);
            $stack = [];

            // Iterate through remaining data after current index
            for ($i = $index + 1; $i < $data->count(); $i++) {
                $nextAddress = $data[$i];

                // Check continuity conditions
                if (
                    (in_array('from_date', $noCheck) || $fromDate->copy()->addDays(count($stack) + 1)->eq(Carbon::parse($nextAddress['from_date']))) &&
                    (in_array('back_date', $noCheck) || $backDate->copy()->addDays(count($stack) + 1)->eq(Carbon::parse($nextAddress['back_date']))) &&
                    (in_array('plate', $noCheck)     || $address['plate'] === $nextAddress['plate']) &&
                    (in_array('distance', $noCheck)  || $address['distance'] === $nextAddress['distance']) &&
                    (in_array('multiple', $noCheck)  || $address['multiple'] === $nextAddress['multiple']) &&
                    (in_array('show_as', $noCheck)   || $address['show_as'] === $nextAddress['show_as']) &&
                    (in_array('from_id', $noCheck)   || $address['from_id'] === $nextAddress['from_id']) &&
                    (in_array('back_id', $noCheck)   || $address['back_id'] === $nextAddress['back_id'])
                ) {
                    $skipped[] = $i; // Mark this index as processed
                    $stack[] = $nextAddress; // Add to stack
                } else {
                    break; // Stop if conditions are not met
                }
            }

            $payload[] = array_merge(
                $address,
                [
                    'back_date' => count($stack) > 0 ? $stack[count($stack) - 1]['back_date'] : $address['back_date'], // Use last back_date if stacked
                    'multiple' => count($stack) > 0,
                ]
            );
        }

        // Final sort before returning
        usort($payload, fn ($a, $b) => self::sortAddresses($a, $b));

        return $payload;
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
