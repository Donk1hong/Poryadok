<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Services\OllamaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class AiController extends Controller
{
    public function analyze(Request $request, OllamaService $ai)
    {
        set_time_limit(0);
        $path = $request->input('path');

        if (!$this->checkModel()) {
            return response()->json(['status' => 'downloading', 'message' => 'Model is being downloaded'], 202);
        }

        if (!File::isDirectory($path)) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $allItems = [];

        foreach (File::files($path) as $file) {
            $allItems[] = $file->getFilename() . " [FILE]";
        }

        foreach (File::directories($path) as $dir) {
            $name = basename($dir);
            $tag = "[FOLDER]";

            $isDev = File::exists($dir . '/.git') ||
                File::exists($dir . '/node_modules') ||
                File::exists($dir . '/composer.json') ||
                File::exists($dir . '/package.json') ||
                File::exists($dir . '/.env');

            if ($isDev) $tag = "[DEV_PROJECT_FOLDER]";

            $allItems[] = $name . " " . $tag;
        }

        if (empty($allItems)) {
            return response()->json(['message' => 'Empty'], 200);
        }

        $categories = $ai->categorizeFiles($allItems);
        $totalMoved = 0;

        foreach ($categories as $folderName => $names) {
            if (!is_array($names)) continue;

            $targetDir = $path . DIRECTORY_SEPARATOR . $folderName;
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir);
            }

            foreach ($names as $name) {
                $cleanName = trim(str_replace(['[FILE]', '[FOLDER]', '[DEV_PROJECT_FOLDER]'], '', $name));
                $oldPath = $path . DIRECTORY_SEPARATOR . $cleanName;
                $newPath = $targetDir . DIRECTORY_SEPARATOR . $cleanName;

                if ($oldPath === $targetDir || !File::exists($oldPath)) continue;

                if (File::move($oldPath, $newPath)) {
                    $totalMoved++;
                }
            }
        }

        $this->cleanup($path, array_keys($categories));

        History::create([
            'folder_name' => basename($path),
            'files_count' => $totalMoved,
            'details' => $categories
        ]);

        return response()->json(['status' => 'success', 'count' => $totalMoved]);
    }

    private function cleanup($path, $protected)
    {
        foreach (File::directories($path) as $dir) {
            if (in_array(basename($dir), $protected)) continue;
            if (count(File::allFiles($dir)) === 0 && count(File::directories($dir)) === 0) {
                File::deleteDirectory($dir);
            }
        }
    }

    public function checkModel()
    {
        $binaryPath = base_path('bin/ollama');

        $result = shell_exec("OLLAMA_HOST=127.0.0.1:11435 {$binaryPath} list 2>&1");

        if (is_null($result) || str_contains($result, 'error')) {
            \Log::error("Ollama connection error: " . ($result ?? 'Empty result'));
            return false;
        }

        if (!str_contains($result, 'llama3')) {
            Process::start("OLLAMA_HOST=127.0.0.1:11435 {$binaryPath} pull llama3");
            return false;
        }

        return true;
    }
}
