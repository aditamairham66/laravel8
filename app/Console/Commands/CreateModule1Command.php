<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateModule1Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:module-form {name} {--tableName=""} {--column=[]}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create module include view, route, controller, validation only for backend.';

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
        $getTable = $this->option("tableName");
        $getColumn = $this->option("column");

        $this->make($getName, $getTable, $getColumn);
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function viewPath($path)
    {
        return base_path("resources".DIRECTORY_SEPARATOR."views") . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    protected function make($getName, $tableName, $getColumn)
    {
        $getName = Str::camel(Str::studly($getName));
        $listPath = explode('\\', $getName);
        // get name view
        $endPath = end($listPath);
        // get path view
        $pathName = str_replace("\\$endPath", '', $getName);
        // create class name
        $className = str_replace(['controller', 'Controller', 'controllers', 'Controllers'], '', $endPath);
        $className = Str::studly($className);

        if (!Schema::hasTable($tableName)) {
            $this->info("$tableName is not found in database ".env('DB_DATABASE'));
        }

        if (empty($getColumn)) {
            $columnTable = Schema::getColumnListing($tableName);
            $getColumn = collect($columnTable)
                ->filter(function ($row) {
                    $except = ['id', 'created_at', 'updated_at', 'deleted_at', 'password'];
                    return in_array($row, $except) ? false : true;
                })
                ->map(function ($row, $i) use ($tableName) {
                    if (in_array($row, ['image', 'photo'])) {
                        $type = "upload";
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

        $html = "";
        foreach ($getColumn as $row) {
            $getContentField = file_get_contents(__DIR__."/stub/module/type/$row->type/input.blade.php.stub");
            $getContentField = str_replace('$columnName', $row->label, $getContentField);
            $getContentField = str_replace('$column', $row->name, $getContentField);
            $getContentField = str_replace('$required', $row->is_required ? "true" : "false", $getContentField);
            $html .= $getContentField;
        }
        dd($getColumn, $html);

        // make Repositories folder
        $pathView = $this->viewPath("admin\page\\$pathName");
        if(!file_exists($pathView)) {
            @mkdir($pathView, 0755);
        }
    }
}
