<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 15:49
 */

namespace App\Http\Controllers\Admin;


use App\Models\Role;

class RolesController extends Controller
{
    public function __construct(){

        parent::__construct();

        $this->middleware('can:view.roles', ['only' => 'getIndex']);
    }

    public function getIndex(){
        return view('admin.roles.index')->with('page_title', trans('admin.roles_title'));
    }

    public function getEdit($id){
        //fetch the role here just to force a 404 if it doesnt exit, we fetch it via ajax for the display anyway.
        $role = Role::findOrFail($id);
        if($role->name == 'administrator'){
            abort(404);
        }
        return view('admin.roles.edit')->with('page_title', trans('admin.roles_title'))->with('id', $id);
    }

}