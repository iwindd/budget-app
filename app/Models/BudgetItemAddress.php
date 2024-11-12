<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemAddress extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'from_location_id',
        'from_date',
        'back_location_id',
        'back_date',
        'plate',
        'distance',
        'multiple'
    ];

    protected $casts = [
        'multiple' => 'boolean'
    ];

    public function budgetItem()
    {
        return $this->belongsTo(BudgetItem::class);
    }

    public function from()
    {
        return $this->belongsTo(Location::class, "from_location_id");
    }

    public function back()
    {
        return $this->belongsTo(Location::class, "back_location_id");
    }
}
