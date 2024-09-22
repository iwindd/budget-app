<?php

namespace App\Livewire\Budgets;

use App\Models\Location;
use Livewire\Component;

class AddressPatial extends Component
{
    public $data;
    public $errors;
    public $old;
    public $locations;
    private $template = [
        'from_location_id' => '',
        'from_date' => '',
        'back_location_id' => '',
        'back_date' => ''
    ];


    public function mount($errors, $old)
    {
        $this->data[] = $this->template;
        $this->errors = $errors;
        $this->old = $old;
        $this->locations = [];
        $usingLocations = collect([]);

        if ($old) {
            foreach ($old as $index => $payload) {
                foreach ($payload as $key => $value) {
                    if (empty($this->data[$index])) {
                        $this->data[$index] = $this->template;
                    }

                    $this->data[$index][$key] = $value;

                    if ($key == "from_location_id" || $key == "back_location_id") {
                        $usingLocations->push($value);
                    }
                }
            }
        }

        if ($usingLocations->count() > 1) {
            $this->locations = Location::whereIn("id", $usingLocations)->get(['id', 'label'])->pluck('label', 'id')->toArray();
        }
    }

    public function addAddress()
    {
        $this->data[] = $this->template;
    }

    public function removeAddress($index)
    {
        // Remove the selected object from the array
        unset($this->data[$index]);

        // Reset the array keys to maintain proper indexing
        $this->data = array_values($this->data);
    }

    public function render()
    {
        return view('livewire.budgets.address-patial');
    }
}
