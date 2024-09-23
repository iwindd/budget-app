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
        'place',
        'text',
        'user_id',
        'invitation_id',
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

    public function invitation() {
        return $this->belongsTo(Invitation::class);
    }

    public function office() {
        return $this->belongsTo(Office::class);
    }

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }
}
