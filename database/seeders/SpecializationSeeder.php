<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = ['OPD', 'Ear', 'Eyes', 'Cardiology'];

        foreach ($specializations as $name) {
            Specialization::create(['name' => $name]);
        }
    }
}
