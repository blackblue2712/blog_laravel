<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;

class SlideController extends Controller
{
    public function list(){
    	$slide = Slide::all();
    	return view('admin.slide.danhsach', ['slide' => $slide]);
    }

    public function add(){
    	return view('admin.slide.them');
    }
    public function postAdd(Request $req){
    	
    	$this->validate($req, 
    		[
    			'Ten' => 'required',
    			'NoiDung' => 'required',
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên',
    			'NoiDung.requried' => 'Bạn chưa nhập nội dung'
    		]
    	);

    	$slide = new Slide;
    	$slide->Ten 		    = $req->Ten;
    	$slide->link   		= $req->link;
    	$slide->NoiDung  		= $req->NoiDung;

    	if($req->hasFile('Hinh')){
    		$file 			= $req->file('Hinh');
    		$fileExtension 	= $file->getClientOriginalExtension();
    		$arr_ex 		= ['jpg', 'png', 'gif'];
    		if(!in_array($fileExtension, $arr_ex)){
    			return redirect('admin/slide/them')->with('loi', 'Phần mở rộng của hình ảnh phải là jpg, png, gif');
    		}
    		$filename 		= $file->getClientOriginalName();
    		$randomName 	= str_random(5) . '_' . $filename;
    		while(file_exists('upload/slide/' . $randomName)){
    			$randomName = str_random(5) . '_' . $filename;
    		}
    		$file->move('upload/slide', $randomName);
    		$slide->Hinh = $randomName;
    	}else{
    		$slide->Hinh = '';
    	}

    	$slide->save();

    	return redirect('admin/slide/them')->with('thongbao', 'Đã thêm thành công');
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
