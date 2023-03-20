<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    //
    use ResponseApi;
    protected $service_user;
    public function __construct(UserService $service_user)
    {
        $this->service_user = $service_user;
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $data = $this->service_user->PostUserService($request,$id);
        return $this->responseSucess($data);
    }

    public function index(Request $request)
    {
        $data = $this->service_user->GetAllUserService($request);
        return $this->responseSucess($data);
    }

    public function remove(Request $request)
    {
        $data = $this->service_user->DeleteUserService($request);
        return $this->responseSucess($data);
    }

    public function detail(Request $request)
    {
        $data = $this->service_user->GetUserByIdService($request);
        $final = $data != null ? $this->responseSucess($data) : $this->responseError($data);
        return $final;
    }

    public function loginUser(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;
        $search_data = User::query()->where('email',$email)->first();
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        if ($search_data != null) {
            if (password_verify($pass, $search_data->password)) {
                
               //jwt
               $myTTL = 60*24*5; //minutes expired jwt
               JWTAuth::factory()->setTTL($myTTL);
               try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Login credentials are invalid.',
                        ], 400);
                    }
                } catch (JWTException $e) {
                return $credentials;
                    return response()->json([
                            'success' => false,
                            'message' => 'Could not create token.',
                        ], 500);
                }
               //jwt
                
                return response()->json([
                    'message' => 'success login',
                    'email'=>$search_data->email,
                    'jwt_token'=>$token,
                    'token_type' => 'Bearer',
                    'id_user'=> $search_data->id,
                ],200);    
            }else{
                return response()->json([
                    'message' => 'failed login'
                ],401);   
            }
        }else{
            return response()->json([
                'message' => 'failed login email not found'
            ],401);   
        }
    }

    public function logoutUser()
    {

    }
}
