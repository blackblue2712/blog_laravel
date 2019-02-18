<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
class TheLoaiController extends Controller
{
    public function list(){
    	$theloai = TheLoai::alL();
    	return view('admin.theloai.danhsach', ['theloai' => $theloai]);
    }

    public function add(){

    	return view('admin.theloai.them');
    }
    public function postAdd(Request $req){
    	
    	$this->validate($req, 
    		[
    			'Ten' => 'required|min:3|max:30|unique:TheLoai,Ten'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên thể loại',
    			'Ten.min' => 'Tên quá ngắn (từ 3 đến 30 kí tự)',
    			'Ten.max' => 'Tên quá dài (từ 3 đến 30 kí tự)',
    			'Ten.unique' => 'Tên đã tồn tại'
    		]
    	);

    	$theloai = new TheLoai;
    	$theloai->Ten = $req->Ten;
    	$theloai->TenKhongDau = changeTitle($req->Ten);

    	$theloai->save();
    	return redirect('admin/theloai/them')->with('thongbao', 'Đã thêm thành công');
    }


    public function edit($id){
    	$theloai = TheLoai::find($id);
    	return view('admin.theloai.sua', ['theloai' => $theloai]);
    }
    public function postEdit(Request $req, $id){
    	$this->validate($req, 
    		[
    			'Ten' => 'required|min:3|max:30|unique:TheLoai,Ten'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên thể loại',
    			'Ten.min' => 'Tên quá ngắn (từ 3 đến 30 kí tự)',
    			'Ten.max' => 'Tên quá dài (từ 3 đến 30 kí tự)',
    			'Ten.unique' => 'Tên đã tồn tại'
    		]
    	);

    	$theloai = TheLoai::find($id);
    	$theloai->Ten = $req->Ten;
    	$theloai->TenKhongDau = changeTitle($req->Ten);

    	$theloai->save();

    	$link = "admin/theloai/sua/" . $id;
    	return redirect($link)->with('thongbao', 'Đã sửa thành công');
    }

    public function delete($id){
    	$theloai = TheLoai::find($id);

    	$theloai->delete();
    	return redirect('admin/theloai/danhsach')->with('thongbao', 'Đã xoá thành công');
    }
}
