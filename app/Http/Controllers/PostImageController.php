<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Repositories\PostImageRepositoryInterface;
use App\Services\PostImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{

    public function __construct(
        protected PostImageService $postImageService
    ){

    }
    public function destroy(Request $request)
    {
        // $img = PostImage::findorFail($request->id);
        // $img->delete();
        // return response()->json([
        //     'message' => "deleted Successfully"
        // ], 200);

        $this->postImageService->delete($request->id);
    }

    // public function upload (Request $request) {
    //     $post = Post::findOrFail($request->post_id);
    //     foreach($request->files->get('images') as $img)
    //         {
    //             $img_name = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . '.'. $img->getClientOriginalExtension();
    //             $path = Storage::disk('public')->putFileAs('images',$img, $img_name );

    //             $post->post_images()->create([
    //                 'post_id' => $post->id,
    //                 'post_image_path' => $path,
    //             ]);
    //         }

    // }
}
