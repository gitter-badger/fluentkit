<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/02/16
 * Time: 13:00
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{

    public function __construct(){

        //all admin urls require authentication
        $this->middleware('auth');

        //all admin urls require the view.admin permission
        $this->middleware('can:view.admin');
    }

}