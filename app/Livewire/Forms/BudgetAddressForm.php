<?php

namespace App\Livewire\Forms;

use App\Models\Budget;
use Carbon\Carbon;
use Livewire\Form;

class BudgetAddressForm extends Form
{
    public $from_id, $back_id;
    public $from_date, $back_date;
    public $dates = [];
    public $from_time = '09:00';
    public $back_time = '17:00';
    public $plate, $distance, $multiple = true;
    public $show_as = "ค่าน้ำมันเชื้อเพลิง";

    public function submit() {
        $validated = $this->validate([
            'from_id' => ['required', 'integer'],
            'back_id' => ['required', 'integer'],
            'plate' => ['required', 'string'],
            'distance' => ['required', 'numeric'],
            'from_time' => ['required', 'date_format:H:i'],
            'back_time' => ['required', 'date_format:H:i'],
            'multiple' => ['required', 'boolean'], // from client
            'show_as' => ['required', 'string'],
            'dates' => ['array', 'required'],
            'dates.*' => ['date', 'date_format:Y-m-d']
        ]);

        return $validated;
    }

    public function clear() {
        $this->reset(['dates']);
    }

    public function splitDates(array $dates)
    {
        // Convert the date strings to Carbon instances and sort them
        $carbonDates = collect($dates)
            ->map(fn($date) => Carbon::parse($date))
            ->sort();

        $result = collect();
        $tempGroup = collect([$carbonDates->first()]);

        foreach ($carbonDates->slice(1) as $index => $date) {
            $previousDate = $carbonDates->values()[$index];

            if ($date->diffInDays($previousDate) === 1) {
                $tempGroup->push($date);
            } else {
                $result->push($tempGroup);
                $tempGroup = collect([$date]);
            }
        }

        // Add the last group
        if ($tempGroup->isNotEmpty()) {
            $result->push($tempGroup);
        }

        // Format each date group as strings
        return $result->map(
            fn($group) => $group->map(fn($date) => $date->format('Y-m-d'))
        );
    }

    public function extract(array $addresses) {
        return Budget::getExtractAddresses($addresses);
    }

    public function minimize($raw) {
        return Budget::getMinimizedAddresses($raw);
    }
}
