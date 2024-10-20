<?php

namespace App\Livewire\Forms;

use App\Models\BudgetItem;
use App\Models\BudgetItemAddress;
use App\Models\Location;
use App\Rules\AddressBack;
use App\Rules\AddressFrom;
use Livewire\Form;

class BudgetItemAddressForm extends Form
{
    public ?BudgetItemAddress $budgetItemAddress;
    public $from_location_id;
    public $from_date;
    public $back_location_id;
    public $back_date;

    private function onLocationSelectorChanged(String $name, ?Location $location)
    {
        return $this->getComponent()->dispatch("onLocationSelectorChanged", [
            'name' => $name,
            'value' => $this->getPropertyValue($name),
            'label' => $location->label ?? ""
        ]);
    }

    public function setBudgetItemAddress(BudgetItemAddress $budgetItemAddress)
    {
        $this->budgetItemAddress = $budgetItemAddress;
        /* FORMS */
        $this->from_location_id  = $budgetItemAddress->from_location_id;
        $this->from_date         = $budgetItemAddress->from_date;
        $this->back_location_id  = $budgetItemAddress->back_location_id;
        $this->back_date         = $budgetItemAddress->back_date;

        $this->onLocationSelectorChanged("from_location_id", $budgetItemAddress->from);
        $this->onLocationSelectorChanged("back_location_id", $budgetItemAddress->back);
    }

    public function clear()
    {
        return $this->setBudgetItemAddress(new BudgetItemAddress());
    }

    public function save(BudgetItem $budgetItem)
    {
        $validated = $this->validate([
            'from_location_id' => ['required', 'integer', 'exists:locations,id'],
            'from_date' => ['required', 'date', new AddressFrom($budgetItem, $this->budgetItemAddress)],
            'back_location_id' => ['required', 'integer', 'exists:locations,id'],
            'back_date' => ['required', 'date', 'after_or_equal:from_date', new AddressBack($budgetItem, $this->budgetItemAddress)]
        ]);

        /* SAVE */
        $budgetItemAddress = $this->budgetItemAddress;
        if ($budgetItemAddress->exists) {
            $budgetItemAddress->fill($validated);
            $budgetItemAddress->save();
        } else {
            $budgetItem->budgetItemAddresses()->create($validated);
        }

        /* CLEAR */
        $this->clear();
    }
}
