<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:request {name} {--tableName=} {--column=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create request';

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
        $getTableName = $this->option("tableName");
        $getColumn = $this->option("column");

        $this->make($getName, $getTableName, $getColumn);
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function make($name, $getTableName, $getColumn)
    {
        $listPath = explode('\\', $name);
        // get name controller
        $endPath = end($listPath);
        // get path controller
        $pathName = str_replace("\\$endPath", '', $name);
        // create class name
        $className = str_replace(['controller', 'Controller', 'controllers', 'Controllers'], '', $endPath);
        $className = Str::studly($className);

        if (empty($getColumn)) {
            $columnTable = Schema::getColumnListing($getTableName);
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

        // make class name folder
        $pathRequests = $this->appPath("Http\Requests\\$pathName");
        if(!file_exists($pathRequests)) {
            @mkdir($pathRequests, 0755);
        }

        // get base template repositories
        $getContentRequests = file_get_contents(__DIR__.'/stub/controller/controller_request.blade.php.stub');
        // change {path_class}
        $getContentRequests = str_replace('{path_class}', $pathName, $getContentRequests);
        // change {class_name}
        $getContentRequests = str_replace('{class_name}', $className, $getContentRequests);
        $html = [];
        foreach ($getColumn as $row) {
            $html[] = "\t\t\t".'"'.$row->name.'" => '.'"'.$row->validation.'"';
        }
        $getContentRequests = str_replace('$rules', implode(",\n", $html), $getContentRequests);

        if(file_exists("$pathRequests\\$className.php")) {
            unlink("$pathRequests\\$className.php");
        }

        file_put_contents("$pathRequests/$className.php", $getContentRequests);

        $this->info($className." requests has been created!");
    }

}
