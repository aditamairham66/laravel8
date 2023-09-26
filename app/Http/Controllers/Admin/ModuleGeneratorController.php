<?php

namespace App\Http\Controllers\Admin;

use App\Console\Commands\CreateControllerCommand;
use App\Console\Commands\CreateModule1Command;
use App\Console\Commands\CreateModuleCommand;
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

    public function postStep1(Request $request)
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

    function getStep2(Request $request)
    {
        $id = $request->get('id');
        $findModule = $this->cmsModuleRepositories->model->newQuery()
            ->find($id);

        $column = collect(Schema::getColumnListing($findModule->table_name))
            ->filter(function ($row) {
                $except = ['id', 'created_at', 'updated_at', 'deleted_at', 'password'];
                return !in_array($row, $except);
            })
            ->map(function ($row) {
                return (object) [
                    "label" => Str::title(str_replace(['_', 'id'], [' ', ''], $row)),
                    "name" => $row,
                ];
            });
        return view('admin.module.step2', compact(
            "id",
            "column"
        ));
    }

    function postStep2(Request $request)
    {
        $findModule = $this->cmsModuleRepositories->model->newQuery()
            ->find($request->id);

        Artisan::call(CreateControllerCommand::class, [
            'name' => "Admin\\$findModule->name",
            'type' => "admin",
            '--tableName' => $findModule->table_name,
            '--withTable' => "yes",
        ]);

        Artisan::call(CreateModuleCommand::class, [
            'name' => $findModule->name,
            '--tableName' => $findModule->table_name,
            '--column' => collect(request('name'))
                ->filter(function ($row) {
                    return !in_array($row, ["", null]);
                })
                ->map(function ($row, $i) use ($findModule) {
                    return (object) [
                        "label" => request('column')[$i],
                        "name" => $row,
                        "is_image" => request('is_image')[$i],
                        "is_download" => request('is_download')[$i],
                        "type" => Schema::getColumnType($findModule->table_name, $row),
                        "isHaveParent" => Str::contains($row, ['_id', 'id_']) ? true : false,
                    ];
                }),
        ]);

        return redirect()->route('module-create.step3', [
            "id" => $findModule->id,
        ]);
    }

    function getStep3(Request $request)
    {
        $id = $request->get('id');
        $findModule = $this->cmsModuleRepositories->model->newQuery()
            ->find($id);

        $column = collect(Schema::getColumnListing($findModule->table_name))
            ->filter(function ($row) {
                $except = ['id', 'created_at', 'updated_at', 'deleted_at', 'password'];
                return !in_array($row, $except);
            })
            ->map(function ($row) {
                return (object) [
                    "label" => Str::title(str_replace(['_', 'id'], [' ', ''], $row)),
                    "name" => $row,
                ];
            });
        return view('admin.module.step3', compact(
            "id",
            "column"
        ));
    }

    public function postStep3(Request $request)
    {
        $findModule = $this->cmsModuleRepositories->model->newQuery()
            ->find($request->id);

        Artisan::call(CreateModule1Command::class, [
            'name' => $findModule->name,
            '--tableName' => $findModule->table_name,
            '--column' => collect(request('name'))
                ->filter(function ($row) {
                    return !in_array($row, ["", null]);
                })
                ->map(function ($row, $i) {
                    return (object) [
                        "label" => request('label')[$i],
                        "name" => $row,
                        "type" => request('type')[$i],
                        "validation" => request('validation')[$i],
                    ];
                }),
        ]);
        dd($request->all());

        return redirect()->route('module-create.step4', [
            "id" => $findModule->id,
        ]);
    }

    public function getStep4(Request $request)
    {
        $id = $request->get('id');
        return view('admin.module.step4', compact(
            "id"
        ));
    }

    public function postStep4(Request $request)
    {

    }

}
