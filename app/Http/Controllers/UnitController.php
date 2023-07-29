<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UnitController extends Controller
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
        $user = Auth::user();
       // $view_user = $user->hasPermission('view_user');

        return view('master.unit',compact('user'));
    }
    function get_list(Request $request){
        $roles = DB::table('unit')
                ->select('*')
                ->get();

        $data = array();
        $no = 0;
        foreach($roles as $r){
            $no=$no+1;

            $paramedit = $r->id.','.'"'.$r->kd_unit.'"'.','.'"'.$r->nama_unit.'"';
            $row = array();
            $row[] = $no;
            $row[] = $r->kd_unit;
            $row[] = $r->nama_unit;
            // $row[] = "<table class='table'><tr><td>".$btntambah."</td><td style='word-wrap: break-word;min-width: 100%;max-width:100%;white-space:normal;'>".$permissionnya."</td></tr></table>";
            $row[] = "<button class='btn btn-primary' onclick='edit($paramedit)'>Edit</button><button class='btn btn-danger' onclick='delete_unit($r->id)'>Delete</button>";
            $data[] = $row;
        }

        echo json_encode(array("data"=>$data));

    }
    function save(Request $request){
        // $data = $request->input->all();
        $data = array(
            'kd_unit'=>$request->post('kd_unit'),
            'nama_unit'=>$request->post('nama_unit')
        );

        $check = DB::table('unit')->select('*')->where('kd_unit',$request->post('kd_unit'))->count();
        if($check>0){
            $datas =array("msg"=>"<b style='color:red'>Unit Sudah Terdaftar </b>","code"=>0);
            echo json_encode($datas);exit;
        }
        $insert = DB::table('unit')->insert($data);
        if($insert){
            $datas =array("msg"=>"<b style='color:green'>Alhamdulillah Sukses Insert</b>","code"=>1);
        }else{
            $datas =array("msg"=>"<b style='color:red'>Astagfirullah Gagal Insert</b>","code"=>0);
        }
        echo json_encode($datas);

    }
    function save_edit(Request $request){
        // $data = $request->input->all();
        $id = $request->post('id_edit');
        $data = array(
            'kd_unit'=>$request->post('kd_unit_edit'),
            'nama_unit'=>$request->post('nama_unit_edit')
        );

        $update = DB::table('unit')->where('id',$id)->update($data);
        if($update){
            $datas =array("msg"=>"<b style='color:green'>Alhamdulillah Sukses Update</b>","code"=>1);
        }else{
            $datas =array("msg"=>"<b style='color:red'>Astagfirullah Gagal Update</b>","code"=>0);
        }
        echo json_encode($datas);

    }
    function delete(Request $request){
        $id = $request->post('id');

        $where = array('id'=>$id);
        $delete = DB::table('unit')->where($where)->delete();

        if($delete){
            $datas = array("msg"=>"<b style='color:green'>Alhamdulillah Delete Sukses</b>","code"=>1);
        }else{
            $datas =array("msg"=>"<b style='color:red'>Astagfirullah Delete Gagal</b>","code"=>0);
        }
        echo json_encode($datas);
    }
    function get_permission(Request $request){
        $role = DB::table('permissions')->select('*')->get();
        $list = '';
        foreach($role as $r){
            $param_role =$request->post('id_user').', '.$r->id;
            $list = $list."<button class='btn btn-success m-2' onclick='save_role($param_role)'><i class='fa fa-check'></i> Add Role $r->name</button>";
        }


        echo json_encode("<div class='row'>$list</div>");

    }
    function save_permission(Request $request){
        $role_id = $request->post('id_user');
        $permission_id = $request->post('role_id');
        $check = DB::table('permission_role')
                ->select("*")
                ->where('permission_id',$permission_id)
                ->where('role_id',$role_id)
                ->count();
        if($check>0){
            $datas =array("msg"=>"<b style='color:red'>Role Sudah Terdaftar </b>","code"=>0);
            echo json_encode($datas);exit;
        }else{
            $data = array('role_id'=>$role_id,'permission_id'=>$permission_id);
            $insert = DB::table('permission_role')->insert($data);
            if($insert){
                $datas =array("msg"=>"<b style='color:green'>Alhamdulillah Sukses Insert</b>","code"=>1);
            }else{
                $datas =array("msg"=>"<b style='color:red'>Astagfirullah Gagal Insert</b>","code"=>0);
            }
            echo json_encode($datas);
        }


    }
}

