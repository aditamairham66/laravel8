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
    protected $signature = 'create:module {name_table}';

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
        $getTable = $this->argument("name_table");

        $this->make($getTable);
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

    protected function make($tableName)
    {
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

        $columnTable = Schema::getColumnListing($tableName);
        $columnViewTable = collect($columnTable)
            ->filter(function ($row) {
                $except = ['id', 'created_at', 'updated_at', 'deleted_at', 'password'];
                return in_array($row, $except) ? false : true;
            })
            ->map(function ($row) use ($tableName) {
                $y = [];
                $y['name'] = $row;
                $y['type'] = Schema::getColumnType($tableName, $row);
                $y['isHaveParent'] = Str::contains($row, ['_id', 'id_']) ? true : false;
                return $y;
            });

        dd(Str::studly(Str::camel($tableName)));
    }
}
