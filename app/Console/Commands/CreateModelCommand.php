<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {table=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new model class structured with entity class.';

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

        // make Models folder
        $pathModels = $this->appPath('Models');
        if(!file_exists($pathModels)) {
            @mkdir($pathModels, 0755);
        }

        // make Models\Entity folder
        $pathModelsEntity = $this->appPath('Models\Entity');
        if(!file_exists($pathModelsEntity)) {
            @mkdir($pathModelsEntity, 0755);
        }

        // make Models\Table folder
        $pathModelsTable = $this->appPath('Models\Table');
        if(!file_exists($pathModelsTable)) {
            @mkdir($pathModelsTable, 0755);
        }

        // make class name from Table
        $className = Str::studly($table);

        // get base template model
        $getContentModelEntity = file_get_contents(__DIR__.'/stub/model/model_entity.blade.php.stub');
        // change {class_name}
        $getContentModelEntity = str_replace('{class_name}', $className, $getContentModelEntity);
        // change {table_name}
        $getContentModelEntity = str_replace('{table_name}', $table, $getContentModelEntity);
        // create model entity
        if(file_exists("$pathModelsEntity/$className.php")) {
            $this->info($className." model entity already created!");
        }else{
            file_put_contents("$pathModelsEntity/$className.php", $getContentModelEntity);
            $this->info($className." model entity has been created!");
        }

        // get base template model
        $getContentModelTable = file_get_contents(__DIR__.'/stub/model/model_table.blade.php.stub');
        // change {class_name}
        $getContentModelTable = str_replace('{class_name}', $className, $getContentModelTable);
        // create model entity
        if(file_exists("$pathModelsTable/$className"."Table.php")) {
            $this->info($className." model table already created!");
        }else{
            file_put_contents("$pathModelsTable/$className"."Table.php", $getContentModelTable);
            $this->info($className." model table has been created!");
        }
    }

}
