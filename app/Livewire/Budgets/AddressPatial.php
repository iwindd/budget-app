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
    public $user;
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
        $isAdminBudget = request()->routeIs('budgets.show.admin');
        $key = $request->route('budget');
        $this->user = !$isAdminBudget ? Auth::user() : $key->user;
        $this->budget = !$isAdminBudget ? Budget::getUserBudgetBySerial($key, $this->user->id) : $key;
        $this->fetch();
    }

    private function fetch()
    {
        $this->addresses = $this->budget->addresses()->with("from")->with("back")->get()->toArray();
    }

    public function clear()
    {
        $this->reset(['from_location_id', 'from_location_label', 'from_date', 'back_location_id', 'back_location_label', 'back_date', 'address_id']);
    }

    public function save()
    {
        $validated = $this->validate();
        $this->budget->addresses()->updateOrCreate(['id' => $validated['address_id']], $validated);
        $this->clear();
        $this->fetch();
    }

    public function editAddress($index)
    {
        $data = $this->addresses[$index];
        $this->addresses[$index]['editing'] = true;
        $this->fill([
            'address_id' => $data['id'],
            'from_location_id' => $data['from_location_id'],
            'from_location_label' => $data['from']['label'],
            'from_date' => $data['from_date'],
            'back_location_id' => $data['back_location_id'],
            'back_location_label' => $data['back']['label'],
            'back_date' => $data['back_date'],
        ]);
    }

    public function cancelEditAddress($index)
    {
        $this->addresses[$index]['editing'] = false;
        $this->clear();
    }

    public function removeAddress($id)
    {
        $this->budget->addresses()->where('id', $id)->delete();
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.budgets.address-patial');
    }

    private function formatAddressValidation() {
        return empty($this->address_id) ? -1 : $this->address_id;
    }

    public function rules()
    {
        $serial = $this->budget->budget->serial;
        $user_id = $this->user->id;
        $address_id = $this->formatAddressValidation();

        return [
            'address_id' => ['nullable', 'integer'],
            'from_location_id' => ['required', 'integer', 'exists:locations,id'],
            'from_date' => ['required', 'date', 'date_format:Y-m-d\TH:i', new AddressFrom($serial, $user_id, $address_id)],
            'back_location_id' => ['required', 'integer', 'exists:locations,id'],
            'back_date' => ['required', 'date', 'date_format:Y-m-d\TH:i', 'after_or_equal:from_date', new AddressBack($serial, $user_id, $address_id)]
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
