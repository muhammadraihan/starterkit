<?php

namespace App\Http\Controllers;

use App\Traits\Authorizable;
use App\Permission;
use App\Role;
use DataTables;
use DB;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
            $permissions = Permission::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'name', 'created_at']);
            return DataTables::of($permissions)
                ->editColumn('created_at', function ($permission) {
                    return $permission->created_at->format('l \\, jS F Y h:i:s A');
                })->make();
        }
        return view('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get superadmin role
        $role = Role::where('id', 1)->first();
        // if basic checked
        if ($request->permission_type == 'basic') {
            // validate input
            $this->validate($request, [
                'name' => 'required|max:255|alpha_dash|unique:permissions,name',
            ]);

            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();
            // superadmin get all permissions
            $permission->syncRoles($role);
            toastr()->success('Basic Permission Added', 'Success');
            return redirect()->route('permissions.index');
        } elseif ($request->permission_type == 'crud') {
            // validate input
            $this->validate($request, [
                'resource' => 'required|min:3|max:100|alpha',
            ]);
            // get checkbox value
            $crud = $request->input('action');
            // dd($crud);
            if ($crud != null) {
                foreach ($crud as $action) {
                    // combine resource name with crud action item name
                    $slug = strtolower($action) . '_' . strtolower($request->resource);
                    // saving data
                    $permission = new Permission();
                    $permission->name = $slug;
                    $permission->save();
                    $permission->syncRoles($role);
                }
                toastr()->success('Resource Permission Added', 'Success');
                return redirect()->route('permissions.index');
            }
            //throw error notification if none of action opt in
            else {
                toastr()->error('Please choose one of the CRUD Actions', 'Error');
                return redirect()->route('permissions.create')->withInput();
            }
        }
        //throw error notification if none of option opt in
        else {
            toastr()->error('Please choose one of the options', 'Error');
            return redirect()->route('permissions.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
