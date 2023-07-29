<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PoController extends Controller
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
    $user           = Auth::user();
    $unit           = DB::table('unit')
      ->select('*')
      ->get();
    $group_halaman  = "Purchase Order";
    $halaman        = "Daftar PO";
    $breadcrumbs    = "Daftar PO";

    return view('po.daftar_po', compact('user', 'unit', 'halaman', 'group_halaman', 'breadcrumbs'));
  }

  function get_list(Request $request)
  {
    $data_po = DB::table('tbl_po')
      ->select('*')
      //->orderByDesc('id')
      ->get();

    $data = array();
    $no   = 1;
    foreach ($data_po as $key => $result) {
      $row    = array();
      $row[]  = $no++;
      $row[]  = $result->NoBukti;
      // $row[]  = $result->NoBukti;
      // $row[]  = $result->NoBukti;
      // $row[]  = $result->NoBukti;

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
        return response()->json([
          'code'        => 200,
          'status'      => "success",
          'message'     => "Data sukses didaftarkan.",
          'data'        => $data
        ], 200);
      } else {
        return response()->json([
          'code'        => 400,
          'status'      => "error",
          'message'     => "Data gagal didaftarkan.",
          'data'        => $data
        ], 400);
      }
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data <strong>" . $email . "</strong> sudah terdaftar.",
        'data'        => $email
      ], 500);
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

    $id     = $request->post('id');
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
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data sukses diupdate.",
        'data'        => $data
      ], 200);
    } else {
      return response()->json([
        'code'        => 400,
        'status'      => "error",
        'message'     => "Data gagal diupdate.",
        'data'        => $data
      ], 400);
    }
  }

  function delete_user(Request $request)
  {
    $id       = $request->post('id');
    $email    = $request->post('email');
    $where    = array('id' => $id, 'email' => $email);
    $delete   = DB::table('users')->where($where)->delete();
    if ($delete) {
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data sukses dihapus."
      ], 200);
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal dihapus."
      ], 500);
    }
  }

  function del_role(Request $request)
  {
    $role_id  = $request->post('id_role');
    $user_id  = $request->post('id_user');
    $where    = array(
      'role_id' => $role_id,
      'user_id' => $user_id
    );
    $delete   = DB::table('role_user')->where('role_id', $role_id)->where($where)->delete();
    if ($delete) {
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Role sukses dihapus."
      ], 200);
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Role gagal dihapus."
      ], 500);
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
        return response()->json([
          'code'        => 200,
          'status'      => "success",
          'message'     => "Role sukses didaftarkan."
        ], 200);
      } else {
        return response()->json([
          'code'        => 400,
          'status'      => "error",
          'message'     => "Role gagal didaftarkan."
        ], 400);
      }
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Role sudah terdaftar."
      ], 500);
    }
  }
}
