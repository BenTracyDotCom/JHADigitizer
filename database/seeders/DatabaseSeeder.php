<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jha;
use App\Models\Step;
use App\Models\Hazard;
use App\Models\Control;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@example.com',
    ]); {
      /**
       * Run the database seeds.
       */

       // Create 10 JHA's
      Jha::factory(10)->create()->each(function ($jha) {
        // Create 4 steps for each JHA
        $steps = Step::factory(4)->create(['jha_id' => $jha->id]);
        $steps->each(function ($step) {
          // Create 2 hazards for each step
          $hazards = Hazard::factory(2)->create(['step_id' => $step->id]);
          // Add a control for each hazard
          $hazards->each(function ($hazard) {
            Control::factory()->create(['hazard_id' => $hazard->id]);
          });
        });
      });
    }
  }
}
