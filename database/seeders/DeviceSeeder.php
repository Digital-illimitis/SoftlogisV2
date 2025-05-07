<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Dollars;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $devices = [
            [
                'valeur' => '000',
            ],
        ];

        foreach ($devices as $device) {
            Device::updateOrCreate(
                ['valeur' => $device['valeur']],
                ['uuid' => Str::uuid()]
            );
        }
    }

}
