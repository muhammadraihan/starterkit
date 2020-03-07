<?php

namespace App\Http\Controllers;

use App\Traits\Authorizable;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate input
      $this->validate($request,
      //rules
      [
        'name'  =>  'required|unique:roles,name'
      ]);

      $role = new Role();
      $role->name = $request->name;
      $role->save();

      toastr()->success('New Role Added','Success');
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($role = Role::findOrFail($id)) {
            // admin role has everything
            if ($role->name === 'superadmin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('roles.index');
            }
            $permissions = $request->get('permissions', []);
            $role->syncPermissions($permissions);
            toastr()->success($role->name . ' Role Permission has been updated', 'Success');
        } else {
            toastr()->error('Role with id' . $id . 'not found', 'Error');
        }
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
