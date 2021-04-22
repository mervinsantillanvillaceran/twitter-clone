<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $user = User::findOrFail($id);
        auth()->user()->following()->attach($user);

        return redirect(request()->headers->get('referer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        auth()->user()->following()->detach($user);

        return redirect(request()->headers->get('referer'));
    }
}
