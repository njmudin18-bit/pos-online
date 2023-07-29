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
                            <h5 style="width: 100%;">{{ strtoupper($halaman) }}</h5>
                            <hr>
                          </div>
                          <div class="card-block">
                            <div class="dt-responsive table-responsive">
                              <table id="tables" class="table table-striped table-bordered nowrap" width="110%">
                                <thead>
                                  <tr class="bg-primary">
                                    <th class="text-center">No.</th>
                                    <th class="text-center">No. Bukti</th>
                                    <!-- <th class="text-center">Nama</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Role</th> -->
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

  <div id="loading" class="loading">Loading&#8230;</div>

  <!-- JS START -->
  <x-js-datatable />
  <!-- JS END -->
</body>
<script>
  var token = '{{ csrf_token() }}';
  var host = "{{ URL::to('/') }}";

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
        url: host + "/po/get_list",
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
          "No. Bukti": "No. Bukti",
          "sClass": "text-left"
        }
        // {
        //   "Nama": "Nama",
        //   "sClass": "text-left"
        // },
        // {
        //   "Email": "Email",
        //   "sClass": "text-left"
        // },
        // {
        //   "Role": "Role",
        //   "sClass": "text-left"
        // }
      ],
    });

  });
</script>

</html>