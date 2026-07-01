<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pantalla_principal_lista_los_sitios(): void
    {
        $site = Site::factory()->create(['name' => 'Zara']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Zara')
            ->assertSee($site->category->name);
    }

    public function test_se_puede_agregar_un_sitio(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('sites.store'), [
            'name' => 'Librería Nacional',
            'url' => 'https://librerianacional.com/',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('sites.index'));
        $this->assertDatabaseHas('sites', [
            'name' => 'Librería Nacional',
            'url' => 'https://librerianacional.com/',
            'category_id' => $category->id,
        ]);
    }

    public function test_la_url_sin_esquema_se_normaliza_a_https(): void
    {
        $category = Category::factory()->create();

        $this->post(route('sites.store'), [
            'name' => 'Ejemplo',
            'url' => 'www.ejemplo.com',
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('sites', ['url' => 'https://www.ejemplo.com']);
    }

    public function test_el_sitio_requiere_nombre_url_y_categoria(): void
    {
        $this->post(route('sites.store'), [])
            ->assertSessionHasErrors(['name', 'url', 'category_id']);

        $this->assertDatabaseCount('sites', 0);
    }

    public function test_el_sitio_requiere_una_categoria_existente(): void
    {
        $this->post(route('sites.store'), [
            'name' => 'Ejemplo',
            'url' => 'https://ejemplo.com',
            'category_id' => 999,
        ])->assertSessionHasErrors('category_id');
    }

    public function test_se_puede_eliminar_un_sitio(): void
    {
        $site = Site::factory()->create();

        $this->delete(route('sites.destroy', $site))
            ->assertRedirect(route('sites.index'));

        $this->assertDatabaseMissing('sites', ['id' => $site->id]);
    }
}
