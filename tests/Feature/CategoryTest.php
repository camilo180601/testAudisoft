<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pantalla_lista_las_categorias(): void
    {
        Category::factory()->create(['name' => 'Electrónicos']);

        $this->get(route('categories.index'))
            ->assertOk()
            ->assertSee('Electrónicos');
    }

    public function test_se_puede_agregar_una_categoria(): void
    {
        $this->post(route('categories.store'), ['name' => 'Ropa'])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Ropa']);
    }

    public function test_el_nombre_de_categoria_es_obligatorio(): void
    {
        $this->post(route('categories.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_el_nombre_de_categoria_no_se_repite(): void
    {
        Category::factory()->create(['name' => 'Ropa']);

        $this->post(route('categories.store'), ['name' => 'Ropa'])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    public function test_las_categorias_se_paginan_de_a_cuatro(): void
    {
        Category::factory()->count(6)->create();

        $response = $this->get(route('categories.index'));

        $response->assertOk();
        $this->assertCount(4, $response->viewData('categories'));
        $response->assertSee('page=2');
    }

    public function test_no_se_puede_eliminar_una_categoria_en_uso(): void
    {
        $category = Category::factory()->create();
        Site::factory()->create(['category_id' => $category->id]);

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_se_puede_eliminar_una_categoria_sin_uso(): void
    {
        $category = Category::factory()->create();

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
