<?php

namespace Tests\Feature\Hazard;

use App\Models\Hazard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HazardCreateTest extends TestCase
{
  use RefreshDatabase;

  public function test_models_can_be_instantiated(): void
  {
    $hazard = Hazard::factory()->create([
      'step_id' => 1
    ]);

    $this->assertModelExists($hazard);
  }

  public function test_hazards_can_be_created(): void
  {
    $this->seed();
    
    //10 jhas * 4 steps * 2 hazards
    $this->assertDatabaseCount('hazards', 80);
  }

}
