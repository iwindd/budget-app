<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemTravelItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'plate',
        'start',
        'driver',
        'location',
        'end',
        'distance',
        'round'
    ];

    public function budgetItemTravel()
    {
        return $this->belongsTo(BudgetItemTravel::class);
    }
}
