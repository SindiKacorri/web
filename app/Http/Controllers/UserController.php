<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editUser()
    {
        return view('user.edit');
    }

    public function updateUser(Request $request)
    {
        if(empty($request->get('name'))) {
            return redirect('/user/edit')->with('warning', 'Ju lutem plotesoni fushen e emrit.');
        }

        $user = User::where('id', Auth::id())->first();

        $user->name = $request->get('name');

        $user->save();
        return redirect('/user/edit')->with('message', 'Emri u ndryshua me sukses.');
    }
}
