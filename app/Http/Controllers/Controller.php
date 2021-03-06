<?php

namespace App\Http\Controllers;

use App\class_link_table;
use  Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function banObject($object,$reason){

        $object->banned_by = Auth::user()->id;
        $object->banned_reason = $reason;

        if( $this->BanValidator([
            "banned_by" =>$object->banned_by,
            "banned_reason" => $object->banned_reason
        ])->fails()){
            return redirect("forum")->with('returnError','Failed to ban '.ucfirst(substr(class_basename($object),0,-1)));
        }
        $object->save();
    }

    protected function BanValidator(array $data)
    {
        $user = Auth::user();
        return Validator::make($data, [
            'banned_by' => "required|integer|max:{$user->id}|min:{$user->id}",
            'banned_reason' => "required|min:4"
        ]);

    }

    protected function specialperm($object,$perm0 = null , $perm1 = null){

        $perms = [$perm0,$perm1];
        $link_id = [];
        foreach($perms as $permission => $perm) {
            if (!is_null($perm)&&$permission < 2) {

                if (isset($perm['user'])) {
                    if(!is_null($perm['user'])) {
                        $link_id = $this->specialPermissionsEdit($object, $perm['user'], 'user', $link_id, $permission);
                    }
                }
                if (isset($perm['usergroup'])) {
                    if(!is_null($perm['usergroup'])) {
                        $link_id = $this->specialPermissionsEdit($object, $perm['usergroup'], 'user_group', $link_id, $permission);
                    }
                }
                if (isset($perm['contgroup'])) {
                    if(!is_null($perm['contgroup'])) {
                        $link_id = $this->specialPermissionsEdit($object, $perm['contgroup'], 'content_group', $link_id, $permission);
                    }
                }
            }
        }

        $table = class_basename($object);

        $row = DB::table('class_link_tables')
            ->where("{$table}_id",$object->id)
            ->whereNotIn('id',$link_id);
        $row->delete();
    }



    protected function specialPermissionsEdit($object,$group,$type,$link_id,$permission){

        /**
         *
         * @param   object  $object
         * @param   array   $group
         * @param   string  $type
         * @param   array   $link_id
         * @param   integer $permission
         *
         * @return array
         */

        $table = class_basename($object);

        foreach($group as $id){
            $row = DB::table('class_link_tables')->where("{$table}_id",$object->id)->where("{$type}_id",$id)->get();
            if(!empty($row->all())){
                $row = $row->first();
                $link_id[] = $row->id;
                if($row->permission != $permission){
                    $row = class_link_table::find($row->id);
                    $row->permission = $permission;
                    $row->save();
                }
            }else{
                $row = new class_link_table;
                $row->permission = $permission;
                $row["{$table}_id"] = $object->id;
                $row["{$type}_id"] = $id;
                $row->save();

                $link_id[] = $row->id;
            }
        }
        return $link_id;
    }
}
