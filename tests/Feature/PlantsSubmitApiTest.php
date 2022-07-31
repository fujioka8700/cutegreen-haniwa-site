<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PlantsSubmitApiTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->user = User::factory()->create();
  }

  /**
   * @test
   */
  public function should_ファイルをアップロードできる()
  {
    Storage::fake('s3');

    $response = $this->actingAs($this->user)->postJson(route('plant.create'), [
      'plant' => UploadedFile::fake()->image('plant.jpg'),
    ]);

    $response->assertStatus(201);

    $plant = Plant::first();

    $this->assertMatchesRegularExpression('/^[0-9a-zA-Z]{32}$/', $plant->id);

    Storage::cloud()->assertExists($plant->filename);
  }

  /**
   * @test
   */
  public function should_データベースエラーの場合はファイルを保存しない()
  {
    Schema::drop('plants');

    Storage::fake('s3');

    $response = $this->actingAs($this->user)->postJson(route('plant.create'), [
      'plant' => UploadedFile::fake()->image('plant.jpg'),
    ]);

    $response->assertStatus(500);

    $this->assertEquals(0, count(Storage::cloud()->files()));
  }

  /**
   * @test
   */
  public function should_ファイル保存時エラーの場合はDBへの挿入はしない()
  {
    Storage::shouldReceive('cloud')->once()->andReturnNull();

    $response = $this->actingAs($this->user)->postJson(route('plant.create'), [
      'plant' => UploadedFile::fake()->image('plant.jpg'),
    ]);

    $response->assertStatus(500);

    $this->assertEmpty(Plant::all());
  }
}
