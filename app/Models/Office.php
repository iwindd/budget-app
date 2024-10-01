<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'province',
        'default'
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * Get the office where default is true.
     *
     * @return Office|null
     */
    public static function getOffice($column = '*') {
        return self::select($column)->where('default', true)->first();
    }

    /**
     * deactivatedInvitation
     *
     * @return void
    */
    public static function deactivated() {
        return self::where('default', true)->update(['default' => false]);
    }

    /**
     * Get the user that created
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
