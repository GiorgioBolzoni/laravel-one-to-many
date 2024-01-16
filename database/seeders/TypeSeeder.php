<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Casa', 'Cucina', 'Ufficio', 'Giochi', 'Notizie'];
        foreach ($types as $value) {
            $newType = new Type();
            $newType->name = $value;
            $newType->slug = Str::slug($value, '-');
            $newType->save();
        }
    }
}
