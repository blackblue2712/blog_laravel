<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Slide;
use App\User;
use App\Comment;
class PagesController extends Controller
{
	public function __construct(){
		$theloai = TheLoai::all();
		$slide 	 = Slide::alL();
		view()->share('theloai', $theloai);
		view()->share('slide', $slide);
	}
 	public function trangchu(){
 		return view('pages.index');
 	}

 	public function loaitin($id, $tenKhongDau){
 		$loaitin = LoaiTin::find($id);
 		$tintuc  = TinTuc::where('idLoaiTin', $id)->paginate(5);
 		return view('pages.loaitin', ['loaitin' => $loaitin, 'tintuc' => $tintuc]);
 	}

 	public function tintuc($id, $tenKhongDau){
 		$tintuc 	= TinTuc::find($id);
 		$tinNB  	= TinTuc::where('NoiBat', 1)->take(4)->get();
 		$tinlienquan= TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)->take(4)->get();
 		return view('pages.tintuc', ['tintuc' => $tintuc, 'tinnoibat' => $tinNB, 'tinlienquan' => $tinlienquan]);
 	}

 	public function getDangnhap(){
 		return view('pages.dangnhap');
 	}

 	public function postDangnhap(Request $req){
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
            return redirect('trangchu');
        }else{
            return redirect('dangnhap')->with('thongbao', 'Email hoặc password không hợp lệ');
        }
 	}

 	public function getDangxuat(){
 		Auth::logout();
 		return view('pages.dangnhap');
 	}

 	public function getNguoiDung(){
 		return view('pages.nguoidung');
 	}

 	public function postNguoiDung(Request $req){
 		$user = User::find(Auth::user()->id);
    	$this->validate($req, 
            [
                'name' => 'required|min:3|unique:users,name,'.Auth::user()->id,
            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'name.unique' => 'Tên đã tồn tại',
                'name.min' => 'Tên quá ngắn (từ 3 kí tự trở lên)',
            ]
        );
    	
        $user->name     = $req->name;

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

        return redirect('nguoidung')->with('thongbao', 'Đã sửa thành công');
 	}

 	public function getDangKi(){
 		return view('pages.dangki');
 	}	

 	public function postDangKi(Request $req){
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
    	$user->quyen  	= 0;
        $user->password = bcrypt($req->password);

    	$user->save();

    	return redirect('dangnhap')->with('thongbao', 'Đã đăng kí thành công');
 	}
 	public function postBinhLuan(Request $req, $idTinTuc, $tieuDeKhongDau){
 		$comment = new Comment;

 		$comment->NoiDung = $req->comment;
 		$comment->idUser  = Auth::user()->id;
 		$comment->idTinTuc= $idTinTuc;

 		$comment->save();
 		return redirect('tintuc/'.$idTinTuc.'/'.$tieuDeKhongDau.'.html');
 	}

 	public function timkiem(Request $req){
 		$tukhoa = $req->tukhoa;
 		$tintuc = TinTuc::where('TieuDe', 'like', "%$tukhoa%")->orWhere('NoiDung', 'like', "%$tukhoa%")->orWhere('TomTat', 'like', "%$tukhoa%")->take(30)->paginate(5);
 		return view('pages.timkiem', ['tukhoa' => $tukhoa, 'tintuc' => $tintuc]);
 	}
}
