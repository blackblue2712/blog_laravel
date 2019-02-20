<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function(){
	$theloai = TheLoai::find(1);
	
	foreach ($theloai->loaitin as $key => $value) {
		echo $value->Ten.'<br/>';
	}
});

Route::get('testGUI', function(){
	return view('admin.theloai.danhsach');
});

Route::get('admin/dangnhap', 'UserController@getDangnhapAdmin');
Route::post('admin/dangnhap', 'UserController@postDangnhapAdmin');
Route::get('admin/dangxuatAdmin', 'UserController@getDangxuatAdmin');

Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function(){
	Route::group(['prefix' => 'theloai'], function(){

		Route::get('danhsach', 'TheLoaiController@list');

		Route::get('sua/{id}', 'TheLoaiController@edit');
		Route::post('sua/{id}', 'TheLoaiController@postEdit');

		Route::get('them', 'TheLoaiController@add');
		Route::post('them', 'TheLoaiController@postAdd');

		Route::get('xoa/{id}', 'TheLoaiController@delete');

	});

	Route::group(['prefix' => 'loaitin'], function(){

		Route::get('danhsach', 'LoaiTinController@list');

		Route::get('sua/{id}', 'LoaiTinController@edit');
		Route::post('sua/{id}', 'LoaiTinController@postEdit');

		Route::get('them', 'LoaiTinController@add');
		Route::post('them', 'LoaiTinController@postAdd');

		Route::get('xoa/{id}', 'LoaiTinController@delete');

	});

	Route::group(['prefix' => 'tintuc'], function(){

		Route::get('danhsach', 'TinTucController@list');

		Route::get('sua/{id}', 'TinTucController@edit');
		Route::post('sua/{id}', 'TinTucController@postEdit');

		Route::get('them', 'TinTucController@add');
		Route::post('them', 'TinTucController@postAdd');

		Route::get('xoa/{id}', 'TinTucController@delete');

	});

	Route::group(['prefix' => 'comment'], function(){

		Route::get('xoa/{idTinTuc}/{id}', 'CommentController@delete');

	});

	Route::group(['prefix' => 'slide'], function(){

		Route::get('danhsach', 'SlideController@list');

		Route::get('sua/{id}', 'SlideController@edit');
		Route::post('sua/{id}', 'SlideController@postEdit');

		Route::get('them', 'SlideController@add');
		Route::post('them', 'SlideController@postAdd');

		Route::get('xoa/{id}', 'SlideController@delete');

	});

	Route::group(['prefix' => 'user'], function(){

		Route::get('danhsach', 'UserController@list');

		Route::get('sua/{id}', 'UserController@edit');
		Route::post('sua/{id}', 'UserController@postEdit');

		Route::get('them', 'UserController@add');
		Route::post('them', 'UserController@postAdd');

		Route::get('xoa/{id}', 'UserController@delete');

	});

	Route::group(['prefix' => 'ajax'], function(){
		Route::get('loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
	});
});


//

Route::get('trangchu', 'PagesController@trangchu');
Route::get('loaitin/{id}/{TenKhongDau}.html', 'PagesController@loaitin');
Route::get('tintuc/{id}/{TenKhongDau}.html', 'PagesController@tintuc');

Route::get('dangnhap', 'PagesController@getDangnhap');
Route::post('dangnhap', 'PagesController@postDangnhap');
Route::get('dangxuat', 'PagesController@getDangxuat');









