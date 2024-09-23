<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'default'
    ];

    /**
     * Get the invitation where default is true.
     *
     * @return Invitation|null
     */
    public static function getInvitation($column = '*') {
        return self::select($column)->where('default', true)->first();
    }

    /**
     * Get the user that created
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
