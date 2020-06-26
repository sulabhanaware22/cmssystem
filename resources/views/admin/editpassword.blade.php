<x-admin-master>
    @section('css')
    <!-- Custom styles for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @endsection
    @section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>

        </div>
        <div class="row">
            <div class="col-md-10">

            </div>
        </div>

        <div class="card-body">
            <form id="save_password_form" action="{{route('save-password')}}" method="post">

                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="text" class="form-control" name="password" id="password" />

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <input type="hidden" @if(isset($user['id']) && $user['id'] !='' ) value="{{$user->id}}" @else value="" @endif name="id" id="id" />
                            <input type="submit" value="submit" name="save_admin_password" id="save_admin_password" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Page Heading -->




    @endsection
    @section('scripts')


    <script>
        $(document).ready(function() {
            $('#save_password_form').on('submit', function(event) {
                event.preventDefault();
                data = $("#save_password_form")[0];
                formdata = new FormData(data);
                $.ajax({
                    url: "{{ config('constants.BASE_PATH') }}save-password/",
                    type: 'post',
                    data: formdata,

                    processData: false,
                    cache: false,
                    contentType: false,
                    beforeSend: function(request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    'success': function(data) {
                        response = JSON.parse(data)
                        //alert("the data is"+response.message)
                        if (response.message != '') {
                            //alert("saved!");
                            toastr.success(response.message)
                            window.location.reload();
                        }
                    },
                    'error': function() {

                    }
                });
            });
        });
    </script>


    @endsection
</x-admin-master>