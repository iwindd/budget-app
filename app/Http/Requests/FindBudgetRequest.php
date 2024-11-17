<?php

namespace App\Http\Requests;

use App\Rules\BudgetRelevant;
use Illuminate\Foundation\Http\FormRequest;

class FindBudgetRequest extends FormRequest
{
    protected $errorBag = 'findBudget';
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
            'serial' => ['required', 'string', 'max:255', new BudgetRelevant],
        ];
    }
}
