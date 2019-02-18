<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;

class TinTucController extends Controller
{
    public function list(){
    	$tintuc = TinTuc::orderBy('id', 'desc')->get();
    	return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }

    public function add(){
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them', ['theloai' => $theloai, 'loaitin' => $loaitin]);
    }
    public function postAdd(Request $req){
    	
    	$this->validate($req, 
    		[
    			'LoaiTin' => 'required',
    			'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
    			'TomTat' => 'required',
    			'NoiDung' => 'required'
    		],
    		[
    			'LoaiTin.required' => 'Bạn chưa chọn loại tin',
    			'TieuDe.min' => 'Tên quá ngắn (từ 3 trở lên)',
    			'TieuDe.unique' => 'Tiêu đề không được trùng',
    			'TomTat.required' => 'Bạn chưa nhập tóm tắt',
    			'NoiDung.requried' => 'Bạn chưa nhập nội dung'
    		]
    	);

    	$tintuc = new TinTuc;
    	$tintuc->TieuDe 		= $req->TieuDe;
    	$tintuc->TieuDeKhongDau = changeTitle($req->TieuDe);
    	$tintuc->TomTat   		= $req->TomTat;
    	$tintuc->NoiBat   		= $req->NoiBat;
    	$tintuc->SoLuotXem		= 0;
    	$tintuc->NoiDung  		= $req->NoiDung;
    	$tintuc->idLoaiTin		= $req->LoaiTin;

    	if($req->hasFile('Hinh')){
    		$file 			= $req->file('Hinh');
    		$fileExtension 	= $file->getClientOriginalExtension();
    		$arr_ex 		= ['jpg', 'png', 'gif'];
    		if(!in_array($fileExtension, $arr_ex)){
    			return redirect('admin/tintuc/them')->with('loi', 'Phần mở rộng của hình ảnh phải là jpg, png, gif');
    		}
    		$filename 		= $file->getClientOriginalName();
    		$randomName 	= str_random(5) . '_' . $filename;
    		while(file_exists('upload/tintuc/' . $randomName)){
    			$randomName = str_random(5) . '_' . $filename;
    		}
    		$file->move('upload/tintuc', $randomName);
    		$tintuc->Hinh = $randomName;
    	}else{
    		$tintuc->Hinh = '';
    	}

    	$tintuc->save();

    	return redirect('admin/tintuc/them')->with('thongbao', 'Đã thêm thành công');
    }


    public function edit($id){
    	$loaitin = LoaiTin::all();
    	$theloai = TheLoai::all();
    	$tintuc  = TinTuc::find($id);
    	return view('admin.tintuc.sua', ['loaitin' => $loaitin, 'theloai' => $theloai, 'tintuc' => $tintuc]);
    }
    public function postEdit(Request $req, $id){
    	$tintuc = TinTuc::find($id);
    	$this->validate($req, 
    		[
    			'LoaiTin' => 'required',
    			'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe,'.$id,
    			'TomTat' => 'required',
    			'NoiDung' => 'required'
    		],
    		[
    			'LoaiTin.required' => 'Bạn chưa chọn loại tin',
    			'TieuDe.min' => 'Tên quá ngắn (từ 3 trở lên)',
    			'TieuDe.unique' => 'Tiêu đề không được trùng',
    			'TomTat.required' => 'Bạn chưa nhập tóm tắt',
    			'NoiDung.requried' => 'Bạn chưa nhập nội dung'
    		]
    	);

    	
    	$tintuc->TieuDe 		= $req->TieuDe;
    	$tintuc->TieuDeKhongDau = changeTitle($req->TieuDe);
    	$tintuc->TomTat   		= $req->TomTat;
    	$tintuc->NoiBat   		= $req->NoiBat;
    	$tintuc->NoiDung  		= $req->NoiDung;
    	$tintuc->idLoaiTin		= $req->LoaiTin;

    	if($req->hasFile('Hinh')){
    		$file 			= $req->file('Hinh');
    		$fileExtension 	= $file->getClientOriginalExtension();
    		$arr_ex 		= ['jpg', 'png', 'gif'];
    		if(!in_array($fileExtension, $arr_ex)){
    			return redirect('admin/tintuc/them')->with('loi', 'Phần mở rộng của hình ảnh phải là jpg, png, gif');
    		}
    		$filename 		= $file->getClientOriginalName();
    		$randomName 	= str_random(5) . '_' . $filename;
    		while(file_exists('upload/tintuc/' . $randomName)){
    			$randomName = str_random(5) . '_' . $filename;
    		}
    		$file->move('upload/tintuc', $randomName);
    		unlink("upload/tintuc/".$tintuc->Hinh);
    		$tintuc->Hinh = $randomName;
    	}
    	$tintuc->save();

    	return redirect('admin/tintuc/sua/'.$id)->with('thongbao', 'Đã sửa thành công');
    }

    public function delete($id){
    	$tintuc = TinTuc::find($id);
    	@unlink('upload/tintuc/'.$tintuc->Hinh);
    	$tintuc->delete();
    	return redirect('admin/tintuc/danhsach')->with('thongbao', 'Đã xoá thành công');
    }
}
