<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    public function categorizeFiles(array $items): array
    {
        $prompt = "Ты — экспертный ИИ для сортировки данных. Твоя цель — идеальный порядок.

        КАТЕГОРИИ:
        1. Проекты: Любые ПАПКИ [FOLDER]. Если в названии есть 'lab', 'pr', 'test', 'app', 'hub', 'vue', 'js', 'php', 'json', 'data', 'logic', 'code' — это Проекты.
        2. Архивы: СТРОГО только файлы .zip, .rar, .7z, .tar. ПАПКА НЕ МОЖЕТ БЫТЬ АРХИВОМ.
        3. Изображения: .jpg, .png, .webp, .svg, .psd.
        4. Документы: .pdf, .docx, .xlsx, .txt.
        5. Программы: .dmg, .exe, .pkg, .app.
        6. Видео: .mp4, .mov, .avi.
        7. Прочее: Всё остальное.

        ПРАВИЛА:
        - Если объект помечен как [FOLDER] или [DEV_PROJECT_FOLDER] — это приоритет для категории 'Проекты'.
        - Если это файл .zip — это 'Архивы'.
        - Верни ТОЛЬКО JSON. Ключи: 'Проекты', 'Изображения', 'Документы', 'Программы', 'Архивы', 'Видео', 'Прочее'.

        СПИСОК:
        " . implode(', ', $items);

        try {
            $response = Http::timeout(120)->post('http://127.0.0.1:11435/api/generate', [
                'model' => 'llama3',
                'prompt' => $prompt,
                'stream' => false,
                'format' => 'json',
                'keep_alive' => 0
            ]);

            return json_decode($response->json('response'), true) ?: [];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return [];
        }
    }
}
