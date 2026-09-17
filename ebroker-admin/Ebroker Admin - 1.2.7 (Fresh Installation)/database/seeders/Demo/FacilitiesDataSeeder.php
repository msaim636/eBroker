<?php

namespace Database\Seeders\Demo;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParametersDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createFacilities();
    }

    public function createFacilities()
    {
        $facilities = [
            [
                'id' => 19,
                'name' => 'Bedroom',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677733164.2028.svg',
                'is_required' => 0
            ],
            [
                'id' => 20,
                'name' => 'Bathroom',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677733139.1517.svg',
                'is_required' => 0
            ],
            [
                'id' => 21,
                'name' => 'Kitchen',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677733120.444.svg',
                'is_required' => 0
            ],
            [
                'id' => 22,
                'name' => 'Garage',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740426.0293.svg',
                'is_required' => 0
            ],
            [
                'id' => 23,
                'name' => 'Reception',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740460.1318.svg',
                'is_required' => 0
            ],
            [
                'id' => 24,
                'name' => 'Area',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740477.8671.svg',
                'is_required' => 0
            ],
            [
                'id' => 25,
                'name' => 'Parking',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740510.7362.svg',
                'is_required' => 0
            ],
            [
                'id' => 26,
                'name' => 'Security',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740529.9557.svg',
                'is_required' => 0
            ],
            [
                'id' => 27,
                'name' => 'Balconies',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740564.8168.svg',
                'is_required' => 0
            ],
            [
                'id' => 28,
                'name' => 'Pool',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740608.7743.svg',
                'is_required' => 0
            ],
            [
                'id' => 29,
                'name' => 'Ac',
                'type_of_parameter' => 'textbox',
                'type_values' => '',
                'image' => '1677740623.3241.svg',
                'is_required' => 0
            ],
            [
                'id' => 30,
                'name' => 'CCTV',
                'type_of_parameter' => 'textbox',
                'type_values' => '',
                'image' => '1677740638.383.svg',
                'is_required' => 0
            ],
            [
                'id' => 31,
                'name' => 'Fitness',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1677740667.3054.svg',
                'is_required' => 0
            ],
            [
                'id' => 34,
                'name' => 'Wifi',
                'type_of_parameter' => 'textbox',
                'type_values' => '',
                'image' => '1677740755.9703.svg',
                'is_required' => 0
            ],
            [
                'id' => 36,
                'name' => 'Layout - Number',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1690463042.317.svg',
                'is_required' => 0
            ],
            [
                'id' => 37,
                'name' => 'Build  Area (ft2)',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1691468108.8814.svg',
                'is_required' => 0
            ],
            [
                'id' => 38,
                'name' => 'Carpet  Area (ft2)',
                'type_of_parameter' => 'number',
                'type_values' => '',
                'image' => '1691468174.2614.svg',
                'is_required' => 0
            ],
            [
                'id' => 39,
                'name' => 'Furnishing',
                'type_of_parameter' => 'radiobutton',
                'type_values' => '{"0":"Furnished","1":"Semi-Furnished","2":"Unfurnished"}',
                'image' => '1691468254.1887.svg',
                'is_required' => 0
            ],
            [
                'id' => 40,
                'name' => 'Construction status',
                'type_of_parameter' => 'radiobutton',
                'type_values' => '{"0":"Ready to Move","1":"Under Construction","2":"New Launch"}',
                'image' => '1691468310.8009.svg',
                'is_required' => 0
            ],
            [
                'id' => 41,
                'name' => 'Listed by',
                'type_of_parameter' => 'dropdown',
                'type_values' => '{"0":"Owner","1":"Dealer","2":"Agent","3":"Broker"}',
                'image' => '1691468778.2773.svg',
                'is_required' => 0
            ],
            [
                'id' => 42,
                'name' => 'Extra Facilities',
                'type_of_parameter' => 'checkbox',
                'type_values' => '{"0":"Park\/Garden","1":"Pool","2":"Main Road","3":"Club","4":"Sea Facing","5":"Gym"}',
                'image' => '1691468848.6083.svg',
                'is_required' => 0
            ],
            [
                'id' => 43,
                'name' => 'Property Brochure',
                'type_of_parameter' => 'file',
                'type_values' => '',
                'image' => '1691468873.0802.svg',
                'is_required' => 0
            ],
            [
                'id' => 44,
                'name' => 'What makes your property special?',
                'type_of_parameter' => 'textarea',
                'type_values' => '',
                'image' => '1691468918.7694.svg',
                'is_required' => 0
            ],
            [
                'id' => 45,
                'name' => 'Layout - TB',
                'type_of_parameter' => 'textbox',
                'type_values' => '',
                'image' => '1707375013.4538_1.svg',
                'is_required' => 0
            ],
            [
                'id' => 46,
                'name' => 'Layout - TA',
                'type_of_parameter' => 'textarea',
                'type_values' => '',
                'image' => '1707375013.4538_2.svg',
                'is_required' => 0
            ],
            [
                'id' => 47,
                'name' => 'Layout - DP',
                'type_of_parameter' => 'dropdown',
                'type_values' => '{"0":"1","1":"2","2":"3"}',
                'image' => '1707375013.4538_3.svg',
                'is_required' => 0
            ],
            [
                'id' => 48,
                'name' => 'Layout - Radio',
                'type_of_parameter' => 'radiobutton',
                'type_values' => '{"0":"a","1":"b","2":"c"}',
                'image' => '1707375013.4538_4.svg',
                'is_required' => 0
            ],
            [
                'id' => 49,
                'name' => 'Layout - CB',
                'type_of_parameter' => 'checkbox',
                'type_values' => '{"0":"1","1":"2","2":"3"}',
                'image' => '1707375013.4538_5.svg',
                'is_required' => 0
            ],
            [
                'id' => 50,
                'name' => 'Layout - file',
                'type_of_parameter' => 'file',
                'type_values' => '',
                'image' => '1707375013.4538_6.svg',
                'is_required' => 0
            ]
        ];

        if(!empty($facilities)){
            Parameter::insert($facilities);
        }
    }
}
