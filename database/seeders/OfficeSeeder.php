<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::factory()->create([
            'label' => "มหาวิทยาลัยราชภัฏสุราษฎร์ธานี",
            'province' => 67,
            'default' => true
        ]);
    }
}
