<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdministrativeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(public_path().'/administrative_unit.json'));
        foreach ($data as $province) {
            $provinceRecord = Province::updateOrCreate(
                ['name' => $province->name],
                ['name' => $province->name]
            );
            foreach ($province->districts as $district) {
                $districtRecord = District::updateOrCreate(
                    ['name' => $district->name, 'province_id' => $provinceRecord->id],
                    [
                        'name' => $district->name,
                        'province_id' => $provinceRecord->id,
                    ]
                );
                foreach ($district->wards as $ward) {
                    $wardRecord = Ward::updateOrCreate(
                        ['name' => $ward->name, 'district_id' => $districtRecord->id],
                        [
                            'name' => $ward->name,
                            'district_id' => $districtRecord->id,
                        ]
                    );
                }
            }
        }
    }
}
