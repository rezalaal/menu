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
}
