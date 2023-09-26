<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:module {name} {--tableName=} {--column=}';

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

        // create model
        $this->call(CreateModelCommand::class, [
            'table' => $tableName
        ]);
        // create service
        $this->call(CreateServicesCommand::class, [
            'table' => $tableName
        ]);

        if (empty($getColumn)) {
            $columnTable = Schema::getColumnListing($tableName);
            $getColumn = collect($columnTable)
                ->filter(function ($row) {
                    return !in_array($row, ['id', 'created_at', 'updated_at', 'deleted_at', 'password']);
                })
                ->map(function ($row, $i) use ($tableName) {
                    return (object) [
                        "label" => Str::title(str_replace(['_'], ' ', $row)),
                        "name" => $row,
                        "is_image" => (in_array($row, ['image', 'photo']) ? 1 : 0),
                        "is_download" => 0,
                        "type" => Schema::getColumnType($tableName, $row),
                        "isHaveParent" => Str::contains($row, ['_id', 'id_']) ? true : false,
                    ];
                })->toArray();
        }

        // make Repositories folder
        $pathView = $this->viewPath("admin\page\\$pathName");
        if(!file_exists($pathView)) {
            @mkdir($pathView, 0755);
        }

        $labelTable = collect($getColumn)
            ->map(function ($row) {
                return "<th>$row->label</th>";
            })->toArray();
        $labelTable = implode(PHP_EOL, $labelTable);
        $labelTable = collect(explode(PHP_EOL, $labelTable))->map(function ($row) {
            return "\t\t\t\t" . $row;
        })->implode(PHP_EOL);
        $fieldTable = $this->nameTable($getColumn);
        $columnTable = implode(PHP_EOL, $fieldTable->code);
        $columnTable = collect(explode(PHP_EOL, $columnTable))->map(function ($row) {
            return "\t\t\t\t\t" . $row;
        })->implode(PHP_EOL);

        // get base template module
        $getContentModuleIndex = file_get_contents(__DIR__.'/stub/module/index.blade.php.stub');
        // change field
        $getContentModuleIndex = str_replace('[columnName]', $labelTable, $getContentModuleIndex);
        $getContentModuleIndex = str_replace('[column]', $columnTable, $getContentModuleIndex);
        // create repositories interfaces
        if(file_exists("$pathView\\index.blade.php")) {
            unlink("$pathView\\index.blade.php");
        }
        file_put_contents("$pathView\\index.blade.php", $getContentModuleIndex);

        $getContentModuleIndex2 = file_get_contents(__DIR__.'/stub/module/form.blade.php.stub');
        $getContentModuleIndex2 = str_replace('$pathName', $pathName, $getContentModuleIndex2);
        if(file_exists("$pathView\\"."form.blade.php")) {
            unlink("$pathView\\"."form.blade.php");
        }
        file_put_contents("$pathView\\"."form.blade.php", $getContentModuleIndex2);

        $this->info($pathName." index.blade.php blade created!");
        $this->info($pathName." form.blade.php blade created!");
    }

    protected function nameTable($column)
    {
        $code = [];
        foreach ($column as $row) {
            if ($row->is_image == 1) {
                $code[] = "<td>
                \t\t<a
                \t\t\tdata-fslightbox='lightbox-basic'
                \t\t\trel='group_'
                \t\t\ttitle='Self Photo: '
                \t\t\thref='{{ asset(\$rowRes->".$row->name.") }}'
                \t\t>
                \t\t\t<img width='40px' height='40px' src='{{ asset(\$rowRes->".$row->name.") }}'>
                \t\t</a>
                \t</td> ";
            } else {
                $code[] = "<td>{{ \$rowRes->".$row->name." }}</td>";
            }
        }

        return (object) [
            "code" => $code,
        ];
    }
}
