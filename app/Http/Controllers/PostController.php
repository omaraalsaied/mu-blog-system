<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\PostImage;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    public function __construct(protected PostService $postService)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function user_posts()
    {
       $posts = $this->postService->user_posts(auth()->user()->id);
        return Inertia::render('Posts/UserPosts', ['posts' => $posts]);
    }

    public function index()
    {
       $posts = $this->postService->all();
        return Inertia::render('Welcome', ['posts' => $posts , 'canLogin' => Route::has('login'), 'canRegister' => Route::has('register')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request["user_id"] = Auth::user()->id;
    //    dd($request->file('images'));
        $post =  $this->postService->store($request->except('images'));

        if($request->files->get('images')) {
            foreach($request->files->get('images') as $img)
            {
                $img_name = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . '.'. $img->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('images',$img, $img_name );
                PostImage::create([
                    'post_id' => $post->id,
                    'post_image_path' => $path,
                    'user_id' => Auth::user()->id,
                ]);
            }
        }
        return redirect()->route('posts.index');

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
       $post = $this->postService->find($id);
       return Inertia::render('Posts/Edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $id)
    {
        $this->postService->update($id, $request->only('title', 'body'));
        return redirect()->route('posts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->postService->delete($id);
    }
}
