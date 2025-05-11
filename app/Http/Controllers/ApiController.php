<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\clients\Login;
use App\Models\clients\User;

class ApiController extends Controller
{
    
    private $login;
    protected $user;

    public function __construct()
    {
        $this->login = new Login();
        $this->user = new User();
    }
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $data_login = [
            'username' => $username,
            'password' => md5($password)
        ];

        $user_login = $this->login->login($data_login);
        $userId = $this->user->getUserId($username);
        $user = $this->user->getUser($userId);
        

        if ($user_login != null) {
            if($user->status=='b'){
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã bị chặn',
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'redirectUrl' => route('home'),  // Optional: dynamic home route
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin tài khoản không chính xác!'.$user_login,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
