<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use Illuminate\Http\Request;
use Livewire\Component;

class Export extends Component
{
    public Budget $budget;
    protected $listeners = ['companionsUpdated' => 'refreshCompanions'];

    public function mount(Request $request)
    {
        $this->budget = $request->budget;
    }

    public function refreshCompanions()
    {
        $this->budget->load('companions');
    }

    public function render()
    {
        return view('livewire.budgets.export');
    }
}
