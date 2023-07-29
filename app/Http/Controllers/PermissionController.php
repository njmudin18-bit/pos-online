<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Response;

class PermissionController extends Controller
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
    $group_halaman  = "Roles & Permissions";
    $halaman        = "Daftar Permissions";
    $breadcrumbs    = "Permissions";

    return view('user.permission', compact('user', 'halaman', 'group_halaman', 'breadcrumbs'));
  }

  function get_list(Request $request)
  {
    $roles = DB::table('permissions')
      ->select('*')
      ->orderByDesc('id')
      ->get();
    $data = array();
    $no = 0;
    foreach ($roles as $r) {
      $no = $no + 1;

      $parameter = $r->id . ', ' . '"' . $r->name . '"' . ', ' . '"' . $r->display_name . '"' . ', ' . '"' . ucwords($r->description) . '"';
      $row    = array();
      $row[]  = $no;
      $row[]  = "<button class='btn btn-info btn-sm mr-2' onclick='edit_data($parameter)' title='Edit'><i class='icofont icofont-ui-edit'></i></button><button class='btn btn-danger btn-sm' onclick='hapus_data($r->id)' title='Hapus'><i class='icofont icofont-ui-close'></i></button>";
      $row[]  = $r->name;
      $row[]  = $r->display_name;
      $row[]  = ucwords($r->description);
      $data[] = $row;
    }

    echo json_encode(array("data" => $data));
  }

  function save(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'nama'          => 'required|min:3',
      'display_name'  => 'required|min:3',
      'description'   => 'required|min:3',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'error_string' => $validator->errors()->all(),
          'inputerror' => $validator->errors()->keys()
        ]
      );
    }

    $nama   = str_replace(' ', '_', $request->post('nama'));
    $data = array(
      'name'          => $nama,
      'display_name'  => $request->post('display_name'),
      'description'   => $request->post('description')
    );

    $check  = DB::table('permissions')->select('*')->where('name', $nama)->count();
    if ($check == 0) {
      $insert = DB::table('permissions')->insert($data);
      if ($insert) {
        $response = Response::json([
          'code'        => 200,
          'status'      => "error",
          'message'     => "Data sukses " . $nama . " didaftarkan.",
          'data'        => $data
        ], 201);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      } else {
        $response = Response::json([
          'code'        => 500,
          'status'      => "error",
          'message'     => "Data gagal " . $nama . " didaftarkan.",
          'data'        => $data
        ], 500);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      }
    } else {
      $response = Response::json([
        'code'        => 409,
        'status'      => "error",
        'message'     => "Data " . $nama . " sudah terdaftar.",
        'data'        => $data
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
      'nama'          => 'required|min:3',
      'display_name'  => 'required|min:3',
      'description'   => 'required|min:3',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'error_string' => $validator->errors()->all(),
          'inputerror' => $validator->errors()->keys()
        ]
      );
    }

    $nama     = str_replace(' ', '_', $request->post('nama'));
    $id       = $request->post('id');
    $old_data = DB::table('permissions')->where('id', $id)->first();
    $data     = array(
      'name'          => $nama,
      'display_name'  => $request->post('display_name'),
      'description'   => $request->post('description')
    );

    $update = DB::table('permissions')->where('id', $id)->update($data);
    if ($update) {
      $response = Response::json([
        'code'        => 200,
        'status'      => "error",
        'message'     => "Data sukses " . $nama . " diupdate.",
        'data'        => $data
      ], 200);

      //SAVE TO LOG
      \LogActivity::addToLog('UPDATED', $response, json_encode($old_data));

      return $response;
    } else {
      $response = Response::json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal " . $nama . " diupdate.",
        'data'        => $data
      ], 500);

      //SAVE TO LOG
      \LogActivity::addToLog('UPDATED', $response, json_encode($old_data));

      return $response;
    }
  }

  function del_role_permission(Request $request)
  {
    $role_id  = $request->post('id');
    $data_del = DB::table('permissions')->where('id', $role_id)->first();
    $where    = array('id' => $role_id);
    $delete   = DB::table('permissions')->where($where)->delete();
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
    }
  }

  function get_permission(Request $request)
  {
    $role = DB::table('permissions')->select('*')->get();
    $list = '';
    foreach ($role as $r) {
      $param_role = $request->post('id_user') . ', ' . $r->id;
      $list = $list . "<button class='btn btn-success m-2' onclick='save_role($param_role)'><i class='fa fa-check'></i> Add Role $r->name</button>";
    }


    echo json_encode("<div class='row'>$list</div>");
  }

  function save_permission(Request $request)
  {
    $role_id = $request->post('id_user');
    $permission_id = $request->post('role_id');
    $check = DB::table('permission_role')
      ->select("*")
      ->where('permission_id', $permission_id)
      ->where('role_id', $role_id)
      ->count();
    if ($check > 0) {
      $datas = array("msg" => "<b style='color:red'>Role Sudah Terdaftar </b>", "code" => 0);
      echo json_encode($datas);
      exit;
    } else {
      $data = array('role_id' => $role_id, 'permission_id' => $permission_id);
      $insert = DB::table('permission_role')->insert($data);
      if ($insert) {
        $datas = array("msg" => "<b style='color:green'>Alhamdulillah Sukses Insert</b>", "code" => 1);
      } else {
        $datas = array("msg" => "<b style='color:red'>Astagfirullah Gagal Insert</b>", "code" => 0);
      }
      echo json_encode($datas);
    }
  }
}
