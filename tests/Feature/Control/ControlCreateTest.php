<?php

namespace Tests\Feature\Control;

use App\Models\Control;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControlCreateTest extends TestCase
{
  use RefreshDatabase;

  public function test_models_can_be_instantiated(): void
  {
    $control = Control::factory()->create([
      'hazard_id' => 1
    ]);

    $this->assertModelExists($control);
  }

  public function test_controls_can_be_created(): void
  {
    $this->seed();
    
    //10 jhas * 4 steps * 2 hazards * 1 control
    $this->assertDatabaseCount('controls', 80);
  }

}
