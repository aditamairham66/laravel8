<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersModule\AddUsersModuleRequest;
use App\Http\Requests\Admin\UsersModule\EditUsersModuleRequest;
use App\Repositories\Table\CmsUsers\CmsUsersRepositories;
use App\Traits\Admin\Authentication;
use Illuminate\Http\Request;
use App\Helpers\Upload;
use Illuminate\Support\Facades\Hash;

class UsersModuleController extends BaseController
{
    use Authentication;

    private $table;
    private $button;
    private $buttonBulk;
    private $buttonAction;
    public function __construct(
        CmsUsersRepositories $table
    ) {
        // set value to private property
        $this->set('table', $table);
        
        $this->table = $table;
        $this->button = $this->action();
        $this->buttonBulk = [
            // ["type" => "type", "name" => "Name Text"],
        ];
        $this->buttonAction = [
            // [
            //     "type" => "primary",
            //     "label" => "Test",
            //     "icon" => "fa fa-pen",
            //      "link" => adminRoute('/'),
            // ],
        ];
    }

    /**
     * view cms_users form
     */
    public function getIndex(Request $request)
    {
        $limit = $request->query('limit', 10);
        $search = $request->query('q');

        $page_title = "UsersModule";
        $result = $this->table->getPaginated($search, $limit);
        $button = $this->button;
        $buttonBulk = $this->buttonBulk;
        $buttonAction = $this->buttonAction;
        return view('admin.page.cms_users.index', compact(
            'page_title',
            'result',
            'limit',
            'button',
            'buttonBulk',
            'buttonAction'
        ));
    }

    /**
     * view cms_users form
     */
    public function getAdd()
    {
        $page_title = "Add UsersModule";
        $form = $this->table->model;
        $link = adminMainRoute("add");
        return view('admin.page.cms_users.form', compact(
            'page_title',
            'form',
            'link'
        ));
    }

    /**
     * add cms_users method
     */
    public function postAdd(AddUsersModuleRequest $request)
    {
        $save = $this->table->model;
        $save->cms_privileges_id;
        $save->name;
        $photo = Upload::move('photo', 'profile', 'Yes');
        if ($photo) {
            $save->photo = $photo;
        }
        $save->email;
        if ($save->password) {
            $save->password = Hash::make($request->password);
        }

        // add params here
        $save->save();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully add data.',
                'message_type' => 'success'
            ]);
    }

    /**
     * view cms_users form
     */
    public function getEdit($id)
    {
        $page_title = "Edit UsersModule";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("edit/$id");
        return view('admin.page.cms_users.form', compact(
            'page_title',
            'form',
            'link'
        ));
    }

    /**
     * edit cms_users method
     */
    public function postEdit(EditUsersModuleRequest $request, $id)
    {
        $save = $this->table->model->find($id);
        $save->cms_privileges_id;
        $save->name;
        $photo = Upload::move('photo', 'profile', 'Yes');
        if ($photo) {
            $save->photo = $photo;
        }
        $save->email;
        if ($save->password) {
            $save->password = Hash::make($request->password);
        }

        // add params here
        $save->save();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully updated data.',
                'message_type' => 'success'
            ]);
    }

    /**
     * view cms_users form
     */
    public function getDetail($id)
    {
        $page_title = "Detail UsersModule";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("");
        return view('admin.page.cms_users.detail', compact(
            'page_title',
            'form',
            'link'
        ));
    }

}
