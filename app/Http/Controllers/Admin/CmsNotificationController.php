<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Table\CmsNotification\CmsNotificationRepositories;
use App\Traits\Admin\Authentication;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CmsNotificationController extends Controller
{
    use BaseController, Authentication;

    private $table, $button;
    public function __construct(
        CmsNotificationRepositories $table
    )
    {
        $this->table = $table;
        $this->button = $this->action([
            "isAdd" => false,
            "isEdit" => false,
            "isShow" => false,
        ]);
    }

    /**
     * view cms_notification form
     */
    public function getIndex(Request $request)
    {
        // users id
        $usersId = $this->auth()->id;

        $limit = $request->query('limit', 10);
        $search = $request->query('q');

        $page_title = "Notification";
        $result = $this->table->getNotificationByUsersPaginated($usersId, $search, $limit);
        $button = $this->button;
        return view('admin.page.notification.index', compact(
            'page_title',
            'result',
            'limit',
            'button'
        ));
    }

    /**
     * view cms_notification form
     */
    public function getAdd()
    {
        $page_title = "Add Notification";
        $form = $this->table->model;
        $link = adminMainRoute("add");
        return view('admin.page.notification.form', compact(
            'page_title',
            'form',
            'link'
        ));
    }

//    /**
//     * add cms_notification method
//     */
//    public function postAdd()
//    {
//        $save = $this->table->model;
//
//        return redirect(adminMainRoute(''))
//            ->with([
//                'message' => 'Successfully add data.',
//                'message_type' => 'success'
//            ]);
//    }

    /**
     * view cms_notification form
     */
    public function getEdit($id)
    {
        $page_title = "Edit Notification";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("edit/$id");
        return view('admin.page.notification.form', compact(
            'page_title',
            'form',
            'link'
        ));
    }

//    /**
//     * edit cms_notification method
//     */
//    public function postEdit($id)
//    {
//        $save = $this->table->model->find($id);
//
//        return redirect(adminMainRoute(''))
//            ->with([
//                'message' => 'Successfully updated data.',
//                'message_type' => 'success'
//            ]);
//    }

    /**
     * view cms_notification form
     */
    public function getDetail($id)
    {
        $page_title = "Detail Notification";
        $form = $this->table->model->find($id);
        $link = adminMainRoute("");
        return view('admin.page.notification.detail', compact(
            'page_title',
            'form',
            'link'
        ));
    }

    /**
     * read cms_notification method
     */
    public function getRead($id)
    {
        $save = $this->table->model->find($id);
        $save->is_read = 1;
        $save->save();

        return redirect(adminMainRoute(''))
            ->with([
                'message' => 'Successfully read notification.',
                'message_type' => 'success'
            ]);
    }

    /**
     * list notifcation cms_notification method
     */
    public function getLatestJson()
    {
        // users id
        $usersId = $this->auth()->id;

        $data = $this->table->model->newQuery()
            ->where('cms_users_id', $usersId)
            ->where('is_read', 0)
            ->orderby('id', 'desc')
            ->take(25)
            ->get();

        $rows = collect($data)->map(function ($row) {
            $row->time_ago = Carbon::parse(date('Y-m-d H:i:s', strtotime($row->created_at)))
                ->diffForHumans(['parts' => 1]);
            return $row;
        });
        return response()->json([
            'items' => $rows,
            'total' => count($data)
        ]);
    }

}
