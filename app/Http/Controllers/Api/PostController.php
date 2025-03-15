<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Rules\PostLimitThree;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    function index (Request $request) {

        return PostResource::collection(Post::with("user")->paginate(15));
    }
    function show (string $id) {
        return new PostResource(Post::findOrFail($id));
    }


    function store(Request $request){
        //dd($request);
        $validated = $request->validate([
            "title"=> ["required","min:3","unique:App\Models\Post,title"],
            "description"=> ["required","min:10"],
            "user_id"=> ["required","exists:App\Models\User,id"],
            'photo_url' => 'required|url',
        ]);

        $post = new Post([
            "title"=> $request["title"],
            "description"=> $request["description"],
            "user_id"=> $request["user_id"],
        ]);
        $post->save();
        // $file = $request->file("photo");
        // Storage::put("photos/".$post->id.".".$file->getClientOriginalExtension(), file_get_contents($file));
        $imageUrl = $request->photo_url;

        // Download the image
        try {
            $response = Http::withoutVerifying()->get($imageUrl);
            if ($response->failed()) {
                return response()->json(['error' => 'Could not download image'], 400);
            }

            // Get file extension from the URL
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'jfif'])) {
                return response()->json(['error' => 'Invalid image format'], 400);
            }

            // Generate unique filename
            $filename = $post->id . '.' . $extension;

            // Store the image in `storage/app/public/photos`
            Storage::disk('local')->put("photos/$filename", $response->body());

        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Error downloading the image'], 500);
        }

        return back()->with("success","");
    }
}
