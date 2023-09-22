<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Upload;
use App\Http\Controllers\Controller;
use App\Traits\Admin\Authentication;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use Authentication;
    /**
     * private property
     */
    private $table;
    /**
     * set private property
     */
    protected function set($name, $value)
    {
        $this->$name = $value;
    }
    /**
     * get private property
     */
    protected function get($name)
    {
        return $this->$name;
    }

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
        $save = $this->get('table')->model->find($id);
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
        $save = $this->get('table')->model->find($id);

        // remove the image
        Upload::remove($save->$field);

        // update the image
        $save->$field = null;
        $save->save();

        return redirect()->back()
            ->with([
                'message' => 'Successfully deleted image.',
                'message_type' => 'info'
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
            if (in_array(self::auth()->id, $listId)) {
                return redirect(adminMainRoute(''))
                    ->with([
                        'message' => "You cannot delete your own account.",
                        'message_type' => 'danger'
                    ]);
            }

            $this->get('table')->model->newQuery()
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
