<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 15:49
 */

namespace App\Http\Controllers\Admin;


class RolesController extends Controller
{
    public function __construct(){

        parent::__construct();

        $this->middleware('can:view.roles', ['only' => 'getIndex']);
    }

    public function getIndex(){
        return view('admin.roles.index')->with('page_title', trans('admin.roles_title'));
    }

    public function getCreate(){
        return view('admin.roles.create')->with('page_title', trans('admin.roles_create_title'));
    }

    public function getEdit($id){
        return view('admin.roles.edit')->with('page_title', trans('admin.roles_title'));
    }

}