<?php


namespace TNM\AuthService\Http\Controllers;


use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * @var Client
     */
    private $http;

    public function __construct()
    {
        $this->http = new Client();
    }
    public function authenticate(Request $request)
    {
        try {
            $this->http->request("POST", config('auth_server.url'), [
                "body" => json_encode([
                    "username" => $request->get('username'),
                    "password" => $request->get('password')
                ]),
                "headers" => [
                    "Content-Type" => "application/json",
                    "x-client-secret" => config('auth_server.client_secret')
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json(["message" => "Failed to contact the auth server"], Response::HTTP_BAD_REQUEST);
        }
    }
}
