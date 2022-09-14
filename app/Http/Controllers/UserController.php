<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }           

    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::select('id','name','email')
        ->where(function($q) use ($search){
            $q->where('name','LIKE',"%$search%")
            ->where('email','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
         return view('users.index')->with('users',$users);
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            DB::commit();
            Session::flash('success','User Created');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return view('users.edit')->with('user',$user);
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());
        if($request->password != null){
            $this->validate($request,[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'required|confirmed|min:6',
            ]);
        }else {
            $this->validate($request,[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);
        }
        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->has('password')){
                $user->password = bcrypt($request->password);
            }
            $user->save();
            DB::commit();
            Session::flash('info','User Udpated');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    public function destroy(User $user)
    {
        return redirect()->back();
    }
}
