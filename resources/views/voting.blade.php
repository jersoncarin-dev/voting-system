<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $setting->election_title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('static/css/adminlte.min.css') }}">
</head>
<style>
    .img-voter {
        max-width: 100px;
        max-height: 100px;
    }

    .img-voter img {
        display: block;
        max-width: 100%;
        height: auto;
        object-fit: contain;
    }
</style>
<body class="hold-transition layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">SSG VOTING</a>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ auth()->user()->name }}
                    <i class="fas fa-caret-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0 m-0">
                    <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-4 p-0 m-0 pb-5">
    <div class="container px-2 px-md-0">
        <!-- Main content -->
        <section class="content">
            @if(Session::has('message'))
                @php
                    $message = Session::get('message');
                @endphp
                <div @class([
                    'alert',
                    'alert-danger' => str_contains($message,'candidates'),
                    'alert-success' => str_contains($message,'submitted')
                ]) role="alert">
                    <h4 class="m-0 p-0">{{ Session::get('message') }}</h4>
                </div>
            @endif
            @if($vote->isNotEmpty())
                @if(!Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="m-0 p-0">You already voted for this election you can view your ballot below.</h4>
                    </div>
                @endif
                @foreach($positions as $position)
                    @if($vote->contains('position_id',$position->id))
                        <div class="card rounded-0">
                            <div class="card-header">
                                <strong>{{ $position->name }}</strong>
                            </div>
                            <div class="card-body pt-2">
                                @foreach($position->candidates as $candidate)
                                    @if($position->relation_level == 0 || $candidate->voter->grade_level == auth()->user()->grade_level)
                                        <div class="d-flex px-3 m-1 mt-3 align-items-center">
                                            <div class="d-flex flex-row align-items-center">
                                                    <div class="img-voter mr-4">
                                                        <img class="img-fluid rounded-circle" src="{{ $candidate->profile_url }}" />
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <h4>{{ $candidate->voter->name }}</h4>
                                                        <button type="button" onclick="openDetails('{{ $candidate->platform_content }}')" style="width:100px" class="btn btn-sm bg-gradient-primary">View Details</button>
                                                    </div>
                                            </div>
                                            @if($position->max_vote > 1)
                                                @if($vote->contains('candidate_id',$candidate->id))
                                                    <div class="icheck-primary d-inline ml-auto">
                                                        <input type="checkbox" name="position_{{ $position->id }}[]" checked disabled id="candidate_{{ $candidate->id }}">
                                                        <label for="candidate_{{ $candidate->id }}">
                                                        </label>
                                                    </div>
                                                @else
                                                    <div class="icheck-primary d-inline ml-auto">
                                                        <input type="checkbox" name="position_{{ $position->id }}[]" disabled id="candidate_{{ $candidate->id }}">
                                                        <label for="candidate_{{ $candidate->id }}">
                                                        </label>
                                                    </div>
                                                @endif
                                            @else
                                                @if($vote->contains('candidate_id',$candidate->id))
                                                    <div class="icheck-primary d-inline ml-auto">
                                                        <input type="radio" name="position_{{ $position->id }}" value="{{ $candidate->id }}" checked disabled id="candidate_{{ $candidate->id }}">
                                                        <label for="candidate_{{ $candidate->id }}">
                                                        </label>
                                                    </div>
                                                @else
                                                    <div class="icheck-primary d-inline ml-auto">
                                                        <input type="radio" name="position_{{ $position->id }}" value="{{ $candidate->id }}" disabled id="candidate_{{ $candidate->id }}">
                                                        <label for="candidate_{{ $candidate->id }}">
                                                        </label>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
            <!-- Default box -->
            <form method="POST" id="form_ballot" action="{{ route('submit.ballot') }}">
                @csrf
                @foreach($positions as $position)
                    <div class="card rounded-0">
                        <div class="card-header">
                            <strong>{{ $position->name }}</strong>
                        </div>
                        <div class="card-body pt-2">
                            <div class="d-flex flex-row">
                                <div>You may select up to {{ $position->max_vote }} candidate{{ $position->max_vote > 1 ? 's' : '' }}.</div>
                                <button type="button" class="ml-auto btn btn-xs bg-success reset" data-id="position_{{ $position->id }}">Reset</button>
                            </div>
                            @foreach($position->candidates as $candidate)
                                @if($position->relation_level == 0 || $candidate->voter->grade_level == auth()->user()->grade_level)
                                    <div class="d-flex px-3 m-1 mt-3 align-items-center">
                                        <div class="d-flex flex-row align-items-center">
                                                <div class="img-voter mr-4">
                                                    <img class="img-fluid rounded-circle" src="{{ $candidate->profile_url }}" />
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h4>{{ $candidate->voter->name }}</h4>
                                                    <button type="button" onclick="openDetails('{{ $candidate->platform_content }}')" style="width:100px" class="btn btn-sm bg-gradient-primary">View Details</button>
                                                </div>
                                        </div>
                                        @if($position->max_vote > 1)
                                            <div class="icheck-primary d-inline ml-auto">
                                                <input type="checkbox" class="position_{{ $position->id }}" value="{{ $candidate->id }}" onclick="onCheck(`{{ $position->max_vote }}`,`position_{{ $position->id }}`)" name="position_{{ $position->id }}[]" id="candidate_{{ $candidate->id }}">
                                                <label for="candidate_{{ $candidate->id }}">
                                                </label>
                                            </div>
                                        @else
                                            <div class="icheck-primary d-inline ml-auto">
                                                <input type="radio" class="position_{{ $position->id }}" name="position_{{ $position->id }}" value="{{ $candidate->id }}" id="candidate_{{ $candidate->id }}">
                                                <label for="candidate_{{ $candidate->id }}">
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center flex-row">
                    <button type="button" style="width:100px" class="btn btn-sm bg-primary mr-2" id="preview">Preview</button>
                    <button type="submit" style="width:100px" class="btn btn-sm bg-success">Submit</button>
                </div>
            </form>
            @endif
        </section>
    </div>
  </div>
  <div class="modal fade" id="modal-details">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="details-value"></div>
            </div>
            <div class="modal-footer p-1">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ballot Preview</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="preview-html"></div>
            </div>
            <div class="modal-footer p-1">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="container">
        <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
        </div>
        <strong>Made with ❤ by Jerson Carin</strong>
    </div>
  </footer>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('static/js/adminlte.min.js') }}"></script>

<script>
    function onCheck(max,position_id) {
        if ($(`.${position_id}:checked`).length >= max) {
            $(`.${position_id}`).not(":checked").attr("disabled",true);
        } else {
            $(`.${position_id}`).not(":checked").removeAttr('disabled');
        }
    }

    function openDetails(text) {
        $('#modal-details').modal('toggle')
        $('#details-value').text(text)
    }

    $(document).ready (function () {
        $('#preview').click((e) => {
            $.ajax({
                type: 'post',
                url: `{{ route('preview.ballot') }}`,
                data: $('#form_ballot').serialize(),
                success: function (response) {
                    $('#modal-default').modal('toggle')
                    $('#preview-html').html(response.message)
                }
            })
        })

        $('.reset').click(function() {
            const position_id = $(this).data('id')
            $(`.${position_id}:checked`).prop('checked',false)
        })
    })
   
</script>
</body>
</html>
