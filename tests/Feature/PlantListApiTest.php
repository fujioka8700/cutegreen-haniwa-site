<?php

namespace Tests\Feature;

use App\Models\Plant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlantListApiTest extends TestCase
{
  use RefreshDatabase;

  /**
   * @test
   */
  public function should_正しい構造のJSONを返却する()
  {
    Storage::fake('s3');

    Plant::factory()->count(3)->create();

    $response = $this->getJson(route('plant.index'));

    $plants = Plant::with(['owner'])->orderBy('created_at', 'desc')->get();

    $expected_data = $plants->map(function($plant) {
      return [
        'id' => $plant->id,
        'url' => $plant->url,
        'owner' => [
          'name' => $plant->owner->name
        ],
      ];
    })->all();

    $response->assertJsonFragment([
      'data' => $expected_data
    ]);
  }
}
