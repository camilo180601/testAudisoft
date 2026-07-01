<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Site;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Datos de ejemplo basados en la prueba técnica.
     */
    public function run(): void
    {
        $categories = collect([
            'Libros',
            'Ropa',
            'Zapatos',
            'Electrónicos',
            'Música',
            'Comida',
        ])->mapWithKeys(fn (string $name) => [
            $name => Category::firstOrCreate(['name' => $name]),
        ]);

        $sites = [
            ['name' => 'Librería Nacional', 'url' => 'https://librerianacional.com/', 'category' => 'Libros'],
            ['name' => 'Zara', 'url' => 'https://www.zara.com/co/', 'category' => 'Ropa'],
            ['name' => 'Bosi', 'url' => 'https://www.bosi.com.co/', 'category' => 'Zapatos'],
        ];

        foreach ($sites as $site) {
            Site::firstOrCreate(
                ['url' => $site['url']],
                [
                    'name' => $site['name'],
                    'category_id' => $categories[$site['category']]->id,
                ],
            );
        }
    }
}
