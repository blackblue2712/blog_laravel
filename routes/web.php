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

Route::group(['prefix' => 'admin'], function(){
	Route::group(['prefix' => 'theloai'], function(){

		Route::get('danhsach', 'TheLoaiController@list');

		Route::get('sua', 'TheLoaiController@edit');

		Route::get('them', 'TheLoaiController@add');

	});

	Route::group(['prefix' => 'loaitin'], function(){

		Route::get('danhsach', 'CateController@list');

		Route::get('sua', 'cateController@edit');

		Route::get('them', 'cateController@add');

	});

	Route::group(['prefix' => 'tintuc'], function(){

		Route::get('danhsach', 'CateController@list');

		Route::get('sua', 'cateController@edit');

		Route::get('them', 'cateController@add');

	});
});