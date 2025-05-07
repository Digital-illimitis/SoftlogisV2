<?php

namespace Database\Seeders;

use App\Models\Dollars;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DollarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dollars = [
            [
                'type' => 'dollar',
                'value' => '000',
            ],
        ];
    
        foreach ($dollars as $dollar) {
            Dollars::updateOrCreate(
                ['type' => $dollar['type'], 'value' => $dollar['value']],
                ['uuid' => Str::uuid()]
            );
        }
    }
    
}
