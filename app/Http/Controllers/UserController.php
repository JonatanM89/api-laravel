<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\PostController;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function get($id){
        $users   = User::find($id);
        return Response()->json($users,201);

    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();

        return Response('ok');
    }

    public function save(Request $data){
        if($data->input('modal_id') == '0'){
            $nv_user = new User();
            $nv_user->name      = $data->input('modal_name');
            $nv_user->email     = $data->input('modal_email');
            $nv_user->password  = 'asass';
            $nv_user->username  = $data->input('modal_username');

            $nv_user->save();

        }
        else
        {
            $nv_user            = User::find($data->input('modal_id'));
            if($nv_user){
                $nv_user->name      = $data->input('modal_name');
                $nv_user->email     = $data->input('modal_email');
                $nv_user->password  = 'asass';
                $nv_user->username  = $data->input('modal_username');
                $nv_user->save();
            } else {
                echo "Usuario não encontrado";
            }
        }
    }

    
}
