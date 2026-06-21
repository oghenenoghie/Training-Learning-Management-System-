<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
    public function run(): void {
        $categories = [
            ['name' => 'Finance', 'color' => '#10B981', 'icon' => 'finance'],
            ['name' => 'Legal', 'color' => '#3B82F6', 'icon' => 'legal'],
            ['name' => 'Technology', 'color' => '#8B5CF6', 'icon' => 'technology'],
            ['name' => 'Management', 'color' => '#F59E0B', 'icon' => 'management'],
            ['name' => 'Oil & Gas', 'color' => '#EF4444', 'icon' => 'oil-gas'],
            ['name' => 'Real Estate', 'color' => '#EC4899', 'icon' => 'real-estate'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['slug' => Str::slug($cat['name'])])
            );
        }
    }
}
