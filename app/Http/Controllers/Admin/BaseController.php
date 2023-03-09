<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Upload;
use Illuminate\Http\Request;

trait BaseController
{
    /**
     * get action table
     */
    public function action($action = [])
    {
        $list = [
            "isAdd" => true,
            "isEdit" => true,
            "isDelete" => true,
            "isDetail" => true,
            "isShow" => true,
            "isBulkButton" => true,
        ];

        return (object) collect($list)
            ->mapWithKeys(function ($row, $i) use ($action) {
                return [
                    $i => array_key_exists($i, $action) ? $action[$i] : $row,
                ];
            })
            ->toArray();
    }

    /**
     * delete cms_users method
     */
    public function getDelete($id)
    {
        $save = $this->table->model->find($id);
        // delete cms_users
        $save->delete();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully delete data.',
                'message_type' => 'success'
            ]);
    }

    /**
     * delete image method
     */
    public function getDeleteImage(Request $request, $id)
    {
        $field = $request->query('field');
        $save = $this->table->model->find($id);

        // remove the image
        Upload::remove($save->$field);

        // update the image
        $save->$field = null;
        $save->save();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully deleted image.',
                'message_type' => 'warning'
            ]);
    }

    /**
     * selected action method
     */
    public function postActionSelected(Request $request)
    {
        $buttonName = $request->button_name;
        $listId = $request->checkbox;

        if (!$listId) {
            return redirect(adminMainRoute(''))
                ->with([
                    'message' => "You must select one of the data in the table first.",
                    'message_type' => 'danger'
                ]);
        }

        if ($buttonName == "delete") {
            $this->table->model->newQuery()
                ->whereIn('id', $listId)
                ->delete();
        }

        return redirect(adminMainRoute(''))
            ->with([
                'message' => "Successfully $buttonName data.",
                'message_type' => 'success'
            ]);
    }

}
