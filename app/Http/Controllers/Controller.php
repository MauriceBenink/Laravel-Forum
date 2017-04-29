<?php

namespace App\Http\Controllers;

use App\class_link_table;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



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

    protected function specialPermissionsRemove($object,$link_id = []){
        $table = class_basename($object);

        $row = DB::table('class_link_tables')
            ->where("{$table}_id",$object->id)
            ->whereNotIn('id',$link_id);
        $row->delete();
    }
}
