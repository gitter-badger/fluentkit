<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/02/16
 * Time: 21:30
 */

namespace App\Http\Controllers\Admin;


use App\Services\Admin\SettingsRegistrar;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function __construct(){

        parent::__construct();

        $this->middleware('can:view.settings', ['only' => 'getIndex']);
        $this->middleware('can:update.settings', ['only' => 'postIndex']);
    }

    public function getIndex(SettingsRegistrar $reg){
        return view('admin.settings')->with('page_title', trans('admin.settings_title'))->with('groups', $reg->sortByPriority()->values()->toJson());
    }

    public function postIndex(Request $request, Filesystem $files, SettingsRegistrar $reg){

        //validate
        $this->validate($request, [
            'settings' => 'array',
            'settings.*.id' => 'string|max:255',
            'settings.*.value' => 'string|numeric'
        ]);

        //set config and store data in array for exporting later on
        $data = [];
        foreach($request->get('settings') as $setting){
            config()->set($setting['id'], $setting['value']);
            $data[$setting['id']] = $setting['value'];
        }

        //store data in storage/app/settings.php to overwrite config
        $file = storage_path('app/settings.php');
        $files->put($file, '<?php return '.var_export($data, true).';'.PHP_EOL);

        return response()->json([
            'status' => 'success',
            'message' => trans('global.save_successful'),
            'groups' => $reg->sortByPriority()->values()->toArray(),
        ]);
    }

}