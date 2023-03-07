<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateServicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:service {table=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service class structured with interface class.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $getTable = $this->argument("table");

        $this->call(CreateModelCommand::class, [
            'table' => $getTable
        ]);

        if ($getTable != "null") {
            $this->make($getTable);
        } else {
            $this->info("Table is not defined.");
        }
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function make($table)
    {
        if (!Schema::hasTable($table)) {
            $this->info("Table $table is not defined or found.");
            return;
        }

        // make Repositories folder
        $pathRepositories = $this->appPath('Repositories');
        if(!file_exists($pathRepositories)) {
            @mkdir($pathRepositories, 0755);
        }

        // make Repositories\Interfaces folder
        $pathRepositoriesInterfaces = $this->appPath('Repositories\Interfaces');
        if(!file_exists($pathRepositoriesInterfaces)) {
            @mkdir($pathRepositoriesInterfaces, 0755);
        }

        // make Repositories\Table folder
        $pathRepositoriesTable = $this->appPath('Repositories\Table');
        if(!file_exists($pathRepositoriesTable)) {
            @mkdir($pathRepositoriesTable, 0755);
        }

        // make class name from Table
        $className = Str::studly($table);

        // make class name folder
        $pathRepositoriesClassInterfaces = $this->appPath('Repositories\Interfaces'."\\".$className);
        if(!file_exists($pathRepositoriesClassInterfaces)) {
            @mkdir($pathRepositoriesClassInterfaces, 0755);
        }
        $pathRepositoriesClassTable = $this->appPath('Repositories\Table'."\\".$className);
        if(!file_exists($pathRepositoriesClassTable)) {
            @mkdir($pathRepositoriesClassTable, 0755);
        }

        // get base template repositories
        $getContentRepositoriesInterfaces = file_get_contents(__DIR__.'/stub/repositories/repo_interface.blade.php.stub');
        // change {class_name}
        $getContentRepositoriesInterfaces = str_replace('{class_name}', $className, $getContentRepositoriesInterfaces);
        // create repositories interfaces
        if(file_exists("$pathRepositoriesClassInterfaces/$className"."Interface.php")) {
            $this->info($className." repositories interfaces already created!");
        }else{
            file_put_contents("$pathRepositoriesClassInterfaces/$className"."Interface.php", $getContentRepositoriesInterfaces);
            $this->info($className." repositories interfaces has been created!");
        }

        // get base template repositories
        $getContentRepositoriesTable = file_get_contents(__DIR__.'/stub/repositories/repo_table.blade.php.stub');
        // change {class_name}
        $getContentRepositoriesTable = str_replace('{class_name}', $className, $getContentRepositoriesTable);
        // create repositories interfaces
        if(file_exists("$pathRepositoriesClassTable/$className"."Repositories.php")) {
            $this->info($className." repositories already created!");
        }else{
            file_put_contents("$pathRepositoriesClassTable/$className"."Repositories.php", $getContentRepositoriesTable);
            $this->info($className." repositories has been created!");
        }
    }

}
