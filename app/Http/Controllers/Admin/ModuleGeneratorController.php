<?php

namespace App\Http\Controllers\Admin;

use App\Console\Commands\CreateControllerCommand;
use App\Http\Controllers\Controller;
use App\Repositories\Table\CmsModule\CmsModuleRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ModuleGeneratorController extends Controller
{
    private $cmsModuleRepositories;
    public function __construct(
        CmsModuleRepositories $cmsModuleRepositories
    )
    {
        $this->cmsModuleRepositories = $cmsModuleRepositories;
    }

    function getStep1(Request $request) 
    {
        $table = collect(Schema::getAllTables())
            ->filter(function ($row) {
               return !in_array($row->Tables_in_laravel, ['migrations', 'cms_notification', 'cms_privileges', 'cms_module']); 
            })->map(function ($row) {
                return $row->Tables_in_laravel;
            });
        $id = $request->get('id');
        return view('admin.module.step1', compact(
            'table',
            'id'
        ));
    }

    function getStep2(Request $request) 
    {
        $id = $request->get('id');
        $findModule = $this->cmsModuleRepositories->model->newQuery()
            ->find($id);
            
        $column = Schema::getColumnListing($findModule->table_name);
        return view('admin.module.step2', compact(
            "id",
            "column"
        ));
    }

    function postStep2(Request $request)
    {
        $table = $request->table;
        $name = Str::studly($request->name);

        // create model
        Artisan::call(CreateControllerCommand::class, [
            'name' => "Admin\\$name",
            'type' => "admin",
            '--tableName' => $table,
            '--withTable' => "yes",
        ]);
        
        // delete old module
        $this->cmsModuleRepositories->model->newQuery()
            ->where([
                "path" => $request->path,
                "controller" => $name."Controller",
            ])->delete();

        $saveModule = $this->cmsModuleRepositories->model;
        $saveModule->name = $request->name;
        $saveModule->icon = $request->icon;
        $saveModule->path = $request->path;
        $saveModule->table_name = $table;
        $saveModule->controller = $name."Controller";
        $saveModule->type = "route";
        $saveModule->is_active = 1;
        $saveModule->sorting = $this->cmsModuleRepositories->model->newQuery()->max('sorting') + 1;
        $saveModule->save();

        return redirect()->route('module-create.step2', [
            "id" => $saveModule->id,
        ]);
    }

    function getStep3(Request $request) 
    {
        $id = $request->get('id');
        return view('admin.module.step1', compact(
            "id"
        ));
    }

}
