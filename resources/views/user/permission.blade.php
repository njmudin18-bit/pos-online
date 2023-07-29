<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ $halaman }} - {{ config('constants.data.apps_name') }}</title>
  <!-- CSS START -->
  <x-css-datatable />
  <!-- CSS END -->
</head>

<body>

  <!-- LOADER START -->
  <x-loader-bar />
  <!-- LOADER START -->

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

      <!-- TOP MENU START -->
      <x-nav-bar />
      <!-- TOP MENU END -->

      <div class="pcoded-main-container">
        <div class="pcoded-wrapper">

          <!-- SIDE MENU START -->
          @include('layouts.sidebar')
          <!-- SIDE MENU END -->

          <div class="pcoded-content">
            <div class="pcoded-inner-content">

              <div class="main-body">
                <div class="page-wrapper">

                  <div class="page-header">
                    <div class="row align-items-end">
                      <div class="col-lg-8">
                        <div class="page-header-title">
                          <div class="d-inline">
                            <h4>{{ $halaman }}</h4>
                            <span>{{ $group_halaman }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="page-header-breadcrumb">
                          <ul class="breadcrumb-title">
                            <li class="breadcrumb-item" style="float: left;">
                              <a href="{{ url('/home') }}"> <i class="feather icon-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item" style="float: left;">
                              <a href="#">{{ $group_halaman }}</a>
                            </li>
                            <li class="breadcrumb-item" style="float: left;">
                              <a href="#">{{ $breadcrumbs }}</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="page-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <div class="card">
                          <div class="card-header text-center">
                            <h5 style="width: 100%;">
                              {{ strtoupper($halaman) }}
                              <span class="float-right">
                                <button type="button" onclick="openModal()" class="btn btn-grd-info text-white">
                                  <i class="icofont icofont-ui-add"></i>
                                  TAMBAH
                                </button>
                              </span>
                            </h5>
                            <hr>
                          </div>
                          <div class="card-block">
                            <div class="dt-responsive table-responsive">
                              <table id="tables" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                  <tr class="bg-primary">
                                    <th class="text-center">No.</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Display Name</th>
                                    <th class="text-center">Description</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div id="styleSelector">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" aria-label="Close" onclick="reset_all()">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" style="display:none"></div>
          <form id="form_data">
            <input type="hidden" value="" id="kode" name="kode">
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Permission Name</label>
              <div class="col-sm-8">
                <input type="text" name="nama" id="nama" class="form-control" required="required" autocomplete="off">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Display Name</label>
              <div class="col-sm-8">
                <input type="text" id="display_name" name="display_name" class="form-control" required="required" autocomplete="off">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <input type="text" id="description" name="description" class="form-control" required="required" autocomplete="off">
                <span class="help-block"></span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-outline-danger waves-effect md-trigger" onclick="reset_all()">Close</button>
          <button id="savedata" type="button" class="btn btn-primary waves-effect waves-light" onclick="save()">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div id="loading" class="loading">Loading&#8230;</div>

  <!-- JS START -->
  <x-js-datatable />
  <!-- JS END -->
</body>
<script>
  var save_method;
  var url;
  var host = "{{ URL::to('/') }}";
  var token = '{{ csrf_token() }}';

  //RESET ALL
  function reset_all() {
    $('#modal').modal('hide');
  }

  //FUNCTION UPDATE DATA
  function hapus_data(id) {
    console.log(id);
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data yang dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, hapus',
      cancelButtonText: 'Tidak, Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          data: {
            "id": id,
            "_token": token
          },
          url: host + "/permission/del_role_permission",
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            reload_table();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire(
              'Oops...',
              jqXHR.responseJSON.message,
              textStatus
            );
          }
        });
      }
    })
  }

  //FUNCTION EDIT DATA
  function edit_data(id, permission_name, display_name, description) {
    save_method = 'update';
    $('#form_data')[0].reset();
    $(".form-group>div").removeClass("has-error");
    $('.help-block').empty();

    $('[name="kode"]').val(id);
    $('[name="nama"]').val(permission_name);
    $('[name="display_name"]').val(display_name);
    $('[name="description"]').val(description);

    $('#modal').modal('show');
    $('.modal-title').text('Edit Permissions');
    $('#savedata').text('Update');
  }

  //FUNCTION OPEN MODAL CABANG
  function openModal() {
    save_method = 'add';
    $("#pass_div").show();
    $('#savedata').text('Simpan');
    $('#form_data')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Permissions'); // Set Title to Bootstrap modal title
    $(".form-group").parent().find('div').removeClass("has-error");
  }

  //VALIDATION AND ADD USER
  function save() {
    var nama = $("#nama").val();
    var display_name = $("#display_name").val();
    var description = $("#description").val();
    var kode = $("#kode").val();

    if (save_method == 'add') {
      url = host + "/permission/save";
    } else {
      url = host + "/permission/save_edit";
    }

    $.ajax({
      data: {
        "nama": nama,
        "display_name": display_name,
        "description": description,
        "id": kode,
        "_token": token
      },
      url: url,
      type: "POST",
      dataType: 'JSON',
      beforeSend: function(data) {
        $("#loading").show();
      },
      success: function(data) {
        if (data.code == 200) {
          reload_table();
          $('#modal').modal('hide');
        } else if (data.code == 500) {
          Swal.fire(
            'Oops...',
            data.message,
            'error'
          );
          $('#modal').modal('hide');
        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            console.log(data.inputerror[i]);
            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
          }
        }
        $('#savedata').html('Simpan');
        $("#loading").hide();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#loading").hide();
        $('#modal').modal('hide');
        Swal.fire(
          'Oops...',
          jqXHR.responseJSON.message,
          textStatus
        );
        $('#savedata').html('Simpan');
      }
    });
  }

  //FUNCTION RELOAD TABLE
  function reload_table() {
    table.ajax.reload(null, false);
  }

  $(document).ready(function() {
    $("#loading").hide();

    table = $("#tables").DataTable({
      searching: true,
      responsive: true,
      select: {
        style: "multi"
      },
      ajax: {
        url: host + "/permission/get_list",
        type: "POST",
        data: {
          "_token": token
        }
      },
      "aoColumns": [{
          "No": "No",
          "sClass": "text-right"
        },
        {
          "#": "#",
          "sClass": "text-center"
        },
        {
          "Nama": "Nama",
          "sClass": "text-left"
        },
        {
          "Display Name": "Display Name",
          "sClass": "text-left"
        },
        {
          "Description": "Description",
          "sClass": "text-left"
        }
      ],
    });

    $("#nama").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#display_name").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

    $("#description").change(function() {
      $(this).parent().removeClass('has-error');
      $(this).next().empty();
    });

  });
</script>

</html>