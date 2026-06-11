<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\OpenAiService;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Exceptions\ErrorException;

class OpenAiServiceTest extends TestCase
{
    private OpenAiService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new OpenAiService();
    }

    public function test_generate_product_description_returns_string(): void
    {
        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'یک قهوه عالی با طعم بی‌نظیر',
                        ],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        $result = $this->service->generateProductDescription('قهوه اسپرسو');

        $this->assertIsString($result);
        $this->assertEquals('یک قهوه عالی با طعم بی‌نظیر', $result);
    }

    public function test_generate_offer_returns_string_on_success(): void
    {
        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'پیشنهاد ویژه: قهوه اسپرسو',
                        ],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        $result = $this->service->generateOffer('test content');

        $this->assertIsString($result);
        $this->assertEquals('پیشنهاد ویژه: قهوه اسپرسو', $result);
    }

    public function test_generate_offer_returns_null_on_exception(): void
    {
        OpenAI::fake([
            new ErrorException(
                [
                    'type' => 'server_error',
                    'code' => 500,
                    'message' => 'Server Error',
                ],
                500
            ),
        ]);

        $result = $this->service->generateOffer('test content');

        $this->assertNull($result);
    }
}
