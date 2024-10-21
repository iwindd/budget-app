<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemTravel extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'budget_item_id',
        'start',
        'end',
        'n'
    ];

    public function budgetItem()
    {
        return $this->belongsTo(BudgetItem::class);
    }

    public function budgetItemTravelItems()
    {
        return $this->hasMany(BudgetItemTravelItem::class);
    }
}
