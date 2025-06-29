<?php
namespace App\Services;


use OpenAI\Laravel\Facades\OpenAI;

class OpenAiService
{

    public function generateProductDescription(string $title): string
    {

        $response = OpenAI::chat()->create([
            'model' => config('openai.model_id'),
            'messages' =>
                [
                    [
                        'role' => 'user',
                        'content' => "یک توضیح کوتاه و بازاریابی پسند برای محصول " . $title . " بنویس که شامل مواد و خواص آن هم باشد",
                    ],
                ],
            ]);

        return $response->choices[0]->message->content ?? '';
    }

    public function generateOffer(string $content): string|null
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => config('openai.model_id'),
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $content,
                    ],
                ],
            ]);

            info('OpenAI Offer Response:', ['response' => $response->toArray()]);

            return $response->choices[0]->message->content ?? '';
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            // لاگ خطای دریافتی
            // \Log::error('OpenAI API error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return null;
        } catch (\Throwable $e) {
            // لاگ خطاهای پیش‌بینی نشده
            // \Log::error('Unexpected error in OpenAI offer generation', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return null;
        }
    }

}
