<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:request {name}';

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

        $this->make($getName);
    }

    protected function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    protected function make($name)
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
        $getTable = Str::slug($className);

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
        // create repositories interfaces
        if(file_exists("$pathRequests/$className".".php")) {
            $this->info($className." requests already created!");
        }else{
            file_put_contents("$pathRequests/$className".".php", $getContentRequests);
            $this->info($className." requests has been created!");
        }
    }

}
