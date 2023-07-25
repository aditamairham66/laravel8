<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name} {type=general} {--no-table=no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new controller class structured. type has two is: general, admin.';

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
        $getName = $this->argument("name");
        $getType= $this->argument("type");
        $getWithTable= $this->option("no-table");

        $this->make($getName, $getType, $getWithTable);
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function make($name, $type, $isWithTable)
    {
        $listPath = explode('\\', $name);
        // get name controller
        $endPath = end($listPath);
        // get path controller
        $pathName = str_replace("\\$endPath", '', $name);
        // create class name
        $className = str_replace(['controller', 'Controller', 'controllers', 'Controllers'], '', $endPath);
        $className = Str::studly($className);
        // get table name
        $getTable = Str::snake($className);

        if ($isWithTable == "yes") {
            // create model
            $this->call(CreateModelCommand::class, [
                'table' => $getTable
            ]);
            // create service
            $this->call(CreateServicesCommand::class, [
                'table' => $getTable
            ]);
            if ($type == "admin") {
                // create request
                $this->call(CreateRequestCommand::class, [
                    'name' => "Admin\\$className\\Add".$className."Request",
                ]);
                $this->call(CreateRequestCommand::class, [
                    'name' => "Admin\\$className\\Edit".$className."Request",
                ]);
            }
        }

        // make Repositories folder
        $pathController = $this->appPath("Http\Controllers\\$pathName");
        if(!file_exists($pathController)) {
            @mkdir($pathController, 0755);
        }

        if ($type == "admin") {
            // get base template repositories
            $getContentControllerAdmin= file_get_contents(__DIR__.'/stub/controller/controller_admin.blade.php.stub');
            // change {path_class}
            $getContentControllerAdmin = str_replace('{path_class}', $pathName, $getContentControllerAdmin);
            // change {class_name}
            $getContentControllerAdmin = str_replace('{class_name}', $className, $getContentControllerAdmin);
            // change {file_name}
            $getContentControllerAdmin = str_replace('{file_name}', $getTable, $getContentControllerAdmin);
            // create repositories interfaces
            if(file_exists("$pathController\\$className"."Controller.php")) {
                $this->info($className." controller already created!");
            }else{
                file_put_contents("$pathController\\$className"."Controller.php", $getContentControllerAdmin);
                $this->info($className." controller has been created!");
            }
        }

        if ($type == "general") {
            // get base template repositories
            $getContentControllerCommon = file_get_contents(__DIR__.'/stub/controller/controller_common.blade.php.stub');
            // change {path_class}
            $getContentControllerCommon = str_replace('{path_class}', $pathName, $getContentControllerCommon);
            // change {class_name}
            $getContentControllerCommon = str_replace('{class_name}', $className, $getContentControllerCommon);
            // create repositories interfaces
            if(file_exists("$pathController\\$className"."Controller.php")) {
                $this->info($className." controller already created!");
            }else{
                file_put_contents("$pathController\\$className"."Controller.php", $getContentControllerCommon);
                $this->info($className." controller has been created!");
            }
        }

        if ($type == "api") {
            // get base template repositories
            $getContentControllerCommon = file_get_contents(__DIR__.'/stub/controller/controller_api.blade.php.stub');
            // change {path_class}
            $getContentControllerCommon = str_replace('{path_class}', $pathName, $getContentControllerCommon);
            // change {class_name}
            $getContentControllerCommon = str_replace('{class_name}', $className, $getContentControllerCommon);
            // create repositories interfaces
            if(file_exists("$pathController\\$className"."Controller.php")) {
                $this->info($className." controller already created!");
            }else{
                file_put_contents("$pathController\\$className"."Controller.php", $getContentControllerCommon);
                $this->info($className." controller has been created!");
            }
        }
    }

}
