<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\PostImage;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct(protected PostService $postService)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return $this->postService->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request["user_id"] = Auth::user()->id;
        $post =  $this->postService->store((array) $request->except('images'));

        foreach($request->images as $img)
        {
            $imgPath = Storage::disk('uploads')->put(Auth::user()->id . '/', $img);
            PostImage::create([
                'post_id' => $post->id,
                'post_image_path' => '/uploads/'.$imgPath,
                'user_id' => Auth::user()->id
            ]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->postService->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $id)
    {
       return $this->postService->update($id, (array)$request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->postService->delete($id);
    }
}
