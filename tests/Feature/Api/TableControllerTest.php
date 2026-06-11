<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Table;

class TableControllerTest extends TestCase
{
    public function test_returns_table_by_id(): void
    {
        $table = Table::factory()->create([
            'name' => 'میز شماره یک',
            'called_waiter' => false,
        ]);

        $response = $this->getJson("/api/table/{$table->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'name', 'called_waiter', 'image_url', 'video_url']])
            ->assertJsonPath('data.id', $table->id)
            ->assertJsonPath('data.name', 'میز شماره یک')
            ->assertJsonPath('data.called_waiter', false);
    }

    public function test_returns_422_for_nonexistent_table(): void
    {
        $response = $this->getJson('/api/table/99999');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id']);
    }
}
