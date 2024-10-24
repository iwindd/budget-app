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

    protected $casts = [
        'default' => 'boolean',
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
     * deactivatedInvitation
     *
     * @return void
    */
    public static function deactivated() {
        return self::where('default', true)->update(['default' => false]);
    }

    public static function setActive(Invitation $invitation) {
        self::deactivated();
        return $invitation->update(['default' => true]);
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
