<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Image;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Comment/Index', [
            'title' => 'Comments',
            'commentsByData' => Comment::orderByDesc('created_at')->paginate(25),
            'comments' => Comment::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_id = request()->route('parent_id');

        return inertia('Comment/Create', [
            'parent_id' => $parent_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $userId = Auth::id();
        $filePath = null;
        $file = $request->file('image');
        $parent_id = $request->input('parent_id');

        if ($file) {
            $image = Image::make($file->path());
            if ($image->width() > 320 || $image->height() > 240) {
                $image->resize(320, 240, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $name = md5(Carbon::now()) . '_' . $file->getClientOriginalName();

            $imagePath = 'storage/images/' . $name;
            $image->save(public_path($imagePath));

            $filePath = "storage/images/{$name}";
        }

        Comment::create([
            'user_id' => $userId,
            'parent_id' => $parent_id,
            'text' => $request->input('text'),
            'image' => $filePath,
        ]);

        return redirect()->route('comments.index');
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->image) {
            $imagePath = public_path($comment->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $comment->delete();

        return redirect()->back();
    }

}
