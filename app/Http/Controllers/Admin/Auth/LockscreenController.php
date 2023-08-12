<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Table\CmsUsers\CmsUsersRepositories;
use App\Traits\Admin\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LockscreenController extends Controller
{
    use Authentication;

    private $table;
    public function __construct(
        CmsUsersRepositories $table
    )
    {
        $this->table = $table;
    }

    /**
     * view Lockscreen form
     */
    public function getIndex(Request $request)
    {
        // your code here
        return view('admin.page.lockscreen.lockscreen');
    }

    /**
     * method lockscreen
     */
    public function postLockscreen(Request $request)
    {
        // users id
        $usersId = self::auth()->id;

        // find users
        $findUsers = $this->table->model->find($usersId);
        if (!Hash::check($request->password, $findUsers->password)) {
            // return to login
            return back()
                ->with([
                    'message' => "Password is not correct."
                ]);
        }

        // put lockscreen
        Session::put('lockscreen', 0);

        return redirect(adminRoute());
    }

    /**
     * method lock to users
     */
    public function getLockUser(Request $request)
    {
        if (empty(self::auth()->id)) {
            // destroy auth
            Session::flush();

            return redirect(adminRoute('lockscreen'))
                ->with([
                    'message' => 'Your session was expired, please login again !'
                ]);
        }

        // put back lockscreen
        Session::put('lockscreen', 1);

        return redirect(adminRoute('lockscreen'));
    }

}
