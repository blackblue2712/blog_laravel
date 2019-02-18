<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
class LoaiTinController extends Controller
{
    public function list(){
    	$loaitin = LoaiTin::alL();
    	return view('admin.loaitin.danhsach', ['loaitin' => $loaitin]);
    }

    public function add(){
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.them', ['theloai' => $theloai]);
    }
    public function postAdd(Request $req){
    	
    	$this->validate($req, 
    		[
    			'Ten' => 'required|min:3|max:30|unique:LoaiTin,Ten',
    			'TheLoai' => 'required'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên loại tin',
    			'Ten.min' => 'Tên quá ngắn (từ 3 đến 30 kí tự)',
    			'Ten.max' => 'Tên quá dài (từ 3 đến 30 kí tự)',
    			'Ten.unique' => 'Tên đã tồn tại',
    			'TheLoai.requried' => 'Bạn chưa chọn thể loại cho loại tin'
    		]
    	);

    	$loaitin = new LoaiTin;
    	$loaitin->Ten = $req->Ten;
    	$loaitin->TenKhongDau = changeTitle($req->Ten);
    	$loaitin->idTheLoai   = $req->TheLoai;

    	$loaitin->save();
    	return redirect('admin/loaitin/them')->with('thongbao', 'Đã thêm thành công');
    }


    public function edit($id){
    	$loaitin = LoaiTin::find($id);
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.sua', ['loaitin' => $loaitin, 'theloai' => $theloai]);
    }
    public function postEdit(Request $req, $id){
    	$this->validate($req, 
    		[
    			'Ten' => 'required|min:3|max:30|unique:LoaiTin,Ten',
    			'TheLoai' => 'required'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên loại tin',
    			'Ten.min' => 'Tên quá ngắn (từ 3 đến 30 kí tự)',
    			'Ten.max' => 'Tên quá dài (từ 3 đến 30 kí tự)',
    			'Ten.unique' => 'Tên đã tồn tại',
    			'TheLoai.requried' => 'Bạn chưa chọn thể loại cho loại tin'
    		]
    	);

    	$loaitin = LoaiTin::find($id);
    	$loaitin->Ten = $req->Ten;
    	$loaitin->TenKhongDau = changeTitle($req->Ten);
    	$loaitin->idTheLoai = $req->TheLoai;

    	$loaitin->save();

    	$link = "admin/loaitin/sua/" . $id;
    	return redirect($link)->with('thongbao', 'Đã sửa thành công');
    }

    public function delete($id){
    	$loaitin = LoaiTin::find($id);

    	$loaitin->delete();
    	return redirect('admin/loaitin/danhsach')->with('thongbao', 'Đã xoá thành công');
    }
}
