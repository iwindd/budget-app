<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Rules\AddressBack;
use App\Rules\AddressFrom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddressPatial extends Component
{
    /* DATA */
    public $budget;
    public $addresses = [];

    /* FORM */
    public $address_id = '';
    public $from_location_id = '';
    public $from_date        = '';
    public $back_location_id = '';
    public $back_date        = '';

    /* ETC */
    protected $listeners = [
        'selectedFromLocationId',
        'selectedBackLocationId'
    ];

    /* CACHE */
    public $from_location_label = '';
    public $back_location_label = '';

    public function mount(Request $request)
    {
        $this->budget = $request->route('budget');
        $this->fetch();
    }

    private function fetch()
    {
        $item = $this->getBudgetItem();

        if ($item) $this->addresses = $item->addresses()->with("from")->with("back")->get()->toArray();
    }

    private function getBudgetItem(): BudgetItem | null
    {
        $budgetInstance = Budget::where('serial', $this->budget)->first();

        if (!$budgetInstance) {
            return null;
        };

        return $budgetInstance->budgetItems()->where('user_id', Auth::user()->id)->first();
    }

    public function save()
    {
        $this->resetValidation();
        $validated = $this->validate();
        $item = $this->getBudgetItem();
        $addressId = $validated['address_id'];
        unset($validated['address_id']);
        if (!$item) return $this->redirect('/');

        $item->addresses()->updateOrCreate(['id' => $addressId], $validated);
        $this->clear();
        $this->fetch();

        return redirect()->back();
    }

    public function clear()
    {
        $this->reset(['from_location_id', 'from_location_label', 'from_date', 'back_location_id', 'back_location_label', 'back_date', 'address_id']);
    }

    public function editAddress($index)
    {
        $item = $this->getBudgetItem();
        if (!$item) return $this->redirect('/');

        $data = $this->addresses[$index];
        $this->addresses[$index]['editing'] = true;
        $this->address_id = $data['id'];
        $this->from_location_id = $data['from_location_id'];
        $this->from_location_label = $data['from']['label'];
        $this->from_date = $data['from_date'];
        $this->back_location_id = $data['back_location_id'];
        $this->back_location_label = $data['back']['label'];
        $this->back_date = $data['back_date'];
    }

    public function cancelEditAddress($index)
    {
        $this->addresses[$index]['editing'] = false;
        $this->clear();
    }

    public function removeAddress($id)
    {
        $item = $this->getBudgetItem();
        if (!$item) return $this->redirect('/');

        $item->addresses()->where('id', $id)->delete();
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.budgets.address-patial');
    }

    public function rules()
    {
        return [
            'address_id' => ['nullable', 'integer'],
            'from_location_id' => ['required', 'integer', 'exists:locations,id'],
            'from_date' => ['required', 'date', 'date_format:Y-m-d\TH:i', new AddressFrom($this->budget, Auth::user()->id, empty($this->address_id) ? -1 : $this->address_id)],
            'back_location_id' => ['required', 'integer', 'exists:locations,id'],
            'back_date' => ['required', 'date', 'date_format:Y-m-d\TH:i', 'after_or_equal:from_date', new AddressBack($this->budget, Auth::user()->id, empty($this->address_id) ? -1 : $this->address_id)]
        ];
    }

    /* Listeners */

    public function selectedFromLocationId($item, $text)
    {
        $this->from_location_id = $item;
        $this->from_location_label = $text;
    }

    public function selectedBackLocationId($item, $text)
    {
        $this->back_location_id = $item;
        $this->back_location_label = $text;
    }
}
