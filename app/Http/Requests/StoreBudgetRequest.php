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
            'serial' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string'],
            'place' => ['required', 'string'],
            'date' => ['required'],
            'value' => ['required', 'integer'],
            'order_at' => ['required'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'serial' => $this->route('budget'),
        ]);
    }
}
