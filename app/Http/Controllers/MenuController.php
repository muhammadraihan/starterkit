<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Traits\Authorizable;
use Illuminate\Http\Request;
use Auth;
use DB;
use Route;
use URL;
use DataTables;

class MenuController extends Controller
{
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
            $menus = Menu::select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id', 'uuid', 'menu_title', 'route_name', 'icon_class', 'parent_id', 'order'
            ]);
            // dd($menus);
            return DataTables::of($menus)
                ->editColumn('route_name', function ($row) {
                    return $row->route_name ? $row->route_name : '#';
                })
                ->editColumn('icon_class', function ($row) {
                    return "<i class='" . $row->icon_class . "'></i>";
                })
                ->editColumn('parent_id', function ($row) {
                    if ($row->parent_id == 0) {
                        return $row->menu_title;
                    }
                    return $row->parent->menu_title;
                })
                ->addColumn('action', function ($row) {
                    return '
                    <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="' . route('menus.edit', $row->uuid) . '" title="Edit"><i class="fal fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="' . URL::route('menus.destroy', $row->uuid) . '" data-id="' . $row->uuid . '" data-token="' . csrf_token() . '" data-toggle="modal" data-target="#modal-delete" href="" title="Delete"><i class="fal fa-trash-alt"></i></a>';
                })
                ->removeColumn('id')
                ->removeColumn('uuid')
                ->rawColumns(['action', 'icon_class'])
                ->make();
        }
        return view('menus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = Menu::select('id', 'menu_title')->where('parent_id', 0)->get();
        $routes = Route::getRoutes();
        $routes_name = collect($routes);
        $filtered_routes = $routes_name->filter(function ($value, $key) {
            return $value->methods()[0] == 'GET' && $value->getName() != null;
        });
        return view('menus.create', compact('parent', 'filtered_routes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'menu_title' => 'required',
            'order' => 'required|integer',
        ];
        $messages = [
            '*.required' => 'Field is required',
            '*.integer' => 'Field must be number',
        ];
        $this->validate($request, $rules, $messages);
        $menu = new Menu();
        $menu->menu_title = $request->menu_title;
        $menu->route_name = $request->route_name;
        $menu->order = $request->order;
        $menu->icon_class = $request->icon_class;
        if ($request->is_child == 1) {
            $rules = [
                'parent' => 'required',
            ];
            $messages = [
                '*.required' => 'Field is required',
            ];
            $this->validate($request, $rules, $messages);
            $menu->parent_id = $request->parent;
        }
        $menu->created_by = Auth::user()->uuid;
        $menu->save();
        toastr()->success('New menu added', 'Success');
        return redirect()->route('menus.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $menu = Menu::uuid($uuid);
        $parent_menu = Menu::select('id', 'menu_title')->where('parent_id', 0)->get();
        $routes = Route::getRoutes();
        $routes_name = collect($routes);
        $filtered_routes = $routes_name->filter(function ($value, $key) {
            return $value->methods()[0] == 'GET' && $value->getName() != null;
        });
        return view('menus.edit', compact('menu', 'parent_menu', 'filtered_routes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $menu = Menu::uuid($uuid);
        $menu->menu_title = $request->menu_title;
        $menu->route_name = isset($request->route_name) ? $request->route_name : '';
        $menu->order = $request->order;
        $menu->icon_class = $request->icon_class;
        $menu->parent_id = isset($is_child) ? $request->parent : 0;
        $menu->edited_by = Auth::user()->uuid;
        $menu->save();
        toastr()->success('Menu Edited', 'Success');
        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
