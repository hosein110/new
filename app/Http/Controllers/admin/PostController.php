<?php

namespace App\Http\Controllers\admin;

use App\Location;
use App\Post;
use App\PostReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index($type)
    {
        $posts = Post::with('image')
            ->has('reports')
            ->withCount('reports')
            ->orderBy('reports_count', 'DESC')
            ->paginate(12);
        return view('admin.posts.list', compact('posts', 'type'));
    }

    public function confirm($post_id)
    {
        $post = Post::with('images')
            ->with(['prices' => function ($q) {
                return $q->select('post_id', 'field', 'price', 'description', 'image_path');
            }])
            ->select('id', 'location_id', 'caption', 'ptotal')
            ->find($post_id);
        $location = Location::where('id', $post->location_id)->first(['id', 'name']);
        return view('admin.posts.confirm', compact('post', 'location'));
    }

    public function delete($id)
    {
        $res = Post::find($id)->delete();
        if ($res) {
            flash()->success('message', 'DELETE SuccessFULLY');
            return redirect(route('admin_post_list', ['type' => 'confirm']));
        }
        else{
            flash()->error('message', '  ERROR');
            return back();
        }
    }

    public function report_not_correct($id)
    {
        $res = PostReport::where('post_id',$id)->delete();
        if ($res) {
            flash()->success('message', 'DELETE SuccessFULLY');
            return redirect(route('admin_post_list', ['type' => 'confirm']));
        }
        else{
            flash()->error('message', '  ERROR');
            return back();
        }
    }
}
