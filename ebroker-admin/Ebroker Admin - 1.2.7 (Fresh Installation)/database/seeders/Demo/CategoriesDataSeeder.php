<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCategories();
    }

    public function createCategories()
    {
        $categories = [
            [
                'category' => 'Villa',
                'parameter_types' => '19,20,27,37,38,39,40,41,42,43,44',
                'image' => '1677671289.9696.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'villa',
                'meta_title' => 'Villa',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ],
            [
                'category' => 'Penthouse',
                'parameter_types' => '36,45,46,47,48,49,50',
                'image' => '1677671674.2534.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'penthouse',
                'meta_title' => 'Penthouse',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ],
            [
                'category' => 'Banglow',
                'parameter_types' => '19,20,21,25,27,28,29',
                'image' => '1677671549.2821.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'banglow',
                'meta_title' => 'Banglow',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ],
            [
                'category' => 'House',
                'parameter_types' => '29,20,19,21,25',
                'image' => '1677671427.9648.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'house-1',
                'meta_title' => 'House',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ],
            [
                'category' => 'Plote',
                'parameter_types' => '24',
                'image' => '1677741135.6339.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'plote',
                'meta_title' => 'Plote',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ],
            [
                'category' => 'Commercial',
                'parameter_types' => '20,25,26,29,30,34',
                'image' => '1677741196.5648.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'commercial',
                'meta_title' => 'Commercial',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ],
            [
                'category' => 'Condo',
                'parameter_types' => '36,45,46,47,48,49,50',
                'image' => '1707375013.4538.svg',
                'status' => 1,
                'sequence' => 0,
                'slug_id' => 'condo-1',
                'meta_title' => 'Condo',
                'meta_keywords' => 'Lifestyle Homes,Luxury Residences,Investment Properties,Family-Friendly Homes,Urban Living Spaces,Coastal Retreats,Countryside Estates,Modern Apartments,Historic Properties,Sustainable Living Spaces',
                'meta_description' => 'Explore our diverse range of properties, curated for every lifestyle. From luxurious residences to charming investment opportunities, discover the perfect category that speaks to your unique vision of home.',
                'meta_image' => ''
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}