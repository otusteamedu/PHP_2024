<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Departments;
use App\Models\UsDep;

class ViewController extends Controller
{
    public function users()
    {
        return view('users', ['users' => Users::all()]);
    }

    public function create()
    {
        return view('create');
    }

    public function upload(Request $request)
    {
        $u_id = (int) $request["ID"];


        Users::insert([
            "id" => (int) $request["ID"],
            "full_name" => $request["full_name"],
            "email" => $request["email"],
            "photo" => $request["photo"]
        ]);

        return redirect("/user/$u_id");
    }

    public function user($id)
    {
        $user_inf = Users::find($id);
        return view('user', ['user' => $user_inf]);
    }
}
