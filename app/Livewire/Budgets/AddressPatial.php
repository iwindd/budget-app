<?php

namespace App\Livewire\Budgets;

use Livewire\Component;

class AddressPatial extends Component
{
    public $data;
    public $errors;
    public $old;
    private $template = [
        [
            'from' => '',
            'from_date' => '',
            'back' => '',
            'back_date' => ''
        ]
    ];


    public function mount($errors, $old)
    {
        $this->data[] = [$this->template];
        $this->errors = $errors;
        $this->old = $old;

        if ($old) {
            foreach ($old as $index => $payload) {
                foreach ($payload as $key => $value) {
                    if (empty($this->data[$index])) {
                        $this->data[$index] = $this->template;
                    }

                    $this->data[$index][$key] = $value;
                }
            }
        }
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
