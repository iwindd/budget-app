<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['label' => 'ค่าเบี้ยเลี้ยงเดินทาง', 'merge' => false],
            ['label' => 'ค่าเช่าที่พัก', 'merge' => false],
            ['label' => 'ค่าพาหนะ', 'merge' => false],
            ['label' => 'ค่าใช้จ่ายอื่นๆ', 'merge' => false, 'default' => true],
        ];

        foreach ($data as $item) {
            Expense::factory()->create($item);
        }
    }
}
