<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditPostRequest;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Post::query();
            $perPage = 1;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if ($search) {
                $query->whereRaw('title', 'LIKE', '%' . $search . '%');
            }

            $total = $query->count();
            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Les posts ont été récupérés',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(CreatePostRequest $request)
    {
        try {
            $post = new Post();
            $post->title = $request->titre;
            $post->description = $request->description;
            $post->user_id=auth()->user()->id;

            if($post->user_id==auth()->user()->id){

                $post->save();
            }else{

                return response()->json([
                    'status_code' => 200,
                    'status_message' => "Vous n'ete pas l'auteur de ce post",
                    'data' => $post
                ]);

            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été ajouté',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(EditPostRequest $request, Post $post)
    {
        try {
            $post->title = $request->titre;
            $post->description = $request->description;
            $post->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été modifié',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Post $post)
    {
        try {

            if($post->user_id==auth()->user()->id){

                $post->save();
            }else{

                return response()->json([
                    'status_code' => 422,
                    'status_message' => "Vous n'ete pas l'auteur de ce post.Suppression non autorise"
                ]);

            }

            $post->delete();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été supprimé',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
