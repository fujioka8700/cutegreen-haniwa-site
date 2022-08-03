<?php

namespace Tests\Feature;

use App\Models\Plant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlantDetailApiTest extends TestCase
{
  use RefreshDatabase;

  /**
   * @test
   */
  public function should_正しい構造のJSONを返却する()
  {
    Storage::fake('s3');

    Plant::factory()->count(3)->create();

    $plant = Plant::first();

    $response = $this->getJson(route('plant.show', [
      'id' => $plant->id,
    ]));

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $plant->id,
      'url' => $plant->url,
      'owner' => [
        'name' => $plant->owner->name,
      ],
    ]);
  }
}
