<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name} {type=general} {--tableName=""} {--withTable=no}';

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
        $getTable= $this->option("tableName");
        $getWithTable= $this->option("withTable");

        $this->make($getName, $getType, $getTable, $getWithTable);
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function make($name, $type, $getTable, $isWithTable)
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
        if (empty($getTable)) {
            $getTable = Str::camel($className);
        }

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
            $fieldTable = $this->fieldTable($getTable);
            $classField = implode("\n", $fieldTable->class);
            $addField = $fieldTable->code;
            $editField = $fieldTable->code;
            // get base template repositories
            $getContentControllerAdmin= file_get_contents(__DIR__.'/stub/controller/controller_admin.blade.php.stub');
            // change {path_class}
            $getContentControllerAdmin = str_replace('{path_class}', $pathName, $getContentControllerAdmin);
            // change {class_name}
            $getContentControllerAdmin = str_replace('{class_name}', $className, $getContentControllerAdmin);
            // change {file_name}
            $getContentControllerAdmin = str_replace('{file_name}', $getTable, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{table_class}', Str::studly($getTable), $getContentControllerAdmin);
            // change field
            $getContentControllerAdmin = str_replace('{classField}', $classField, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{addField}', $addField, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{editField}', $editField, $getContentControllerAdmin);
            // create repositories interfaces
            if(file_exists("$pathController\\$className"."Controller.php")) {
                unlink("$pathController\\$className"."Controller.php");
            }

            file_put_contents("$pathController\\$className"."Controller.php", $getContentControllerAdmin);
            
            $this->call(FormatCode::class, [
                'file' => "$pathController\\$className"."Controller.php"
            ]);
            $this->info($className." controller created!");
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

    protected function fieldTable($tableName)
    {
        $columnTable = Schema::getColumnListing($tableName);
        $fieldTable = collect($columnTable)
            ->filter(function ($row) {
                $except = ['id', 'created_at', 'updated_at', 'deleted_at'];
                return in_array($row, $except) ? false : true;
            });

        $code = "";
        $class = [];
        foreach ($fieldTable as $row) {
            if (in_array($row, ['image', 'photo'])) {
                $code .= "\$".$row." = Upload::move('$row', 'profile', 'Yes'); \n";
                $code .= "if (\$".$row.") { \n";
                $code .= "\$save->".$row." = \$".$row."; \n";
                $code .= "} \n";

                $class[] = "use App\Helpers\Upload;";
            } elseif ($row == "password") {
                $code .= "if (\$save->".$row.") { \n";
                $code .= "\$save->".$row." = Hash::make(\$request->".$row."); \n";
                $code .= "} \n";

                $class[] = "use Illuminate\Support\Facades\Hash;";
            } else {
                $code .= "\$save->".$row."; \n";
            }
        }

        return (object) [
            "code" => $code,
            "class" => $class,
        ];
    }

}
