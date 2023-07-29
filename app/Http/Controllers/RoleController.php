<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Response;

class RoleController extends Controller
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
    $halaman        = "Daftar Roles";
    $breadcrumbs    = "Roles";

    return view('user.role', compact('user', 'halaman', 'group_halaman', 'breadcrumbs'));
  }

  function get_list(Request $request)
  {
    $roles = DB::table('roles')
      ->select('*')
      ->orderByDesc('id')
      ->get();

    $data = array();
    $no = 0;
    foreach ($roles as $r) {
      $permission = DB::table('permission_role as a')
        ->join('permissions as b', 'a.permission_id', '=', 'b.id')
        ->selectRaw('b.description,a.permission_id,a.role_id')
        ->where('a.role_id', $r->id)
        ->get();
      $no             = $no + 1;
      $permissionnya  = '';
      $param_role     = $r->id . ', ' . '"' . $r->name . '"';
      $btntambah      = "<button style='font-size:10px;' class='btn btn-warning btn-sm' onclick='add_role($param_role)' title='Tambahkan permission => " . $r->name . "'><i class='icofont icofont-ui-add mr-2'></i>Permission</button>";
      foreach ($permission as $rp) {
        $paramdel = "$r->id,$rp->permission_id";
        $permissionnya = $permissionnya . "<div class='btn-group m-1' role='group' aria-label='Basic example'>
                                              <button type='button' class='btn btn-secondary btn-sm'>$rp->description</button>
                                              <button type='button' class='btn btn-danger btn-sm' onclick='hapus_role($paramdel)' title='Hapus permission => " . ucwords($rp->description) . "'><i class='icofont icofont-ui-delete'></i></button>
                                           </div>";
      }

      $paramedit = $r->id . ', ' . '"' . $r->name . '"' . ', ' . '"' . $r->display_name . '"' . ', ' . '"' . $r->description . '"';

      $row      = array();
      $row[]    = $no;
      $row[]    = "<button class='btn btn-info btn-sm mr-2' onclick='edit_data($paramedit)' title='Edit'>
                    <i class='icofont icofont-ui-edit'></i>
                  </button>
                  <button class='btn btn-danger btn-sm' onclick='hapus_data($r->id)' title='Hapus'>
                    <i class='icofont icofont-ui-close'></i>
                  </button>";
      $row[]    = $r->name . " " . $r->id;
      $row[]    = $r->description;
      $row[]    = "<table class='table'><tr><td>" . $btntambah . "</td><td style='word-wrap: break-word;min-width: 100%;max-width:100%;white-space:normal;'>" . $permissionnya . "</td></tr></table>";
      $data[]   = $row;
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
          'error_string'  => $validator->errors()->all(),
          'inputerror'    => $validator->errors()->keys()
        ]
      );
    }

    $nama = str_replace(' ', '_', $request->post('nama'));
    $data = array(
      'name'          => $nama,
      'display_name'  => $request->post('display_name'),
      'description'   => $request->post('description')
    );

    $check = DB::table('roles')->select('*')->where('name', $nama)->count();
    if ($check == 0) {
      $insert = DB::table('roles')->insert($data);
      if ($insert) {
        $response = Response::json([
          'code'        => 200,
          'status'      => "error",
          'message'     => "Data sukses didaftarkan.",
          'data'        => $data
        ], 201);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      } else {
        $response = Response::json([
          'code'        => 500,
          'status'      => "error",
          'message'     => "Data gagal didaftarkan.",
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
        'message'     => "Data sudah terdaftar.",
        'data'        => $data
      ], 409);

      //SAVE TO LOG
      \LogActivity::addToLog('ADD', $response);

      return $response;
    }
  }

  function save_edit(Request $request)
  {
    $nama     = str_replace(' ', '_', $request->post('nama'));
    $id       = $request->post('id');
    $old_data = DB::table('roles')->where('id', $id)->first();
    $data     = array(
      'name'          => $nama,
      'display_name'  => $request->post('display_name'),
      'description'   => $request->post('description')
    );

    $update = DB::table('roles')->where('id', $id)->update($data);
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
        'message'     => "Data gagal diupdate.",
        'data'        => $data
      ], 500);

      //SAVE TO LOG
      \LogActivity::addToLog('UPDATED', $response, json_encode($old_data));

      return $response;
    }
  }

  function del_permission(Request $request)
  {
    $role_id        = $request->post('id_role');
    $permission_id  = $request->post('id_permission');
    $where_del      = array('role_id' => $role_id, 'permission_id' => $permission_id);
    $data_del       = DB::table('permission_role')->where($where_del)->first();
    $where          = array('role_id' => $role_id, 'permission_id' => $permission_id);
    $delete         = DB::table('permission_role')->where($where)->delete();

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

  function del_role_permission(Request $request)
  {
    $role_id  = $request->post('id');
    $data_del = DB::table('roles')->where('id', $role_id)->first();
    $where    = array('id' => $role_id);
    $delete   = DB::table('roles')->where($where)->delete();
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
    $id_user  = $request->post('id_user');
    $role     = DB::table('permissions')->select('*')->get();
    $list     = '';
    foreach ($role as $key => $r) {
      $permission_id  = $r->id;
      $permission     = DB::table('permission_role as a')
        ->join('permissions as b', 'b.id', '=', 'a.permission_id')
        ->join('roles as c', 'c.id', '=', 'a.role_id')
        ->selectRaw('b.description, a.permission_id, a.role_id, b.id, c.name')
        ->where('a.role_id', $id_user)
        ->where('a.permission_id', $permission_id)
        ->first();

      if ($permission === null) {
        //echo $key . " - " . $r->description . " gak sama <br>";
        $param_role = $request->post('id_user') . ', ' . $r->id;
        $list .= "<div class='col-md-3 m-b-10'>
                    <button class='btn btn-secondary btn-block btn-sm text-left' onclick='save_role($param_role)' title='Tambahkan Roles => " . ucwords($r->description) . "'>
                      <i class='icofont icofont-ui-add'></i> $r->description
                    </button>
                  </div>";
      } else {
        //echo $key . " - " . $r->description . " ============= sama <br>";
        $list .= '<div class="col-md-3 m-b-10">
                    <button class="btn btn-success btn-block btn-sm text-left" title="Roles => ' . ucwords($r->description) . ' sudah ditambahkan">
                    <i class="icofont icofont-ui-check"></i> ' . $r->description . '
                    </button>
                  </div>';
      }
    }

    echo json_encode("<div class='row justify-content-center'>$list</div>");
  }

  function save_permission(Request $request)
  {
    $role_id        = $request->post('id_user');
    $permission_id  = $request->post('role_id');
    $check = DB::table('permission_role')
      ->select("*")
      ->where('permission_id', $permission_id)
      ->where('role_id', $role_id)
      ->count();
    if ($check > 0) {
      $response = Response::json([
        'code'        => 409,
        'status'      => "error",
        'message'     => "Roles sudah terdaftar.",
        'data'        => $data
      ], 409);

      //SAVE TO LOG
      \LogActivity::addToLog('ADD', $response);

      return $response;
    } else {

      $data   = array('role_id' => $role_id, 'permission_id' => $permission_id);
      $insert = DB::table('permission_role')->insert($data);
      if ($insert) {
        $response = Response::json([
          'code'        => 200,
          'status'      => "success",
          'message'     => "Data sukses didaftarkan.",
          'data'        => $data
        ], 201);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      } else {
        $response = Response::json([
          'code'        => 500,
          'status'      => "error",
          'message'     => "Data gagal didaftarkan.",
          'data'        => $data
        ], 500);

        //SAVE TO LOG
        \LogActivity::addToLog('ADD', $response);

        return $response;
      }
    }
  }
}
