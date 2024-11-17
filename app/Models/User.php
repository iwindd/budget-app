<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check user is role
     *
     * @return Boolean
     */
    public static function isRole(User $user, $role) {
        return $user->role == $role;
    }

    /**
     * Get the user position
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the positions created
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

        /**
     * Get the user affiliation
     */
    public function affiliation()
    {
        return $this->belongsTo(Affiliation::class);
    }

    /**
     * Get the affiliations created
     */
    public function affiliations()
    {
        return $this->hasMany(Affiliation::class);
    }

    /**
     * Get the locations created
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }


    /**
     * Get the expenses created
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the offices created
     */
    public function offices()
    {
        return $this->hasMany(Office::class);
    }

    /**
     * Get the invitations created
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Get the budgets created
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
