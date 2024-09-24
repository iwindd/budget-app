<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['label' => 'บ้านพัก'],
            ['label' => 'สำนักงาน'],
            ['label' => 'ประเทศไทย']
        ];

        foreach ($data as $item) {
            Location::factory()->create($item);
        }
    }
}
