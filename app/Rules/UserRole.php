<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class UserRole implements ValidationRule
{
    protected string $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the user exists with the specified role
        if (!User::where('id', $value)->where('role', $this->role)->exists()) {
            $fail('The selected user is not a valid user with the role of ' . $this->role . '.');
        }
    }
}
