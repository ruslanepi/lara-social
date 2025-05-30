<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostImage\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostImageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $path = Storage::disk('public')->putFile('images', $request->file('image'));
        $image = PostImage::create([
            'path' => $path,
            'user_id' => auth()->id(),
        ]);
        return new PostImageResource($image);
    }
}
