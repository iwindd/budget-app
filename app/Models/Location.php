<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
    ];

    /**
     * Get the user that created
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFromAddresses()
    {
        return $this->hasMany(BudgetItemAddress::class, 'from_location_id');
    }

    public function getBackAddresses()
    {
        return $this->hasMany(BudgetItemAddress::class, 'back_location_id');
    }
}
