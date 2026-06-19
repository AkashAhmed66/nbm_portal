<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Make sure a service type / category exists so projects can be linked,
        // mirroring how services connect through service_categories.
        $serviceType = ServiceType::firstOrCreate(
            ['title' => 'Engineering'],
            ['status' => 'active', 'sln' => 1]
        );

        $serviceCategory = ServiceCategory::firstOrCreate(
            ['title' => 'Construction', 'service_type_id' => $serviceType->id],
            ['status' => 'active', 'sln' => 1]
        );

        $projects = [
            [
                'title' => 'City Center Tower',
                'description' => '<p>A 24-storey commercial tower delivered on schedule with sustainable design at its core.</p>',
                'image' => 'no_thumb.jpg',
                'clientName' => 'Skyline Holdings Ltd.',
                'location' => 'Dhaka, Bangladesh',
                'duration' => '18 Months',
                'sln' => 1,
            ],
            [
                'title' => 'Riverside Bridge',
                'description' => '<p>A 1.2 km cable-stayed bridge connecting two districts and easing daily commute for thousands.</p>',
                'image' => 'no_thumb.jpg',
                'clientName' => 'National Highway Authority',
                'location' => 'Chittagong, Bangladesh',
                'duration' => '30 Months',
                'sln' => 2,
            ],
            [
                'title' => 'Green Valley Residences',
                'description' => '<p>A gated residential community of 120 eco-friendly apartments with shared green spaces.</p>',
                'image' => 'no_thumb.jpg',
                'clientName' => 'Green Valley Developers',
                'location' => 'Sylhet, Bangladesh',
                'duration' => '24 Months',
                'sln' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::create(array_merge($project, [
                'service_category_id' => $serviceCategory->id,
                'status' => 'active',
            ]));
        }
    }
}
