<?php

namespace Tests\Feature\Jha;

use App\Models\Jha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JhaCreateTest extends TestCase
{
  use RefreshDatabase;

  public function test_models_can_be_instantiated(): void
  {
    $jha = Jha::factory()->create();

    $this->assertModelExists($jha);
  }

  public function test_jhas_can_be_created(): void
  {
    $this->seed();

    $this->assertDatabaseCount('jhas', 10);
  }

  public function test_jhas_can_be_added_via_api(): void
  {

    $this->post('/api/jhas', [
      'title' => 'test JHA',
      'author' => 'John Doe',
    ]);

    $this->assertDatabaseHas('jhas', [
      'title' => 'test JHA',
      'author' => 'John Doe'
    ]);
  }

  public function test_jhas_require_tile_and_author(): void
  {
    $response = $this->post('/api/jhas', [
      'title' => 'First JHA'
    ]);
    
    $response->assertRedirect('/');

    $this->assertDatabaseMissing('jhas', [
      'title' => 'First JHA'
    ]);

    $response = $this->post('/api/jhas', [
      'author' => 'John Doe'
    ]);
    
    $response->assertRedirect('/');

    $this->assertDatabaseMissing('jhas', [
      'author' => 'John Doe'
    ]);


  }
}
