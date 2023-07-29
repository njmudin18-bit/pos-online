<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Response;

class UsersController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    \LogActivity::addToLog('VIEW');
    $user = Auth::user();
    $unit = DB::table('unit')
      ->select('*')
      ->get();
    $group_halaman  = "Roles & Permissions";
    $halaman        = "Daftar Users";
    $breadcrumbs    = "Users";

    return view('user.user', compact('user', 'unit', 'halaman', 'group_halaman', 'breadcrumbs'));
  }

  function get_list(Request $request)
  {
    $user = DB::table('users')
      ->select('*')
      ->orderByDesc('id')
      ->get();

    $data = array();
    $no = 0;
    foreach ($user as $r) {
      $no = $no + 1;
      $role = DB::table('role_user')
        ->join('roles as b', 'role_user.role_id', '=', 'b.id')
        ->selectRaw('b.name, role_user.role_id')
        ->where('role_user.user_id', $r->id)
        ->get();
      $rolenya    = '';
      $param_role = "'" . $r->id . "', '" . $r->email . "', '" . $r->name . "'";
      $btntambah  = '<button class="btn btn-warning btn-sm" onclick="add_role(' . $param_role . ')">
                      <i class="icofont icofont-ui-add mr-2"></i>Role Permission
                    </button>';
      foreach ($role as $rr) {
        $paramdel = "'" . $r->id . "', '" . $rr->role_id . "'";
        $rolenya .= '<div class="btn-group m-1" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary btn-sm">' . $rr->name . '</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="del_role(' . $paramdel . ')">
                          <i class="icofont icofont-ui-delete"></i>
                        </button>
                    </div>';
      }

      $edit_  = "'" . $r->id . "', '" . $r->nip . "', '" . $r->name . "', '" . $r->email . "', '" . $r->telp . "', '" . $r->level . "', '" . $r->perusahaan . "'";
      $hapus_ = "'" . $r->id . "', '" . $r->email . "'";
      $row    = array();
      $row[]  = $no;
      $row[]  = '<button class="btn btn-info btn-sm mr-2" title="Edit" onclick="edit_data(' . $edit_ . ')">
                  <i class="icofont icofont-ui-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm" title="Hapus" onclick="hapus_data(' . $hapus_ . ')">
                  <i class="icofont icofont-ui-close"></i>
                </button>';
      $row[]  = $r->name . " - " . $r->id;
      $row[]  = $r->email;
      $row[]  = "<table class='tableXX'><tr><td>" . $btntambah . "</td><td style='word-wrap: break-word;min-width: 100%;max-width:100%;white-space:normal;'>" . $rolenya . "</td></tr></table>";
      $data[] = $row;
    }

    echo json_encode(array("data" => $data));
  }

  function save(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'nip'           => 'required|min:12',
      'nama'          => 'required|min:3',
      'email'         => 'required|email',
      'password'      => 'required|min:7',
      'telepon'       => 'required|min:7',
      'level'         => 'required',
      'perusahaan'    => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'error_string'  => $validator->errors()->all(),
          'inputerror'    => $validator->errors()->keys()
        ]
      );
    }

    $email = $request->post('email');
    $check = DB::table('users')->select('*')->where('email', $email)->count();
    if ($check == 0) {

      $password = Hash::make($request->post('password'));
      $data = array(
        'nip'         => $request->post('nip'),
        'name'        => $request->post('nama'),
        'email'       => $request->post('email'),
        'telp'        => $request->post('telepon'),
        'password'    => $password,
        'level'       => $request->post('level'),
        'perusahaan'  => $request->post('perusahaan'),
      );

      $insert = DB::table('users')->insert($data);
      if ($insert) {
        $response = Response::json([
          'code'        => 200,
          'status'      => "success",
          'message'     => "Data sukses terdaftar.",
          'data'        => $data
        ], 200);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      } else {
        $response = Response::json([
          'code'        => 400,
          'status'      => "error",
          'message'     => "Data gagal terdaftar.",
          'data'        => $data
        ], 400);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      }
    } else {
      $response = Response::json([
        'code'        => 409,
        'status'      => "error",
        'message'     => "Data " . $email . " sudah terdaftar.",
        'data'        => $email
      ], 409);

      //SAVE TO LOG
      \LogActivity::addToLog('ADD', $response);

      return $response;
    }
  }

  function save_edit(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'nip'           => 'required|min:12',
      'nama'          => 'required|min:3',
      'email'         => 'required|email',
      'telepon'       => 'required|min:7',
      'level'         => 'required',
      'perusahaan'    => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'error_string'  => $validator->errors()->all(),
          'inputerror'    => $validator->errors()->keys()
        ]
      );
    }

    $id       = $request->post('id');
    $old_data = DB::table('users')->where('id', $id)->first();
    $data = array(
      'nip'         => $request->post('nip'),
      'name'        => $request->post('nama'),
      'email'       => $request->post('email'),
      'telp'        => $request->post('telepon'),
      'level'       => $request->post('level'),
      'perusahaan'  => $request->post('perusahaan'),
    );

    $update = DB::table('users')->where('id', $id)->update($data);
    if ($update) {
      $response = Response::json([
        'code'        => 200,
        'status'      => "error",
        'message'     => "Data sukses diupdate.",
        'data'        => $data
      ], 200);

      //SAVE TO LOG
      \LogActivity::addToLog('UPDATED', $response, json_encode($old_data));

      return $response;
    } else {
      $response = Response::json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal diupdate.",
        'data'        => $data
      ], 500);

      //SAVE TO LOG
      \LogActivity::addToLog('UPDATED', $response, json_encode($old_data));

      return $response;
    }
  }

  function delete_user(Request $request)
  {
    $id       = $request->post('id');
    $email    = $request->post('email');
    $data_del = DB::table('users')->where('id', $id)->first();
    $where    = array('id' => $id, 'email' => $email);
    $delete   = DB::table('users')->where($where)->delete();
    if ($delete) {
      $response = Response::json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data sukses dihapus.",
        'data'        => $data_del
      ], 200);

      //SAVE TO LOG
      \LogActivity::addToLog('DELETED', $response);

      return $response;

      // return response()->json([
      //   'code'        => 200,
      //   'status'      => "success",
      //   'message'     => "Data sukses dihapus."
      // ], 200);
    } else {
      $response = Response::json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal dihapus.",
        'data'        => $data_del
      ], 500);

      //SAVE TO LOG
      \LogActivity::addToLog('DELETED', $response);

      return $response;

      // return response()->json([
      //   'code'        => 500,
      //   'status'      => "error",
      //   'message'     => "Data gagal dihapus."
      // ], 500);
    }
  }

  function del_role(Request $request)
  {
    $role_id  = $request->post('id_role');
    $user_id  = $request->post('id_user');
    $data_del = DB::table('role_user')->where('role_id', $role_id)->first();
    $where    = array(
      'role_id' => $role_id,
      'user_id' => $user_id
    );
    $delete   = DB::table('role_user')->where('role_id', $role_id)->where($where)->delete();
    if ($delete) {
      $response = Response::json([
        'code'        => 200,
        'status'      => "error",
        'message'     => "Role sukses dihapus.",
        'data'        => $data_del
      ], 200);

      //SAVE TO LOG
      \LogActivity::addToLog('DELETED', $response);

      return $response;
    } else {
      $response = Response::json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Role gagal dihapus.",
        'data'        => $data_del
      ], 500);

      //SAVE TO LOG
      \LogActivity::addToLog('DELETED', $response);

      return $response;
    }
  }

  function get_role(Request $request)
  {
    $role     = DB::table('roles')->select('*')->get();
    $id_user  = $request->post('id_user');
    $list     = '';
    foreach ($role as $r) {
      $roles_id  = $r->id;
      $data_role = DB::table('role_user')
        ->join('roles as b', 'role_user.role_id', '=', 'b.id')
        ->selectRaw('b.name, b.id, role_user.role_id')
        ->where('role_user.user_id', $id_user)
        ->where('b.id', $roles_id)
        ->first();
      if ($data_role === null) {
        $param_role = "'" . $id_user . "', '" . $r->id . "'";
        $list .= '<div class="col-md-3 m-b-10">
                    <button class="btn btn-secondary btn-block btn-sm text-left" 
                      onclick="save_role(' . $param_role . ')" 
                      title="Tambahkan Roles => ' . ucwords($r->name) . '">
                      <i class="icofont icofont-ui-add"></i>' . $r->name . '
                    </button>
                  </div>';
      } else {
        $list .= '<div class="col-md-3 m-b-10">
                    <button class="btn btn-success btn-block btn-sm text-left" 
                      title="Role => ' . ucwords($r->name) . ' sudah diambil">
                      <i class="icofont icofont-ui-check"></i>' . $r->name . '
                    </button>
                  </div>';
      }
    }

    echo json_encode("<div class='row'>$list</div>");
  }

  function save_role(Request $request)
  {
    $id_user = $request->post('id_user');
    $role_id = $request->post('role_id');
    $check = DB::table('role_user')
      ->select("*")
      ->where('role_id', $role_id)
      ->where('user_id', $id_user)
      ->count();
    if ($check == 0) {

      $data = array(
        'role_id'   => $request->post('role_id'),
        'user_id'   => $request->post('id_user')
      );

      $insert = DB::table('role_user')->insert($data);
      if ($insert) {
        $response = Response::json([
          'code'        => 200,
          'status'      => "success",
          'message'     => "Role sukses didaftarkan."
        ], 200);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      } else {
        $response = Response::json([
          'code'        => 400,
          'status'      => "error",
          'message'     => "Role gagal didaftarkan."
        ], 400);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      }
    } else {
      $response = Response::json([
        'code'        => 409,
        'status'      => "error",
        'message'     => "Role sudah terdaftar."
      ], 409);

      //SAVE TO LOG
      \LogActivity::addToLog('ADD', $response);

      return $response;
    }
  }
}
