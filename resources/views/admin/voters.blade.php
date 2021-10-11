<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Voters - SSG ADMIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ url('static/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('admin.components.navbar')
  <!-- /.navbar -->

  @include('admin.components.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Voters</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Voters</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">

      @if(Session::has('message'))
        @php
          $message = Session::get('message');
        @endphp
        <div class="alert alert-{{ str_contains(strtolower($message),'successfully') ? 'success' : 'danger' }}" role="alert">
          {{ $message }}
        </div>
      @endif
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-end">
                  <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#add">Add Voter</button>
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#import-csv">Import CSV</button>
                  <button type="button" class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#reset">Reset</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th># ID</th>
                    <th>Learner Reference Number</th>
                    <th>Full Name</th>
                    <th>Grade Level</th>
                    <th>Section</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('admin.components.footer')

</div>

<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit voter</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.voters.edit') }}">
        <div class="modal-body">
          @csrf
          <input type="hidden" id="edit_id" name="id">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
          </div>
          <div class="form-group">
            <label for="grade_level">Grade Level</label>
            <input type="number" class="form-control" id="grade_level" name="grade_level" placeholder="Enter grade level" required>
          </div>
          <div class="form-group">
            <label for="section">Section</label>
            <input type="text" class="form-control" id="section" name="section" placeholder="Enter section" required>
          </div>
          <div class="form-group">
            <label for="lrn">Learner Reference Number</label>
            <input type="text" class="form-control" id="lrn" name="lrn" placeholder="Enter Learner Reference Number" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add voter</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.voters.add') }}">
        <div class="modal-body">
          @csrf

          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
          </div>
          <div class="form-group">
            <label for="grade_level">Grade Level</label>
            <input type="number" class="form-control" id="grade_level" name="grade_level" placeholder="Enter grade level" required>
          </div>
          <div class="form-group">
            <label for="section">Section</label>
            <input type="text" class="form-control" id="section" name="section" placeholder="Enter section" required>
          </div>
          <div class="form-group">
            <label for="lrn">Learner Reference Number</label>
            <input type="text" class="form-control" id="lrn" name="lrn" placeholder="Enter Learner Reference Number" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="import-csv">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import CSV Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.voters.csv') }}"  enctype="multipart/form-data">
        <div class="modal-body">
          @csrf

          <div class="form-group">
            <label for="csv">CSV File</label>
            <input type="file" class="form-control" id="csv" name="csv" accept=".csv" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- ./wrapper -->

<div class="modal fade" id="reset">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete all voters</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.voters.reset') }}" >
        @csrf
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Reset</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- jQuery -->
<script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('plugins/sparklines/sparkline.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ url('static/js/adminlte.js') }}"></script>

<script>
  $(function () {

    const table = $('#table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": `{{ route('admin.voters.list') }}`,
      "columns": [
        {data: 'id'},
        {data: 'lrn'},
        {data: 'name'},
        {data: 'grade_level'},
        {data: 'section'},
        {defaultContent: '<button class="btn btn-info btn-sm editData">Edit</button> <button class="btn btn-danger btn-sm deleteData">Delete</button>' }
      ]
    });

    $('#table tbody').on('click', '.editData', function () {
        var row = $(this).closest('tr');
 
        const id = table.row( row ).data()["id"];

        $.ajax({
          url: "{{ route('admin.voters.show') }}",
          type: "GET",
          data: { id },
          dataType: "json"
        }).done(function(res) {
          $('#name').val(res.name)
          $('#grade_level').val(res.grade_level)
          $('#section').val(res.section)
          $('#lrn').val(res.lrn)
          $('#edit_id').val(id)
        }).fail(function(err) {
          console.log(err)
        })

        $('#edit').modal('toggle')
    });

    $('#table tbody').on('click', '.deleteData', function () {
        var row = $(this).closest('tr');
        var id = table.row( row ).data()["id"];
        window.location.href = `{{ route('admin.voters.delete') }}/${id}?token={{ csrf_token() }}&redirect_uri=${window.location.href}`
    });
  });
</script>

</body>
</html>
