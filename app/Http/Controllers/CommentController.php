<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct(
        protected CommentService $commentService
    ){}


    public function store(Request $request)
    {
        $request['user_id'] = Auth::user()->id;
        $this->commentService->store($request->all());
    }

    public function update(Request $request)
    {
         $this->commentService->update($request->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->commentService->delete($id);
    }
}
