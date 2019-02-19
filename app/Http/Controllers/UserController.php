<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function list(){
    	$user = User::all();
    	return view('admin.user.danhsach', ['user' => $user]);
    }

    public function add(){
    	return view('admin.user.them');
    }
    public function postAdd(Request $req){
    	
    	$this->validate($req, 
    		[
    			'name' => 'required|min:3|unique:users,name',
    			'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
    		],
    		[
    			'name.required' => 'Bạn chưa nhập tên',
                'name.unique' => 'Tên đã tồn tại',
                'name.min' => 'Tên quá ngắn (từ 3 kí tự trở lên)',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại',   
    			'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu quá ngắn (từ 3 đến 32 kí tự)',
                'password.max' => 'Mật khẩu quá dài (từ 3 đến 32 kí tự)',
                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same'    => 'Mật khẩu nhập lại không khớp'
    		]
    	);

    	$user = new User;
    	$user->name 	= $req->name;
    	$user->email   	= $req->email;
    	$user->quyen  	= $req->quyen;
        $user->password = bcrypt($req->password);

    	$user->save();

    	return redirect('admin/user/them')->with('thongbao', 'Đã thêm thành công');
    }


    public function edit($id){
    	$user  = User::find($id);
    	return view('admin.user.sua', ['user' => $user]);
    }
    public function postEdit(Request $req, $id){
    	$user = User::find($id);
    	$this->validate($req, 
            [
                'name' => 'required|min:3|unique:users,name,'.$id,
            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'name.unique' => 'Tên đã tồn tại',
                'name.min' => 'Tên quá ngắn (từ 3 kí tự trở lên)',
            ]
        );
    	
        $user->name     = $req->name;
        $user->quyen    = $req->quyen;

        if($req->changePassword == 'on'){
            $this->validate($req, 
                [
                    'password' => 'required|min:3|max:32',
                    'passwordAgain' => 'required|same:password'
                ],
                [
                    'password.required' => 'Bạn chưa nhập mật khẩu',
                    'password.min' => 'Mật khẩu quá ngắn (từ 3 đến 32 kí tự)',
                    'password.max' => 'Mật khẩu quá dài (từ 3 đến 32 kí tự)',
                    'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                    'passwordAgain.same'    => 'Mật khẩu nhập lại không khớp'
                ]
            );
            $user->password = bcrypt($req->password);
        }
        

        $user->save();

        return redirect('admin/user/sua/'.$id)->with('thongbao', 'Đã sửa thành công');
    }

    public function delete($id){
    	$user = User::find($id);
    	$user->delete();
    	return redirect('admin/user/danhsach')->with('thongbao', 'Đã xoá thành công');
    }

    // LOGIN
    public function getDangnhapAdmin(){
        return view('admin.login');
    }
    public function postDangnhapAdmin(Request $req){        
        $this->validate($req,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập mật khẩu'
            ]
        );

        if(Auth::attempt(['email' => $req->email, 'password' =>$req->password])){
            return redirect('admin/theloai/danhsach');
        }else{
            return redirect('admin/dangnhap')->with('thongbao', 'Email hoặc password không hợp lệ');
        }
    }  
    public function getDangxuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    } 
}
