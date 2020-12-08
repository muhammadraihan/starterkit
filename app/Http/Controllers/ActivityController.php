<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class ActivityController extends Controller
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
          $logs = Activity::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
          'id','log_name','causer_id','description','created_at'])->get();
          return DataTables::of($logs)
          ->editColumn('created_at', function($log){
            if(!empty($log->created_at)){
              return Carbon::parse($log->created_at)->format('l\\, j F Y h:i:s A');
            }
          })
          ->editColumn('causer_id', function($log){
            if (!empty($log->causer_id)) {
              return $log->getUser->name;
            }
            return "Seeder System";
          })
          ->removeColumn('id')
          ->make();
          }
          return view('activity.index');
    }
}
