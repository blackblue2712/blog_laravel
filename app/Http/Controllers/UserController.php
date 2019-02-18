<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    	$slide  = Slide::find($id);
    	return view('admin.slide.sua', ['slide' => $slide]);
    }
    public function postEdit(Request $req, $id){
    	$slide = Slide::find($id);
    	$this->validate($req, 
            [
                'Ten' => 'required',
                'NoiDung' => 'required',
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên',
                'NoiDung.requried' => 'Bạn chưa nhập nội dung',
            ]
        );

    	
        $slide->Ten         = $req->Ten;
        $slide->link        = $req->link;
        $slide->NoiDung     = $req->NoiDung;

        if($req->hasFile('Hinh')){
            $file           = $req->file('Hinh');
            $fileExtension  = $file->getClientOriginalExtension();
            $arr_ex         = ['jpg', 'png', 'gif'];
            if(!in_array($fileExtension, $arr_ex)){
                return redirect('admin/slide/them')->with('loi', 'Phần mở rộng của hình ảnh phải là jpg, png, gif');
            }
            $filename       = $file->getClientOriginalName();
            $randomName     = str_random(5) . '_' . $filename;
            while(file_exists('upload/slide/' . $randomName)){
                $randomName = str_random(5) . '_' . $filename;
            }
            $file->move('upload/slide', $randomName);
            unlink('upload/slide/'.$slide->Hinh);
            $slide->Hinh = $randomName;
        }

        $slide->save();

        return redirect('admin/slide/sua/'.$id)->with('thongbao', 'Đã sửa thành công');
    }

    public function delete($id){
    	$slide = Slide::find($id);
    	@unlink('upload/slide/'.$slide->Hinh);
    	$slide->delete();
    	return redirect('admin/slide/danhsach')->with('thongbao', 'Đã xoá thành công');
    }
}
