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
    protected $signature = 'create:controller {name} {type=general} {--tableName=} {--withTable=no} {--tableAction=} {--column=}';

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
        $getType = $this->argument("type");
        $getTable = $this->option("tableName");
        $getWithTable = $this->option("withTable");
        $getTableAction = $this->option("tableAction");
        $getColumn = $this->option("column");

        $this->make($getName, $getType, $getTable, $getWithTable, $getTableAction, $getColumn);
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function make($name, $type, $getTable, $isWithTable, $getTableAction, $getColumn)
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

        if (empty($getColumn)) {
            $columnTable = Schema::getColumnListing($getTable);
            $getColumn = collect($columnTable)
                ->filter(function ($row) {
                    return !in_array($row, ['id', 'created_at', 'updated_at', 'deleted_at']);
                })->map(function ($row) {
                    if (in_array($row, ['image', 'photo'])) {
                        $type = "file";
                    } elseif (in_array($row, ['desc', 'description'])) {
                        $type = "textarea";
                    } else {
                        $type = "text";
                    }
                    return (object) [
                        "label" => Str::title(str_replace(['_'], ' ', $row)),
                        "name" => $row,
                        "type" => $type,
                        "validation" => "required",
                        "is_required" => true
                    ];
                });
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
                    '--column' => $getColumn,
                ]);
                $this->call(CreateRequestCommand::class, [
                    'name' => "Admin\\$className\\Edit".$className."Request",
                    '--column' => $getColumn,
                ]);
            }
        }

        // make Repositories folder
        $pathController = $this->appPath("Http\Controllers\\$pathName");
        if(!file_exists($pathController)) {
            @mkdir($pathController, 0755);
        }

        if ($type == "admin") {
            $fieldTable = $this->fieldTable($getColumn);

            $classField = implode("\n", $fieldTable->class);
            $addParams = implode("\n", $fieldTable->params);
            $addField = $fieldTable->code;
            $editParams = implode("\n", $fieldTable->params);
            $editField = $fieldTable->code;

            $isAdd = true;
            if (!empty($getTableAction['isAdd'])) {
                $isAdd = $getTableAction['isAdd'];
            }

            $isEdit = true;
            if (!empty($getTableAction['isEdit'])) {
                $isEdit = $getTableAction['isEdit'];
            }

            $isDelete = true;
            if (!empty($getTableAction['isDelete'])) {
                $isDelete = $getTableAction['isDelete'];
            }

            $isDetail = true;
            if (!empty($getTableAction['isDetail'])) {
                $isDetail = $getTableAction['isDetail'];
            }

            $isShow = true;
            if (!empty($getTableAction['isShow'])) {
                $isShow = $getTableAction['isShow'];
            }

            $isBulkButton = true;
            if (!empty($getTableAction['isBulkButton'])) {
                $isBulkButton = $getTableAction['isBulkButton'];
            }

            // get base template repositories
            $getContentControllerAdmin= file_get_contents(__DIR__.'/stub/controller/controller_admin.blade.php.stub');
            // change {path_class}
            $getContentControllerAdmin = str_replace('{path_class}', $pathName, $getContentControllerAdmin);
            // change {class_name}
            $getContentControllerAdmin = str_replace('{class_name}', $className, $getContentControllerAdmin);
            // change {file_name}
            $getContentControllerAdmin = str_replace('{file_name}', Str::camel(Str::studly($className)), $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{table_class}', Str::studly($getTable), $getContentControllerAdmin);
            // change field
            $getContentControllerAdmin = str_replace('{classField}', $classField, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{addParams}', $addParams, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{addField}', $addField, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{editParams}', $editParams, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('{editField}', $editField, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('$isAdd', $isAdd, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('$isEdit', $isEdit, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('$isDelete', $isDelete, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('$isDetail', $isDetail, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('$isShow', $isShow, $getContentControllerAdmin);
            $getContentControllerAdmin = str_replace('$isBulkButton', $isBulkButton, $getContentControllerAdmin);
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
                $this->call(FormatCode::class, [
                    'file' => "$pathController\\$className"."Controller.php"
                ]);
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
                $this->call(FormatCode::class, [
                    'file' => "$pathController\\$className"."Controller.php"
                ]);
                $this->info($className." controller has been created!");
            }
        }
    }

    protected function fieldTable($fieldTable)
    {
        $code = "";
        $class = [];
        $params = [];
        foreach ($fieldTable as $row) {
            if (in_array($row->name, ['image', 'photo'])) {
                $class[] = "use App\Helpers\Upload;";

                $params[] = "\$".$row->name." = Upload::move('$row->name', 'profile', 'Yes');";
                $code .= "if (\$".$row->name.") { \n";
                $code .= "\$save->".$row->name." = \$".$row->name."; \n";
                $code .= "} \n";

            } elseif ($row->name == "password") {
                $class[] = "use Illuminate\Support\Facades\Hash;";

                $code .= "if (\$save->".$row->name.") { \n";
                $code .= "\$save->".$row->name." = Hash::make(\$request->".$row->name."); \n";
                $code .= "} \n";
            } else {
                $code .= "\$save->".$row->name." = \$request->".$row->name."; \n";
            }
        }

        return (object) [
            "class" => $class,
            "params" => $params,
            "code" => $code,
        ];
    }

}
