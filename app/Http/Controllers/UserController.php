<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';

        $users = User::withCount(['followers as isFollowed' => function($query) {
            $query->where('follower_id', auth()->user()->id);
        }])->where('id', '!=', auth()->user()->id)
           ->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
           })->get();

        return Inertia::render('Users/Index', [
            'searchInput' => $search,
            'users' => $users
        ]);
    }

    /**
     * Show list of following.
     *
     * @return \Illuminate\Http\Response
     */
    public function following()
    {
        return Inertia::render('Users/Following', [
            'users' => auth()->user()->following
        ]);
    }

    /**
     * Show list of followers.
     *
     * @return \Illuminate\Http\Response
     */
    public function followers()
    {
        return Inertia::render('Users/Followers', [
            'users' => auth()->user()->followers
        ]);
    }

    /**
     * Show list of tweets.
     *
     * @return \Illuminate\Http\Response
     */
    public function tweets()
    {
        return Inertia::render('Users/Tweets', [
            'tweets' => auth()->user()->tweets
        ]);
    }
}
