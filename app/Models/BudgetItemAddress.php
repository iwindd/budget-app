<?php

namespace App\Models;

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
        'back_date'
    ];

    public function owner()
    {
        return $this->belongsTo(BudgetItem::class);
    }

    public function from()
    {
        return $this->belongsTo(Location::class, "id", "from_location_id");
    }

    public function back()
    {
        return $this->belongsTo(Location::class, "id", "back_location_id");
    }
}
