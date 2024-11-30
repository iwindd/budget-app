<?php

namespace App\Livewire\Forms;

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

    public function sort($a, $b) {
        $dateA = Carbon::parse($a['from_date']);
        $dateB = Carbon::parse($b['from_date']);

        if ($dateA->isBefore($dateB)) {
            return -1;
        } elseif ($dateA->isAfter($dateB)) {
            return 1;
        }
        return 0;
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
        $result    = collect([]);
        $addresses = collect($addresses)
            ->sort(fn($a, $b) => $this->sort($a, $b))
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

    public function minimize($raw) {
        $payload = [];
        $data    = collect($raw)
                    ->sort(fn($a, $b) => $this->sort($a, $b))
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
                    $fromDate->copy()->addDays(count($stack) + 1)->eq(Carbon::parse($nextAddress['from_date'])) &&
                    $backDate->copy()->addDays(count($stack) + 1)->eq(Carbon::parse($nextAddress['back_date'])) &&
                    $address['plate'] === $nextAddress['plate'] &&
                    $address['distance'] === $nextAddress['distance'] &&
                    $address['multiple'] === $nextAddress['multiple']
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
        usort($payload, fn ($a, $b) => $this->sort($a, $b));

        return $payload;
    }
}
