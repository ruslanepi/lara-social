<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = User::whereNot('id', auth()->id())
            ->withCount('posts')
            ->get();

        $followingIds = SubscriberFollowing::where('subscriber_id', auth()->id())
            ->pluck('following_id')
            ->toArray();

        foreach ($users as $user) {
            if (in_array($user->id, $followingIds)) {
                $user->is_followed = true;
            }
        }
        return UserResource::collection($users);
    }

    public function post(User $user)
    {
        $posts = $user->posts()->latest()->get();
        $posts = $this->prepareLikedPosts($posts);

        return PostResource::collection($posts);
    }


    public function toggleSubscribe(User $user)
    {
        $res = auth()->user()->followings()->toggle($user->id);

        $data['is_followed'] = count($res['attached']) > 0;

        return $data;
    }


    public function followingPost()
    {
        $followedIds = auth()->user()->followings()->latest()->get()->pluck('id')->toArray();


        $likedPostIds = LikedPost::where('user_id', auth()->id())
            ->pluck('post_id')
            ->toArray();

        $posts = Post::whereIn('user_id', $followedIds)
            ->whereNotIn('id', $likedPostIds)
            ->get();



        return PostResource::collection($posts);

    }

    private function prepareLikedPosts($posts)
    {
        $likedPostIds = LikedPost::where('user_id', auth()->id())
            ->pluck('post_id')
            ->toArray();

        foreach ($posts as $post) {
            if (in_array($post->id, $likedPostIds)) {
                $post->is_liked = true;
            }
        }

        return $posts;
    }


}
