<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Privileges\AddCmsPrivilegesRequest;
use App\Http\Requests\Admin\Privileges\EditCmsPrivilegesRequest;
use App\Repositories\Table\CmsPrivileges\CmsPrivilegesRepositories;
use App\Traits\Admin\Authentication;
use Illuminate\Http\Request;

class PrivilegesController extends BaseController
{
    use Authentication;

    private $table, $button, $buttonBulk, $buttonAction;
    public function __construct(
        CmsPrivilegesRepositories $table
    )
    {
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
     * view cms_privileges form
     */
    public function getIndex(Request $request)
    {
        $limit = $request->query('limit', 10);
        $search = $request->query('q');

        $page_title = "Privileges Roles";
        $result = $this->table->getPaginated($search, $limit);
        $button = $this->button;
        $buttonBulk = $this->buttonBulk;
        $buttonAction = $this->buttonAction;
        return view('admin.page.privileges.index', compact(
            'page_title',
            'result',
            'limit',
            'button',
            'buttonBulk',
            'buttonAction'
        ));
    }

    /**
     * view cms_privileges form
     */
    public function getAdd()
    {
        $page_title = "Add Privileges";
        $form = $this->table->model;
        $link = adminMainRoute("add");
        return view('admin.page.privileges.form', compact(
            'page_title',
            'form',
            'link'
        ));
    }

    /**
     * add cms_privileges method
     */
    public function postAdd(AddCmsPrivilegesRequest $request)
    {
        $save = $this->table->model;
        $save->name = $request->name;
        $save->save();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully add data.',
                'message_type' => 'success'
            ]);
    }

    /**
     * view cms_privileges form
     */
    public function getEdit($id)
    {
        $page_title = "Edit Privileges";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("edit/$id");
        return view('admin.page.privileges.form', compact(
            'page_title',
            'form',
            'link'
        ));
    }

    /**
     * edit cms_privileges method
     */
    public function postEdit(EditCmsPrivilegesRequest $request, $id)
    {
        $save = $this->table->model->find($id);
        $save->name = $request->name;
        $save->save();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully updated data.',
                'message_type' => 'success'
            ]);
    }

    /**
     * view cms_privileges form
     */
    public function getDetail($id)
    {
        $page_title = "Detail Privileges";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("");
        return view('admin.page.privileges.detail', compact(
            'page_title',
            'form',
            'link'
        ));
    }

}
