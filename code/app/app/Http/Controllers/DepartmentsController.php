<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Departments;

class DepartmentsController extends Controller
{
    public function dump(Request $request)
    {
        foreach ($request->all($request->keys()) as $dep) {
            $uuid = (int) $dep["ID"];
            if (Users::find($uuid) == []) {
                if (isset($dep["UF_HEAD"])) {
                    $head = (int) $dep["UF_HEAD"];
                } else {
                    $head = NULL;
                };

                if (isset($dep["PARENT"])) {
                    $parent = (int) $dep["PARENT"];
                } else {
                    $parent = NULL;
                };

                Departments::insert([
                    "id" => $uuid,
                    "name" => (string) $dep["NAME"],
                    "sort" => (int) $dep["SORT"],
                    "parent_department_id" => $parent,
                    "head_user_id" => $head
                ]);
            }
        }

        return response(true, 200);

        //return $request->all($request->keys());
    }

    public function index()
    {
        return Departments::all();
    }

    public function search($id)
    {
        return response()->json(Departments::find($id));
    }

    public function update($id, Request $request)
    {
        $dep = Departments::findOrFail($id);
        $dep->update($request->all());

        return response()->json($dep, 200);
    }

    public function delete($id)
    {
        Departments::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
