<?php

namespace App\Livewire\Forms;

use Carbon\Carbon;
use Livewire\Form;

class BudgetItemAddressForm extends Form
{
    public $from_id, $back_id;
    public $from_date, $back_date;
    public $dates = [];
    public $from_time = '09:00';
    public $back_time = '17:00';
    public $plate, $distance, $multiple = true;

    public function submit() {
        $validated = $this->validate([
            'from_id' => ['required', 'integer'],
            'back_id' => ['required', 'integer'],
            'plate' => ['required', 'string'],
            'distance' => ['required', 'integer'],
            'from_time' => ['required', 'date_format:H:i'],
            'back_time' => ['required', 'date_format:H:i'],
            'multiple' => ['required', 'boolean'], // from client
            'dates' => ['array', 'required'],
            'dates.*' => ['date', 'date_format:Y-n-j']
        ]);

        $validated['multiple'] = $this->isMultiple($validated); // check one day

        return $validated;
    }

    public function clear() {
        $this->reset(['dates']);
    }

    private function isMultiple($validated) {
        if (count($validated['dates']) <= 1) return false;

        if ($validated['multiple']){
            $fromDate = Carbon::parse($validated['dates'][0] . ' ' . $validated['from_time']);
            $backDate = Carbon::parse($validated['dates'][count($validated['dates'])-1] . ' ' . $validated['back_time']);

            return $backDate->diffInDays($fromDate) >= 1;
        }

        return false;
    }
}
