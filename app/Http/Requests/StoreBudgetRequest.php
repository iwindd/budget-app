<?php

namespace App\Http\Requests;

use App\Rules\UserRole;
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
            'title' => ['required', 'string'],
            'serial' => ['required', 'string', 'max:255'],
            'date' => ['required'],
            'value' => ['required', 'integer'],
            'order_at' => ['required'],
            'companions' => ['array'],
            'companions.*' => ['integer', new UserRole('USER')],
            'address' => ['array'],
            'address.*.from_location_id' => ['required', 'integer', 'exists:locations,id'],
            'address.*.from_date' => ['required', 'date', 'date_format:Y-m-d\TH:i'],
            'address.*.back_location_id' => ['required', 'integer', 'exists:locations,id'],
            'address.*.back_date' => ['required', 'date', 'date_format:Y-m-d\TH:i'],
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'address.*.from_location_id' => 'เดินทางจาก',
            'address.*.from_date' => 'ตั้งแต่วันที่/เวลา',
            'address.*.back_location_id' => 'กลับถึง',
            'address.*.back_date' => 'วันที่/เวลา',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'serial' => $this->route('budget'),
        ]);
    }
}
