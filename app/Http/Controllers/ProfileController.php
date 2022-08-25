<?php

namespace App\Http\Controllers;

use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::all();
        $status = Status::where('tabla', 'General')->orderBy('id_status', 'ASC')->pluck('status','id_status');

        return view('layouts.myProfile.index', compact('user', 'status'));
    }

    public function update(Request $request , $id)
    {
//        return response()->json($request->all());
        $user            = User::findOrFail($id);
        $user->name      = $request->get('name');
        $user->phone     = $request->get('phone');
        $user->email     = $request->get('email');
        if ($request->input('address')){
            $user->address = $request->address;
        }
        if ($request->input('country')){
            $user->country = $request->country;
        }
        $user->save();

        session()->put('update' , 'Profile updated successfully.');

        return Redirect::to('profile');
    }
}
