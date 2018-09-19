<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('userprofile');
    }

    public function index()
    {
        $users = User::all();

        return view('manage.users', compact('users'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'confirmation_password' => 'required|same:password',
        ]);


        if ($validator->passes()) {
            $user = New User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_name = 'viewer';
            $user->save();

            return response()->json(['success'=>'User has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_name = $request->role_name;

        $user->save();

        return response()->json(['success'=>'User data has been updated.']);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);

        $user->delete();

        return response()->json(['success'=>'User has been deleted.']);
    }

    public function updatepicture(Request $request)
    {
        $user = User::find($request->id);
        if ($request->file('profile_picture') != null)
        {
            $rand = rand();
            unlink('images/profile/' . $user->profile_picture);

            $file = $request->file('profile_picture');
            $file->move(public_path('/images/profile'), $file->getClientOriginalName().$rand);
            $user->profile_picture = $file->getClientOriginalName().$rand;
            $user->save();
        }

        return back()->with('update_pp','Picture has been updated.');
    }

    public function removepicture($id)
    {
        $user = User::find($id);

        unlink('images/profile/' . $user->profile_picture);

        $user->profile_picture = null;
        $user->save();


        return back()->with('remove_pp','Picture has been removed.');
    }
}
