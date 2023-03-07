<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api\Response;
use App\Http\Controllers\Controller;
use App\Traits\Api\Authentication;
use App\Traits\Api\Token;
use Illuminate\Http\Request;

class GenerateTokenController extends Controller
{
    use Authentication, Token;

    private $res, $token;
    public function __construct(
        Response $res
    )
    {
        $this->res = $res;
        $this->token = [
            "username" => "username",
            "password" => "password",
        ];
    }

    /**
     * view GenerateToken form
     */
    public function getGenerate(Request $request)
    {
        // your code here
        $auth = $request->header('Authorization');
        if (!$auth) {
            $this->res->error("Authorization not valid");
        }
        // token Authorization
        $token = $this->getToken($auth);

        // decrypt token
        $decryptToken = base64_decode($token);
        if ($decryptToken !== $this->token['username'].":".$this->token['password']) {
            $this->res->error("Authorization is invalid", 401);
        }

        // create token
        $token = $this->create([]);

        $this->res->data([
            "token" => $token
        ]);
    }

    public function getUpdate(Request $request)
    {
        $auth = $request->header('Authorization');
        if (!$auth) {
            $this->res->error("Authorization not valid");
        }
        // token Authorization
        $token = $this->getToken($auth);

        // update token
        $newToken = $this->update($token);
        $this->res->data([
            "token" => $newToken
        ]);
    }

}
