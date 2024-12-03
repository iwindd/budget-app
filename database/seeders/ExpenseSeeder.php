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
            ['id' => 1, 'label' => 'ค่าเบี้ยเลี้ยงเดินทาง'],
            ['id' => 2, 'label' => 'ค่าเช่าที่พัก'],
            ['id' => 3, 'label' => 'ค่าพาหนะ'],
            ['id' => 4, 'label' => 'ค่าใช้จ่ายอื่นๆ'],
        ];

        foreach ($data as $item) {
            Expense::factory()->create($item);
        }
    }
}
