<?php

namespace Database\Seeders\Demo;

use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\PropertyImages;
use Illuminate\Database\Seeder;
use App\Models\AssignParameters;
use App\Models\PropertiesDocument;
use Illuminate\Support\Facades\DB;

class PropertiesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createProperties();
    }

    private function createProperties(): void
    {
        $properties = [
            [
                'category_id' => '1', // Villa
                'package_id' => null,
                'title' => 'Sunset Oasis Villa',
                'description' => 'Luxurious villa with modern amenities and beautiful sunset views.',
                'address' => '123 Palm Street',
                'client_address' => '123 Palm Street',
                'propery_type' => 0, // Sell
                'price' => 900000,
                'post_type' => '0', // Admin
                'city' => 'Anantnag',
                'country' => 'India',
                'state' => 'Jammu and Kashmir',
                'title_image' => '172118921010.jpg',
                'three_d_image' => '',
                'video_link' => '',
                'latitude' => '33.7311',
                'longitude' => '75.1547',
                'added_by' => 0, // Admin
                'status' => 1,
                'total_click' => 0,
                'slug_id' => 'sunset-oasis-villa',
                'meta_title' => 'Sunset Oasis Villa',
                'meta_description' => 'Luxurious villa with modern amenities and beautiful sunset views.',
                'meta_keywords' => 'villa, luxury, sunset, modern',
                'is_premium' => 1,
                'parameters' => [
                    [
                        'parameter_id' => 19, // Bedroom
                        'value' => 4
                    ],
                    [
                        'parameter_id' => 20, // Bathroom
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 21, // Kitchen
                        'value' => 1
                    ],
                    [
                        'parameter_id' => 37, // Area
                        'value' => 5000
                    ],
                    [
                        'parameter_id' => 38, // Parking
                        'value' => 4
                    ],
                    [
                        'parameter_id' => 39, // Furnishing
                        'value' => 'Furnished'
                    ],
                    [
                        'parameter_id' => 40, // Construction status
                        'value' => 'Ready to Move'
                    ],
                    [
                        'parameter_id' => 41, // Listed by
                        'value' => 'Owner'
                    ],
                    [
                        'parameter_id' => 42, // Extra Facilities
                        'value' => json_encode(['Park/Garden', 'Pool', 'Main Road', 'Club', 'Sea Facing', 'Gym'])
                    ]
                ],
                'images' => [
                    '172118921010.jpg',
                    '172118921043.jpg',
                    '172118921078.jpg',
                    '17211892102.jpg'
                ]
            ],
            [
                'category_id' => '2', // Penthouse
                'package_id' => null,
                'title' => 'The Promenade Penthouse',
                'description' => 'Stunning penthouse with panoramic city views and luxury finishes.',
                'address' => '456 Skyline Avenue',
                'client_address' => '456 Skyline Avenue',
                'propery_type' => 0, // Sell
                'price' => 1000000,
                'post_type' => '0', // Admin
                'city' => 'Ahmedabad',
                'country' => 'India',
                'state' => 'Gujarat',
                'title_image' => '172164950786.jpg',
                'three_d_image' => '',
                'video_link' => '',
                'latitude' => '23.0225',
                'longitude' => '72.5714',
                'added_by' => 0, // Admin
                'status' => 1,
                'total_click' => 0,
                'slug_id' => 'the-promenade-penthouse',
                'meta_title' => 'The Promenade Penthouse',
                'meta_description' => 'Stunning penthouse with panoramic city views and luxury finishes.',
                'meta_keywords' => 'penthouse, luxury, city view, modern',
                'is_premium' => 1,
                'parameters' => [
                    [
                        'parameter_id' => 19, // Bedroom
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 20, // Bathroom
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 21, // Kitchen
                        'value' => 1
                    ],
                    [
                        'parameter_id' => 37, // Area
                        'value' => 4000
                    ],
                    [
                        'parameter_id' => 38, // Parking
                        'value' => 2
                    ],
                    [
                        'parameter_id' => 39, // Furnishing
                        'value' => 'Furnished'
                    ],
                    [
                        'parameter_id' => 40, // Construction status
                        'value' => 'Ready to Move'
                    ],
                    [
                        'parameter_id' => 41, // Listed by
                        'value' => 'Agent'
                    ],
                    [
                        'parameter_id' => 42, // Extra Facilities
                        'value' => json_encode(['Park/Garden', 'Pool', 'Main Road', 'Club', 'Sea Facing', 'Gym'])
                    ]
                ],
                'images' => [
                    '172164950786.jpg'
                ]
            ],
            [
                'category_id' => '3', // Banglow
                'package_id' => null,
                'title' => 'Skyview Terrace Bungalow',
                'description' => 'Spacious bungalow with private garden and modern amenities.',
                'address' => '789 Garden Road',
                'client_address' => '789 Garden Road',
                'propery_type' => 0, // Sell
                'price' => 750000,
                'post_type' => '0', // Admin
                'city' => 'Mumbai',
                'country' => 'India',
                'state' => 'Maharashtra',
                'title_image' => '172196716236.jpg',
                'three_d_image' => '',
                'video_link' => '',
                'latitude' => '19.0760',
                'longitude' => '72.8777',
                'added_by' => 0, // Admin
                'status' => 1,
                'total_click' => 0,
                'slug_id' => 'skyview-terrace-bungalow',
                'meta_title' => 'Skyview Terrace Bungalow',
                'meta_description' => 'Spacious bungalow with private garden and modern amenities.',
                'meta_keywords' => 'bungalow, garden, modern, spacious',
                'is_premium' => 1,
                'parameters' => [
                    [
                        'parameter_id' => 19, // Bedroom
                        'value' => 4
                    ],
                    [
                        'parameter_id' => 20, // Bathroom
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 21, // Kitchen
                        'value' => 1
                    ],
                    [
                        'parameter_id' => 37, // Area
                        'value' => 6000
                    ],
                    [
                        'parameter_id' => 38, // Parking
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 39, // Furnishing
                        'value' => 'Furnished'
                    ],
                    [
                        'parameter_id' => 40, // Construction status
                        'value' => 'Ready to Move'
                    ],
                    [
                        'parameter_id' => 41, // Listed by
                        'value' => 'Owner'
                    ],
                    [
                        'parameter_id' => 42, // Extra Facilities
                        'value' => json_encode(['Park/Garden', 'Pool', 'Main Road', 'Club', 'Sea Facing', 'Gym'])
                    ]
                ],
                'images' => [
                    '172196716236.jpg'
                ]
            ],
            [
                'category_id' => '3', // Banglow
                'package_id' => null,
                'title' => 'Skyview Terrace Bungalow',
                'description' => 'Spacious bungalow with private garden and modern amenities.',
                'address' => '789 Garden Road',
                'client_address' => '789 Garden Road',
                'propery_type' => 0, // Sell
                'price' => 750000,
                'post_type' => '0', // Admin
                'city' => 'Mumbai',
                'country' => 'India',
                'state' => 'Maharashtra',
                'title_image' => '172196716236.jpg',
                'three_d_image' => '',
                'video_link' => '',
                'latitude' => '19.0760',
                'longitude' => '72.8777',
                'added_by' => 0, // Admin
                'status' => 1,
                'total_click' => 0,
                'slug_id' => 'skyview-terrace-bungalow',
                'meta_title' => 'Skyview Terrace Bungalow',
                'meta_description' => 'Spacious bungalow with private garden and modern amenities.',
                'meta_keywords' => 'bungalow, garden, modern, spacious',
                'is_premium' => 1,
                'parameters' => [
                    [
                        'parameter_id' => 19, // Bedroom
                        'value' => 4
                    ],
                    [
                        'parameter_id' => 20, // Bathroom
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 21, // Kitchen
                        'value' => 1
                    ],
                    [
                        'parameter_id' => 37, // Area
                        'value' => 6000
                    ],
                    [
                        'parameter_id' => 38, // Parking
                        'value' => 3
                    ],
                    [
                        'parameter_id' => 39, // Furnishing
                        'value' => 'Furnished'
                    ],
                    [
                        'parameter_id' => 40, // Construction status
                        'value' => 'Ready to Move'
                    ],
                    [
                        'parameter_id' => 41, // Listed by
                        'value' => 'Owner'
                    ],
                    [
                        'parameter_id' => 42, // Extra Facilities
                        'value' => json_encode(['Park/Garden', 'Pool', 'Main Road', 'Club', 'Sea Facing', 'Gym'])
                    ]
                ],
                'images' => [
                    '172196716236.jpg'
                ]
            ],
        ];

        foreach ($properties as $property) {
            $images = $property['images'];
            unset($property['images']);
            $parameters = $property['parameters'];
            unset($property['parameters']);

            // Insert property
            $propertyId = Property::insertGetId($property);

            // Insert property images
            if (isset($images)) {
                foreach ($images as $image) {
                    PropertyImages::insert([
                        'propertys_id' => $propertyId,
                        'image' => $image,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
            if(isset($documents)) {
                foreach ($documents as $document) {
                    PropertiesDocument::insert([
                        'property_id' => $propertyId,
                        'name' => $document,
                        'type' => 'image',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            if (isset($parameters)) {
                // Insert property parameters
                foreach ($parameters as $parameter) {
                    AssignParameters::insert([
                    'modal_type' => 'App\\Models\\Property',
                    'modal_id' => $propertyId,
                    'property_id' => 0,
                    'parameter_id' => $parameter['parameter_id'],
                    'value' => $parameter['value'],
                    'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
