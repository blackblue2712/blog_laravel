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

    public function edit(){
    	return view('admin.theloai.sua');
    }

    public function add(){
    	return view('admin.theloai.them');
    }
}
