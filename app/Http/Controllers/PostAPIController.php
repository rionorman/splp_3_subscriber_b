<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostAPIController extends Controller
{
	public function storeAPI(Request $request)
	{

		$post = new Post;
		// $post->id = $request->id;
		$post->user_id = $request->user_id;
		$post->cat_id = $request->cat_id;
		$post->title = $request->title;
		$post->content = $request->content;
		$post->image = $request->image_name;
		// $post->created_at = $request->created_at;
		// $post->updated_at = $request->updated_at;
		$post->save();
		return response()->json([
			'success' => 1,
			'data' => $post
		]);
	}

	public function searchPostAPI($search)
	{
		$posts = Post::select('id', 'title', 'content', 'image', 'updated_at')
			->where('content', 'like', '%' . $search . '%')->get();
		foreach ($posts as $post) {
			$post->content = substr($post->content, 0, 150);
			$post->url =  asset('detail') . '/' . $post->id;
			$post->sumber = 'Dinas Jawa Barat';
		}
		return response()->json([
			'success' => 1,
			'data' => $posts
		]);
	}
}
