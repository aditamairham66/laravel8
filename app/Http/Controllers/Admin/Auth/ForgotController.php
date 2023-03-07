<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Table\CmsUsers\CmsUsersRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotController extends Controller
{
    private $table;
    public function __construct(
        CmsUsersRepositories $table
    )
    {
        $this->table = $table;
    }

    /**
     * view forgot form
     */
    public function getIndex()
    {
        return view('admin.page.forgot.forgot');
    }

    /**
     * @params {
     *    username
     * }
     *
     * login method
     */
    public function postForgot()
    {
        try {
            $findUsers = $this->table->findBy('email', request('email'));
            if (!empty($findUsers->id)) {
                // generate random code
                $password = randomCode([], 6);

                // update password
                $findUsers->password = Hash::make($password);
                $findUsers->save();

                // send email
                $sendEmail = new \App\Helpers\EmailSender();
                $sendEmail->template = "admin.email.forgot.forgot_password";
                $sendEmail->data = [
                    "name" => $findUsers->name,
                    "password" => $password,
                ];
                $sendEmail->name_sender = env('MAIL_FROM_NAME');
                $sendEmail->from = env('MAIL_FROM_ADDRESS');
                $sendEmail->to = $findUsers->email;
                $sendEmail->subject = "Forgot Password Admin";
                $sendEmail->sendEmail();

                if ($sendEmail->res == "send") {
                    return back()
                        ->with([
                            'message' => "We have sent a new password to your email, please check your inbox or spam box!"
                        ]);
                } else {
                    return back()
                        ->with([
                            'message' => $sendEmail->res
                        ]);
                }
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

}
