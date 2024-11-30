<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetAddress extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'budget_id',
        'from_id',
        'from_date',
        'back_id',
        'back_date',
        'multiple',
        'plate',
        'distance',
        'show_as'
    ];

    protected $casts = [
        'multiple' => 'boolean',
    ];

    public static function list() {
        return collect([
            ['id' => 1, 'label' => 'บ้านพัก'],
            ['id' => 2, 'label' => 'สำนักงาน'],
            ['id' => 3, 'label' => 'ประเทศไทย']
        ]);
    }

    /**
     * Get the budget
     */
    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    public function getFromDateAttribute($value)
    {
        return $value ? date('Y-n-j H:i', strtotime($value)) : null;
    }

    public function getBackDateAttribute($value)
    {
        return $value ? date('Y-n-j H:i', strtotime($value)) : null;
    }

    public function getFromLabelAttribute()
    {
        $label = self::list()->firstWhere('id', $this->from_id)['label'] ?? null;
        return $label;
    }

    public function getBackLabelAttribute()
    {
        $label = self::list()->firstWhere('id', $this->back_id)['label'] ?? null;
        return $label;
    }
}
