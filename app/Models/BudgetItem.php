<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that created
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * Get the address
    */
    public function addresses()
    {
        return $this->hasMany(BudgetItemAddress::class, 'budget_item_id');
    }
}
