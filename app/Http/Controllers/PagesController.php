<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Slide;
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
}
