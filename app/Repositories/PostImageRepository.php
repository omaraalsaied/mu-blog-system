<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;



class PostImageRepository implements PostImageRepositoryInterface {

    public function uploadImages(array $images, Post $post)
    {
        // TODO: Implement uploadImages() method.
        // dd($images);
        foreach($images as $img)
        {
            foreach($img as $file)
            {
                
                $file_name = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . '.'. $file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('images',$file, $file_name );

                $post->post_images()->create([
                    'post_id' => $post->id,
                    'post_image_path' => $path,
                ]);
            }
        }

    }

public function deleteImage(int $id)
    {
        // TODO: Implement deleteImage() method.
        $img = PostImage::findorFail($id);
        $img->delete();
        return response()->json([
            'message' => "deleted Successfully"
        ], 200);
    }
}
