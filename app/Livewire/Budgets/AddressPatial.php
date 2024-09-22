<?php

namespace App\Livewire\Budgets;

use Livewire\Component;

class AddressPatial extends Component
{
    public $data;
    private $template = [
        [
            'from' => '', 
            'from-date' => '',
            'back' => '',
            'back-date' => ''
        ]
    ];


    public function mount()
    {
        $this->data[] = [$this->template];
    }
 
    public function addAddress()
    {
        $this->data[] = [$this->template];
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
