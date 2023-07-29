@extends('layouts.master')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->

<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@extends('layouts.nav')
@extends('layouts.navmenu')
@section('content')
<!-- Pre-loader end -->
<div id="pcoded" class="pcoded">
  {{-- <div class="pcoded-overlay-box"></div> --}}
  <div class="pcoded-container navbar-wrapper">
    {{-- <div class="pcoded-main-container"> --}}
    <div class="pcoded-wrapper">

      <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-8">
                <div class="page-header-title">
                  <h5 class="m-b-10">List Jenis Surat</h5>
                  <hr>
                </div>
              </div>
              <div class="col-md-4">
                <ul class="breadcrumb-title">
                  <li class="breadcrumb-item">
                    <a href="{{url('home')}}"> <i class="fa fa-home"></i> </a>
                  </li>
                  <li class="breadcrumb-item"><a href="{{url('jenis_surat')}}">Jenis Surat</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- Page-header end -->
        <div class="pcoded-inner-content">
          <!-- Main-body start -->
          <div class="main-body">
            <div class="page-wrapper">
              <!-- Page-body start -->
              <div class="page-body">
                <!-- Basic table card start -->
                <div class="card">
                  <div class="card-header bg-primary">
                    <h5 class="text-light">Jenis Surat</h5>
                    {{-- <div class="card-header-right"> --}}

                    <button class="btn btn-warning float-right" style="@if($user->hasPermission('add_jenis_surat')!=true){{'display:none;'}}@endif" data-toggle="modal" data-target="#mdl_add"><span class="fa fa-plus text-light"></span></button>
                    {{-- </div> --}}
                  </div>
                  <div class="card-block table-border-style">
                    <div class="table-responsive">
                      <table class="table" id="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Kode Jenis</th>
                            <th>Nama</th>
                            <th>Unit</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="list">

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
              <!-- Page-body end -->
            </div>
          </div>
          <!-- Main-body end -->
          {{-- start modal add user  --}}
          <div class="modal fade" id="mdl_add" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Jenis Surat</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ">

                  <div class="card-block">
                    <form id="fsave" method="post">
                      <div class="form-group form-primary">
                        <label class="float-label">Kode Jenis </label>
                        <input type="text" name="kd_jenis" id="kd_jenis" class="form-control" required>
                        <span class="form-bar"></span>

                      </div>
                      <div class="form-group form-primary">
                        <label class="float-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                        <span class="form-bar"></span>

                      </div>
                      <div class="form-group form-primary">
                        <label class="float-label">Kd Unit</label>
                        <select class="form-control" id="kd_unit" name="kd_unit">
                          <option value="">Pilih Unit</option>
                          @foreach($unit as $u)
                          <option value="{{$u->id}}">{{$u->nama_unit}}</option>
                          @endforeach
                        </select>
                        <span class="form-bar"></span>

                      </div>

                    </form>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" onclick="save();">Save changes</button>
                </div>
              </div>
            </div>
          </div>
          {{-- end modal add user  --}}
          {{-- start modal edit Role  --}}
          <div class="modal fade" id="mdl_edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Edit Unit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ">

                  <div class="card-block">
                    <form id="fsave_edit" method="post">
                      <div class="form-group form-primary">
                        <label class="float-label">Kd Unit </label>
                        <input type="text" name="kd_unit_edit" id="kd_unit_edit" class="form-control" required>
                        <input type="hidden" name="id_edit" id="id_edit" class="form-control">
                        <span class="form-bar"></span>

                      </div>
                      <div class="form-group form-primary">
                        <label class="float-label">Nama Unit</label>
                        <input type="text" name="nama_unit_edit" id="nama_unit_edit" class="form-control" required>
                        <span class="form-bar"></span>

                      </div>

                    </form>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" onclick="save_edit();">Save changes</button>
                </div>
              </div>
            </div>
          </div>
          {{-- end modal edit role  --}}
          {{-- start modal add role  --}}
          <div class="modal fade" id="mdl_add_role" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Permission Role <b id="iduser_role"></b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ">

                  <div class="card-block" id="list_role"></div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          {{-- end modal add role   --}}
          <div id="styleSelector">

          </div>
        </div>
      </div>
    </div>
    {{-- </div> --}}
  </div>
</div>

@endsection
@section('script')


<script>
  var host = "{{URL::to('/')}}";
  $(document).ready(function() {
    // $('#user').DataTable();
    get_list();

  });

  function get_list() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#table').DataTable({
      "searching": true,
      "destroy": true,
      "ajax": {

        "url": host + '/jenis_surat/get_list',
        "type": "POST",
        "data": {
          _token: CSRF_TOKEN
        }
      },
    });

  }

  function save() {
    if ($('#kd_jenis').val() == '') {
      bootbox.alert('<b style="color:red">KD Jenis Tidak Boleh Kosong</b>');
      $('#kd_jenis').focus();
      return false;

    }
    if ($('#nama').val() == '') {
      bootbox.alert('<b style="color:red">Nama Unit Tidak Boleh Kosong</b>');
      $('#nama').focus();
      return false;

    }
    if ($('#kd_unit').val() == '') {
      bootbox.alert('<b style="color:red">KD Unit Tidak Boleh Kosong</b>');
      $('#kd_unit').focus();
      return false;

    }



    var formnya = $('#fsave')[0];
    bootbox.alert(formnya);
    return false;
    var data = new FormData(formnya);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    data.append('_token', CSRF_TOKEN);


    $.ajax({
      type: "post",
      url: host + '/jenis_surat/save',
      data: data,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {

        bootbox.alert(response.msg)
        if (response.code == 1) {

          $('#mdl_add').modal('hide');
          get_list();
        }
      }
    });
  }

  function delete_unit(id) {
    bootbox.confirm({
      message: "Apakah Anda Yakin Akan Menghapus Unit Ini ?",
      buttons: {
        confirm: {
          label: 'Ya',
          className: 'btn-success'
        },
        cancel: {
          label: 'Tidak',
          className: 'btn-danger'
        }
      },
      callback: function(result) {
        if (result == true) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
            type: "post",
            url: host + '/unit/delete_unit',
            data: {
              _token: CSRF_TOKEN,
              id: id
            },

            dataType: "json",
            success: function(response) {

              bootbox.alert(response.msg);
              get_list();

              // if(response.code==1){

              //     $('#mdl_add').modal('hide');
              //     get_list();
              // }
            }
          });
        }
        // console.log('This was logged in the callback: ' + result);
      }
    });
  }

  function add_role(id_user, nama_user) {
    $('#iduser_role').text(nama_user);
    $('#mdl_add_role').modal('show');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: "post",
      url: host + '/role/get_permission',
      data: {
        _token: CSRF_TOKEN,
        id_user: id_user
      },

      dataType: "json",
      success: function(response) {
        $('#list_role').html(response);

      }
    });
  }

  function save_edit() {
    if ($('#kd_unit_edit').val() == '') {
      bootbox.alert('<b style="color:red">KD Unit Tidak Boleh Kosong</b>');
      $('#nama_edit').focus();
      return false;

    }
    if ($('#nama_unit_edit').val() == '') {
      bootbox.alert('<b style="color:red">Nama Unit Tidak Boleh Kosong</b>');
      $('#display_name_edit').focus();
      return false;

    }


    var formnya = $('#fsave_edit')[0];
    var data = new FormData(formnya);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    data.append('_token', CSRF_TOKEN);


    $.ajax({
      type: "post",
      url: host + '/unit/save_edit',
      data: data,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {

        bootbox.alert(response.msg)
        if (response.code == 1) {

          $('#mdl_edit').modal('hide');
          get_list();
        }
      }
    });
  }

  function edit(id, kd_unit, nama_unit) {
    $('#id_edit').val(id);
    $('#kd_unit_edit').val(kd_unit);
    $('#nama_unit_edit').val(nama_unit);
    $('#mdl_edit').modal('show');
  }

  function save_role(id_user, role_id) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: "post",
      url: host + '/role/save_permission',
      data: {
        _token: CSRF_TOKEN,
        id_user: id_user,
        role_id: role_id
      },

      dataType: "json",
      success: function(response) {
        bootbox.alert(response.msg);
        get_list();


      }
    });
  }
</script>
@endsection