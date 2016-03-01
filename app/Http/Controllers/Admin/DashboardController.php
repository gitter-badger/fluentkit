<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/02/16
 * Time: 13:02
 */

namespace App\Http\Controllers\Admin;

class DashboardController extends Controller
{

    public function getIndex(){
        return view('admin.dashboard')->with('page_title', trans('admin.dashboard_title'));
    }

}