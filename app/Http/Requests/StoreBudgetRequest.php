<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
{
    protected $errorBag = 'upsertBudget';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'serial' => ['required', 'string', 'max:255'],
            'date' => ['required'],
            'value' => ['required', 'integer'],
            'order_at' => ['required'],
            'companions' => ['nullable', 'array'],
            'companions.*' => ['integer'],
            'address' => ['array'],
            'address.*.from' => ['integer', 'exists:locations,id'],
            'address.*.from_date' => ['date', 'date_format:Y-m-d H:i:s'],
            'address.*.back' => ['integer', 'exists:locations,id'],
            'address.*.back_date' => ['date', 'date_format:Y-m-d H:i:s'],
            'title' => ['required', 'string']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'serial' => $this->route('budget'),
        ]);
    }
}
