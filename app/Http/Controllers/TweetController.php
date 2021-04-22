<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';

        $tweets = Tweet::with('user')
                        ->where('text', 'LIKE', "%{$search}%")
                        ->latest()
                        ->get();

        return Inertia::render('Tweets/Index', [
            'searchInput' => $search,
            'tweets' => $tweets
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet = Tweet::with(['user', 'comments' => function($query) {
            $query->with('user')->orderByDesc('created_at');
        }])->find($id);

        if (!$tweet) return redirect("/tweets");

        return Inertia::render('Tweets/Show', [
            'tweet' => $tweet
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Tweets/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $id = Tweet::create([
            'user_id' => auth()->user()->id,
            'text' => $request->text,
        ])->id;

        return redirect("/tweets/{$id}");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        return Inertia::render('Tweets/Edit', [
            'tweet' => $tweet
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $tweet->update([
            'text' => $request->text,
        ]);

        return redirect("/tweets/{$tweet->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return redirect(request()->headers->get('referer'));
    }
}
