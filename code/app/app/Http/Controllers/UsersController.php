<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\UsDep;

class UsersController extends Controller
{
    public function dump(Request $request)
    {

        foreach ($request->all($request->keys()) as $user) {
            $u_id = (int) $user["ID"];
            //если пользователь ещё не добавлен и не был удалён
            if ((Users::find($u_id) == []) && ($user["ACTIVE"])){
                //валидация uuid
                if ((isset($user["XML_ID"])) && ($user["XML_ID"] != "")) {
                    $uuid = substr($user["XML_ID"], 3);
                } else {
                    $uuid = NULL;
                };

                //вилидация имени
                if ( (isset($user["NAME"])) && (isset($user["LAST_NAME"])) && (isset($user["SECOND_NAME"])) ) {
                    $full_name = $user["LAST_NAME"] ." " . $user["NAME"] . " " . $user["SECOND_NAME"];
                    $name = $user["NAME"];
                    $second_name = $user["SECOND_NAME"];
                    $last_name = $user["LAST_NAME"];
                } elseif (!isset($user["SECOND_NAME"])) {
                    $second_name = NULL;
                    if (!isset($user["LAST_NAME"])) {
                        $last_name = NULL;
                        if (!isset($user["NAME"])) {
                            $full_name = NULL;
                        } else {
                            $full_name = $user["NAME"];
                        }
                    } else {
                        if (!isset($user["NAME"])) {
                            $name = NULL;
                            $full_name = $user["LAST_NAME"];
                        } else {
                            $full_name = $user["LAST_NAME"] . " " . $user["NAME"];
                        }
                    }
                };

                //валидация почты
                if (isset($user["EMAIL"])) {
                    $mail = $user["EMAIL"];
                } else {
                    $mail = NULL;
                };

                //валидация дирекции
                if ((isset($user["UF_USR_1696592324977"])) && ($user["UF_USR_1696592324977"] !== []) && ($user["UF_USR_1696592324977"] !== "")) {
                    if (is_array($user["UF_USR_1696592324977"])){
                        $direction = $user["UF_USR_1696592324977"][0];
                    } elseif (is_string($user["UF_USR_1696592324977"])) {
                        $direction = $user["UF_USR_1696592324977"];
                    } else {
                        $direction = NULL;
                    }
                } else {
                    $direction = NULL;
                };

                //валидация должности
                if ((isset($user["WORK_POSITION"])) && ($user["WORK_POSITION"] !== "") && ($user["WORK_POSITION"] !== [])){
                    if (is_array($user["WORK_POSITION"])){
                        $pst = $user["WORK_POSITION"][0];
                    } elseif (is_string($user["WORK_POSITION"])) {
                        $pst = $user["WORK_POSITION"];
                    } else {
                        $pst = NULL;
                    }
                } else {
                    $pst = NULL;
                };

                if ( (isset($user["PERSONAL_BIRTHDAY"])) && ($user["PERSONAL_BIRTHDAY"] != "") ) {
                    $birthday = strtotime($user["PERSONAL_BIRTHDAY"]);
                } else {
                    $birthday = NULL;
                }

                if ( (isset($user["PERSONAL_CITY"])) && ($user["PERSONAL_CITY"] != "")) {
                    $city = $user["PERSONAL_CITY"];
                } else {
                    $city = NULL;
                }

                if ( (isset($user["WORK_PHONE"])) && ($user["WORK_PHONE"] != "")) {
                    $phone = $user["WORK_PHONE"];
                } else {
                    $phone = NULL;
                }

                if ( (isset($user["UF_PHONE_INNER"])) && ($user["UF_PHONE_INNER"] != "")) {
                    $work_phone = $user["UF_PHONE_INNER"];
                } else {
                    $work_phone = NULL;
                }

                if ( (isset($user["PERSONAL_MOBILE"])) && ($user["PERSONAL_MOBILE"] != "")) {
                    $personal_phone = $user["PERSONAL_MOBILE"];
                } else {
                    $personal_phone = NULL;
                }

                if ( (isset($user["PERSONAL_PHOTO"])) && ($user["PERSONAL_PHOTO"] != "")) {
                    $photo = $user["PERSONAL_PHOTO"];
                } else {
                    $photo = NULL;
                }

                Users::insert([
                    "id" => $u_id,
                    "uuid" => $uuid,
                    "name" => $name,
                    "last_name" => $last_name,
                    "second_name" => $second_name,
                    "full_name" => $full_name,
                    "email" => $mail,
                    "direction" => $direction,
                    "post" => $pst,
                    "birthday" => date('Y-m-d', $birthday),
                    "city" => $city,
                    "phone" => $phone,
                    "work_phone" => $work_phone,
                    "personal_phone" => $personal_phone,
                    "photo" => $photo
                ]);

                //валидация подразделения
                $dep = [];
                if ((isset($user["UF_DEPARTMENT"])) && ($user["UF_DEPARTMENT"] !== [])) {
                    foreach ($user["UF_DEPARTMENT"] as $dp_id) {
                        array_push($dep, (int) $dp_id);
                    }
                };

                /*
                if ((isset($user["UF_USR_1586854037086"])) and (!in_array($user["UF_USR_1586854037086"], $dep))) {
                    array_push($dep, (int) $user["UF_USR_1586854037086"]);
                };
                */
                /*
                if ((isset($user["UF_USR_1594879216192"])) and (!in_array($user["UF_USR_1594879216192"], $dep))) {
                    array_push($dep, (int) $user["UF_USR_1594879216192"]);
                };
                */

                if ($dep !== []) {
                    foreach($dep as $d_ip) {
                        UsDep::insert([
                            "user_id" => $u_id,
                            "department_id" => $d_ip,
                        ]);
                    }
                }

            }
        }
        return response(true, 200);

        //return $request->all($request->keys());

    }

    public function index()
    {
        return Users::all();
    }

    public function search($id)
    {
        return response()->json(Users::find($id));
    }

    public function update($id, Request $request)
    {
        $dep = Users::findOrFail($id);
        $dep->update($request->all());

        return response()->json($dep, 200);
    }

    public function delete($id)
    {
        Users::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
