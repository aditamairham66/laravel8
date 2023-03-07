<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Table\CmsUsers\CmsUsersRepositories;
use App\Traits\Admin\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
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
     * view login form
     */
    public function getIndex()
    {
        return view('admin.page.login.login');
    }

    /**
     * @params {
     *    username
     *    password
     * }
     *
     * login method
     */
    public function postLogin()
    {
        try {
            $findUsers = $this->table->findBy('email', request('username'));
            if (!empty($findUsers->id)) {
                if (!Hash::check(request('password'), $findUsers->password)) {
                    // return to login
                    return back()
                        ->with([
                            'message' => "Password is not correct."
                        ]);
                }

                // create session users
                $users['id'] = $findUsers->id;
                $users['name'] = $findUsers->name;
                $users['email'] = $findUsers->email;
                $users['photo'] = $findUsers->photo;
                $users['privileges_id'] = $findUsers->privileges->id;
                $users['privileges_name'] = $findUsers->privileges->name;
                self::create($users);

                return redirect('admin');
            }

            // return to login
            return back()
                ->with([
                    'message' => "Username is not found."
                ]);
        } catch (\Throwable $th) {
            return back()
                ->with([
                    'message' => $th->getMessage(),
                ]);
        }
    }

    /**
     * logout method
     */
    public function getLogout()
    {
        // delete session login
        self::destroy();
        // redirect back to login
        return redirect()
            ->action('Admin\Auth\LoginController@getIndex')
            ->with([
                'message' => "Please you have to log in first! to continue.",
            ]);
    }
}
