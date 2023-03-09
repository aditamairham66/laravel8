<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Upload;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Profile\AddCmsUsersRequest;
use App\Http\Requests\Admin\Profile\EditCmsUsersRequest;
use App\Repositories\Table\CmsPrivileges\CmsPrivilegesRepositories;
use App\Repositories\Table\CmsUsers\CmsUsersRepositories;
use App\Traits\Admin\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{
    use Authentication;

    public $table, $button, $buttonBulk, $buttonAction, $cmsPrivilegesRepositories;
    public function __construct(
        CmsUsersRepositories $table,
        CmsPrivilegesRepositories $cmsPrivilegesRepositories
    )
    {
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
        $this->cmsPrivilegesRepositories = $cmsPrivilegesRepositories;
    }

    /**
     * view cms_users form
     */
    public function getIndex(Request $request)
    {
        $limit = $request->query('limit', 10);
        $search = $request->query('q');

        $page_title = "Users Management";
        $result = $this->table->getPaginated($search, $limit);
        $button = $this->button;
        $buttonBulk = $this->buttonBulk;
        $buttonAction = $this->buttonAction;
        return view('admin.page.profile.index', compact(
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
        $page_title = "Add Profile";
        $form = $this->table->model;
        $link = adminMainRoute("add");
        $privileges = $this->cmsPrivilegesRepositories->getAll();
        return view('admin.page.profile.form', compact(
            'page_title',
            'form',
            'link',
            'privileges'
        ));
    }

    /**
     * add cms_users method
     */
    public function postAdd(AddCmsUsersRequest $request)
    {
        // upload file
        $photo = Upload::move('photo', 'profile', 'Yes');

        $save = $this->table->model;
        $save->name = $request->name;
        $save->email = $request->email;
        if ($request->privilege) {
            $save->cms_privileges_id = $request->privilege;
        }
        if ($request->password) {
            $save->password = Hash::make($request->password);
        }
        if ($photo) {
            $save->photo = $photo;
        }
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
        $page_title = "Edit Profile";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("edit/$id");
        $privileges = $this->cmsPrivilegesRepositories->getAll();
        return view('admin.page.profile.form', compact(
            'page_title',
            'form',
            'link',
            'privileges'
        ));
    }

    /**
     * edit cms_users method
     */
    public function postEdit(EditCmsUsersRequest $request, $id)
    {
        // users login
        $usersId = $this->auth()->id;

        // upload file
        $photo = Upload::move('photo', 'profile', 'Yes');

        $save = $this->table->model->find($id);
        $save->name = $request->name;
        $save->email = $request->email;
        if ($request->privilege) {
            $save->cms_privileges_id = $request->privilege;
        }
        if ($request->password) {
            $save->password = Hash::make($request->password);
        }
        if ($photo) {
            $save->photo = $photo;
        }
        $save->save();

        if ($usersId == $save->id) {
            // update session users
            $users['id'] = $save->id;
            $users['name'] = $save->name;
            $users['email'] = $save->email;
            $users['photo'] = $save->photo;
            $users['privileges_id'] = $save->privileges->id;
            $users['privileges_name'] = $save->privileges->name;
            self::create($users);
        }

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
        $page_title = "Detail Profile";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("");
        return view('admin.page.profile.detail', compact(
            'page_title',
            'form',
            'link'
        ));
    }

}
