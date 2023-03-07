<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Privileges\AddCmsPrivilegesRequest;
use App\Http\Requests\Admin\Privileges\EditCmsPrivilegesRequest;
use App\Repositories\Table\CmsPrivileges\CmsPrivilegesRepositories;
use Illuminate\Http\Request;

class PrivilegesController extends Controller
{
    use BaseController;

    private $table, $button;
    public function __construct(
        CmsPrivilegesRepositories $table
    )
    {
        $this->table = $table;
        $this->button = $this->action();
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
        return view('admin.page.privileges.index', compact(
            'page_title',
            'result',
            'limit',
            'button'
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
