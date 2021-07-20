<?php

namespace App\Http\Controllers;

use App\Traits\Authorizable;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
      $logs = Activity::select([
        DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'id', 'log_name', 'causer_id', 'description', 'created_at'
      ]);
      return DataTables::of($logs)
        ->editColumn('created_at', function ($log) {
          if (!empty($log->created_at)) {
            return Carbon::parse($log->created_at)->format('l\\, j F Y h:i:s A');
          }
        })
        ->editColumn('causer_id', function ($log) {
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
