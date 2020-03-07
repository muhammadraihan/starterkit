<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;

use App\User;
use App\Role;
use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class UserController extends Controller
{
    // auth trait for access control level
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
          DB::statement(DB::raw('set @rownum=0'));
          $users = User::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
          'id','uuid','name','email','last_login_at','last_login_ip'])->get();
  
          return DataTables::of($users)
          ->addColumn('role',function($user){
            foreach ($user->roles as $role) {
              return $role->name;
            }
          })
          ->editColumn('last_login_at', function($user){
            if(!empty($user->last_login_at)){
              return Carbon::parse($user->last_login_at)->format('l\\, j F Y h:i:s A');
            }
          })
          ->addColumn('action', function ($user) {
            if(auth()->user()->can('edit_users','delete_users')){
              return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('users.edit',$user->uuid).'"><i class="fal fa-edit"></i></a>
              <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('users.destroy',$user->uuid).'" data-id="'.$user->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
            }
            else{
              return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
            }
          })
          ->removeColumn('id')
          ->removeColumn('uuid')
          ->make();
          }
          return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles = Role::all()->pluck('name','name');
      return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd(request()->all());
      // Validation
      $this->validate($request,[
        'name' => 'required|min:2',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'role' => 'required',
      ]);

      // retrieve password
      $password = trim($request->password);
      // Save
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($password);
      $user->save();
      // assign role to user
      if($request->get('role')) {
        $user->assignRole($request->get('role'));
      }

      toastr()->success('New User Added','Success');
      return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
      $roles = Role::all()->pluck('name','name');
      $user = User::uuid($uuid);
      // dd($user->roles[0]['name']);
      return view('users.edit', compact('roles','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
      // Validation
      $this->validate($request,[
        'name' => 'required|min:2',
        'email' => 'required|email|unique:users,email,'.$uuid.',uuid',
      ]);
      // Saving data
      $user = User::uuid($uuid);
      $user->name = $request->name;
      $user->email = $request->email;
      // Check password change
      if($request->get('password')) {
        $this->validate($request,[
          'password' => 'required|min:8'
        ]);
        // retrieve password
        $password = trim($request->password);
        $user->password = Hash::make($password);
      }
      $user->save();
      // sync role to user if any roles changed
      if($request->get('role')) {
        $user->syncRoles([$request->get('role')]);
      }

      toastr()->success('User Edited','Success');
      return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
      $user = User::uuid($uuid);
      // remove assigned role
      $user->syncRoles([]);
      // delete user
      $user->delete();

      toastr()->success('User Deleted','Success');
      return redirect()->route('users.index');
    }

    /**
     * Show user profile
     *
     * @param   $user user
     * @return \Illuminate\Http\Response
     */
    public function profile(User $user)
    {
      $user = Auth::user();
      return view('users.profile', compact('user'));
    }

    /**
     * Update User Profile
     *
     * @param   Request  $request
     * @param   $user    user
     *
     * @return \Illuminate\Http\Response
     */
    public function ProfileUpdate(Request $request, $user)
    {
      // validation
      $rules =[
        'name' => 'required|min:3'
      ];
      $messages = [
        'name.required' => 'Name can not be empty',
        'name.min' => 'Name must be at least 3 characters'
      ];
      $this->validate($request, $rules, $messages);
      // check avatar request
      $user = Auth::user();
      if (!empty($request['avatar'])) {
        $validation =[
          'avatar'=>'mimes:jpeg,png,jpg|max:2048'
        ];

        $messages = [
          'avatar.mimes' => 'File type must be jpeg,jpg or png',
          'avatar.max' => 'File size max 2MB'
        ];
        $this->validate($request, $validation, $messages);

        $folder = public_path().'/img'.'/avatar'.'/';
        if (!File::exists($folder)) {
          File::makeDirectory($folder, 0775, true, true);
        }
        // request image files
        $avatar = $request->file('avatar');
        //upload image file
        $filename = md5(uniqid(mt_rand(),true)).'.'.$avatar->getClientOriginalExtension();
        $fitImage = Image::make($avatar);
        $fitImage->save($folder.$filename);
        $request['avatar'] = $filename;
        $user->avatar = $filename;
      }
      $user->name = $request->name;
      $user->save();
      toastr()->success('Profile Updated','Success');
      return redirect()->back();
    }

    public function ChangePassword(Request $request,$user)
    {
      $rules =[
        'old-password' => 'required',
        'new-password' => 'required|string|min:8',
        'confirm-password' => 'required',
      ];
      $messages = [
        '*.required' => 'This field can not be empty',
        'new-password.min' => 'New Password must be at least 8 characters'
      ];
      $this->validate($request, $rules, $messages);

      // check user current password if match
      if (!Hash::check($request->get('old-password'), Auth::user()->password)){
        toastr()->error('Old password incorrect !','Error',['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
      }

      // check if user using same fucking password for the new password
      if(strcmp($request->get('old-password'), $request->get('confirm-password')) == 0){
        toastr()->error('New password has been used, please provide new one !','Error',['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
      }

      // check if new password is match with confirmation password
      if(strcmp($request->get('new-password'),$request->get('confirm-password')) !== 0){
        toastr()->error('New password not the same with confirmation !','Error',['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
      }
      //Change password
      $user = Auth::user();
      $user->password = Hash::make($request->get('confirm-password'));
      $user->save();
      toastr()->success('Password changed','Success');
      return redirect()->back();
    }
}
