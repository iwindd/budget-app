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
}
