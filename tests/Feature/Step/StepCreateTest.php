<?php

namespace Tests\Feature\Step;

use App\Models\Step;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StepCreateTest extends TestCase
{
  use RefreshDatabase;

  public function test_models_can_be_instantiated(): void
  {
    $step = Step::factory()->create([
      'jha_id' => 1
    ]);

    $this->assertModelExists($step);
  }

  public function test_steps_can_be_created(): void
  {
    $this->seed();
    
    //10 jhas * 4 steps
    $this->assertDatabaseCount('steps', 40);
  }

}
