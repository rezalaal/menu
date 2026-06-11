<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Enums\OrderStatus;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;
use Illuminate\Support\Facades\Cache;

class AiOfferTest extends TestCase
{
    public function test_redirects_when_not_authenticated(): void
    {
        $response = $this->getJson('/api/get-offer');

        $response->assertStatus(401);
    }

    public function test_returns_offer_when_authenticated(): void
    {
        $user = User::factory()->create();

        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'پیشنهاد ویژه برای شما: قهوه اسپرسو',
                        ],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        $response = $this->actingAs($user)->getJson('/api/get-offer');

        $response->assertStatus(200)
            ->assertJsonStructure(['offer'])
            ->assertJson(['offer' => 'پیشنهاد ویژه برای شما: قهوه اسپرسو']);
    }

    public function test_returns_null_when_cached_within_4_hours(): void
    {
        $user = User::factory()->create();

        Cache::put("ai_offer_last_time_{$user->id}", now()->subHour(), now()->addHours(4));

        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'should not be called',
                        ],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        $response = $this->actingAs($user)->getJson('/api/get-offer');

        $response->assertStatus(200)
            ->assertJson([
                'offer' => null,
                'message' => 'پیشنهاد جدید در دسترس نیست. لطفا بعدا دوباره تلاش کنید.',
            ]);
    }

    public function test_includes_favorites_and_orders_in_prompt(): void
    {
        $user = User::factory()->create();
        $favoriteProduct = Product::factory()->create(['name' => 'قهوه اسپرسو']);
        $orderedProduct = Product::factory()->create(['name' => 'کیک شکلاتی']);

        $user->favorites()->attach($favoriteProduct);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => OrderStatus::PAID,
        ]);
        $order->orderLines()->create([
            'product_id' => $orderedProduct->id,
            'qty' => 1,
            'price' => 100000,
        ]);

        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'پیشنهاد بر اساس سلیقه شما',
                        ],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        $response = $this->actingAs($user)->getJson('/api/get-offer');

        $response->assertStatus(200)
            ->assertJson(['offer' => 'پیشنهاد بر اساس سلیقه شما']);
    }
}
