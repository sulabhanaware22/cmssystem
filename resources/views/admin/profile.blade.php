<x-admin-master>
    @section('css')
    <!-- Custom styles for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endsection
    @section('content')
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>

        </div>
        <div class="row">
            <div class="col-md-10">

            </div>
        </div>

        <div class="card-body">
            <form id="save_admin_profile_form" action="{{route('save-profile')}}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>Profile Name</label>
                            <input type="text" class="form-control" name="name" id="name" @if(isset($user['name']) && $user['name'] !='' ) value="{{$user->name}}" @else value="" @endif />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>User Image</label>
                            <input type="file" class="form-control" name="userImage" id="userImage" />
                            <img id="previewImage" @if(isset($user['url']) && $user['url'] !='' ) src="{{$user->url}}" @else src="{{asset('images/noimage.png')}}" @endif alt="your image" width="200px" height="200px" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <input type="hidden" @if(isset($user['id']) && $user['id'] !='' ) value="{{$user->id}}" @else value="" @endif name="id" id="id" />
                            <input type="submit" value="submit" name="save_profile" id="save_profile" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('scripts')
    <!-- Page level plugins -->
    <script>
        $(document).ready(function() {
            $("#userImage").change(function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }(
                $('#save_admin_profile_form').on('submit', function(event) {
                    event.preventDefault();
                    data = $("#save_admin_profile_form")[0];
                    formdata = new FormData(data);
                    $.ajax({
                        url: "{{ config('constants.BASE_PATH') }}save-profile/",
                        type: 'post',
                        data: formdata,
                        enctype: 'multipart/form-data',
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
                    })
                }));
        })
    </script>


    @endsection
</x-admin-master>