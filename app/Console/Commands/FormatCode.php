<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class FormatCode extends Command
{
    protected $signature = 'code:format {file}';
    protected $description = 'Format PHP code in a file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filePath = $this->argument('file');
        $fixerPath = base_path('vendor/bin/php-cs-fixer');

        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $process = new Process([
            $fixerPath,
            'fix',
            $filePath,
            // '--rules=@PSR2',
            '--using-cache=no',
            // '--quiet',
        ]);

        $process->run();
//        dd($process->getOutput(), $filePath);

        if ($process->isSuccessful()) {
            $this->info("Code in $filePath has been formatted.");
        } else {
            $this->error("Code formatting failed.");
        }
    }
}
