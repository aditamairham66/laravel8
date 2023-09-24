<?php

namespace App\Http\Controllers\Admin;

use App\Console\Commands\CreateControllerCommand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ModuleGeneratorController extends Controller
{
    function getStep1(Request $request) 
    {
        $table = collect(Schema::getAllTables())
            ->filter(function ($row) {
               return !in_array($row->Tables_in_laravel, ['migrations', 'cms_notification', 'cms_privileges']); 
            })->map(function ($row) {
                return $row->Tables_in_laravel;
            });
        return view('admin.module.step1', compact(
            'table'
        ));
    }

    function getStep2(Request $request) 
    {
        return view('admin.module.step1');
    }

    function postStep2(Request $request)
    {
        $table = $request->table;
        $name = Str::studly($request->name);

        // create model
        $ta = Artisan::call(CreateControllerCommand::class, [
            'name' => "Admin\\$name",
            'type' => "admin",
            'table' => $table,
        ]);
        dd("Admin\\$name", $request->all(), $ta);

        return redirect()->route('admin.step2');
    }

    function getStep3(Request $request) 
    {
        return view('admin.module.step1');
    }

}
