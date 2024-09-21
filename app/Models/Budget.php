<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'serial',
        'title',
        'text',
        'user_id',
        'invitation_id',
        'location_id',
        'office_id',
        'date',
        'order_at',
        'value'
    ];

    /**
     * Get the user that created
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }
}
