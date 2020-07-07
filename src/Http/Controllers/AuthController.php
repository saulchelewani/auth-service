<?php


namespace TNM\AuthService\Http\Controllers;


use App\Http\Controllers\Controller;
use App\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use TNM\AuthService\Http\Requests\AuthenticationRequest;
use TNM\AuthService\Models\Permission;

class AuthController extends Controller
{
    /**
     * @var Client
     */
    private $http;

    public function __construct()
    {
        $this->http = new Client(['verify' => false);
    }

    public function login(AuthenticationRequest $request): JsonResponse
    {
        try {
            $response = $this->http->post(sprintf('%s/authenticate', config('auth_server.url')), [
                "body" => json_encode([
                    "username" => $request->get('username'),
                    "password" => $request->get('password')
                ]),
                "headers" => [
                    "Content-Type" => "application/json",
                    "x-client-secret" => config('auth_server.client_secret')
                ]
            ]);
            $responseData = json_decode($response->getBody()->getContents(), true)['auth'];

        } catch (GuzzleException $exception) {
//            return response()->json(json_decode((string)$exception->getMessage()));
            return response()->json(
                ["message" => json_decode(explode("response:", $exception->getMessage())[1])],
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()]);
//            return response()->json(["message" => "Failed to contact the auth server"], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getUser($responseData);
        $user->permissions()->sync($this->getUserPermissions($responseData));

        return response()->success($this->generateTokens(), 'auth');
    }

    /**
     * @param $responseData
     * @return array
     */
    private function getUserPermissions($responseData): array
    {
        return array_map(function (array $permission) {
            return Permission::updateOrCreate(['origin_id' => $permission['id']],
                [
                    'name' => $permission['name'],
                    'route' => $permission['route']
                ]
            )->{'id'};
        }, $responseData['permissions']);
    }

    /**
     * @param $responseData
     * @return User
     */
    private function getUser($responseData): User
    {
        /** @var User $user */
        return User::updateOrCreate([
            'username' => $responseData['username']],
            [
                'name' => $responseData['name'],
                'role' => $responseData['role'],
                'password' => Hash::make(request('password'))
            ]
        );
    }

    /**
     * @return array
     */
    private function generateTokens(): array
    {
        /** @var User $user */
        $user = User::where(['username' => request('username')])->first();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if (request('remember_me')) $token->{'expires_at'} = Carbon::now()->addWeek();
        $token->save();

        return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->{'expires_at'})->toDateTimeString(),
            'user' => $user->{'name'},
            'role' => $user->{'role'},
            'permissions' => $user->permissions()->get()->map(function (Permission $permission) {
                return $permission->{'route'};
            })
        ];
    }
}
