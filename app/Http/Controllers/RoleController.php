<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Traits\Authorizable;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use DB;
use URL;
use DataTables;

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
        if (request()->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $roles = Role::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'name']);
            return DataTables::of($roles)
                ->addColumn('action', function ($row) {
                    if ($row->id == 1) {
                        return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="' . route('roles.edit', $row->id) . '" title="Edit Role"><i class="fal fa-map-signs"></i></a>';
                    }
                    return '
                    <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="' . route('roles.edit', $row->id) . '" title="Edit Role"><i class="fal fa-map-signs"></i></a>
                    <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="' . URL::route('roles.destroy', $row->id) . '" data-id="' . $row->id . '" data-token="' . csrf_token() . '" data-toggle="modal" data-target="#modal-delete" href="" title="Delete Role"><i class="fal fa-trash-alt"></i></a>';
                })
                ->removeColumn('id')
                ->make();
        }
        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collect_permissions = collect(Permission::select('id', 'name')->get());
        $menus = Menu::select('id', 'menu_title')->where('parent_id', 0)->get();
        $permissions = $collect_permissions->split(4);
        return view('roles.create', compact('permissions', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissions = $request->get('permissions', []);
        $menus = $request->get('menus', []);
        $rules = [
            'name' => 'required|min:4'
        ];
        $messages = [
            '*.required' => 'Field is required',
            '*.min' => 'Field must be at least 3 characters',
        ];
        $this->validate($request, $rules, $messages);

        DB::beginTransaction();
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            // sync role to permissions
            $role->syncPermissions($permissions);
            // add attach menu to role
            $role->menus()->attach($menus);
        } catch (Exception $e) {
            // catch error and rollback database update
            DB::rollback();
            toastr()->error($e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
        // now is save to commit update and redirect to index
        DB::commit();
        toastr()->success('New Role Added', 'Success');
        return redirect()->route('roles.index');
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
    public function edit(Request $request, $id)
    {
        $collect_permissions = collect(Permission::select('id', 'name')->get());
        $menus = Menu::select('id', 'menu_title')->where('parent_id', 0)->get();
        $permissions = $collect_permissions->split(4);
        $role = Role::where('id', $id)->first();
        return view('roles.edit', compact('role', 'permissions', 'menus'));
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
        $permissions = $request->get('permissions', []);
        $menus = $request->get('menus', []);
        $rules = [
            'name' => 'required|min:4'
        ];
        $messages = [
            '*.required' => 'Field is required',
            '*.min' => 'Field must be at least 3 characters',
        ];
        $this->validate($request, $rules, $messages);
        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $role->save();
            // sync role to permissions
            $role->syncPermissions($permissions);
            // sync menu to role
            $role->menus()->sync($menus);
        } catch (Exception $e) {
            // catch error and rollback database update
            DB::rollback();
            toastr()->error($e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
        // now is save to commit update and redirect to index
        DB::commit();
        toastr()->success('Role ' . $role->name . ' updated', 'Success');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            // remove permissions
            $role->syncPermissions();
            // remove menu
            $role->menus()->detach();
            $role->delete();
        } catch (Exception $e) {
            // catch error and rollback database update
            DB::rollback();
            toastr()->error($e->getMessage(), 'Error');
            return redirect()->route('roles.index');
        }
        DB::commit();
        toastr()->success('Role Deleted', 'Success');
        return redirect()->route('roles.index');
    }
}
