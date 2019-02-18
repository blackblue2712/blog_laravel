<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
 
    public function delete($idTinTuc, $id){
    	$comment = Comment::find($id);
    	$comment->delete();
    	return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao', 'Đã xoá thành công');
    }
}
