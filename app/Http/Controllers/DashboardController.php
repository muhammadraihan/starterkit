<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
   * Redirect to dashboard
   * @return [type] [description]
   */
  public function index(){
    return redirect()->route('backoffice.dashboard');
  }

  public function dashboard(){
    return view('backoffice.dashboard');
  }
}
