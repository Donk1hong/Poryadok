<?php

namespace App\Providers;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (config('nativephp.running')) {
            $binaryPath = base_path('bin/ollama');

            if (file_exists($binaryPath)) {
                chmod($binaryPath, 0755);

                $command = "export OLLAMA_HOST=127.0.0.1:11435 && {$binaryPath} serve > /dev/null 2>&1 &";

                shell_exec($command);
            }
        }
    }
}
