<x-admin-master>
    @section('css')
    <!-- Custom styles for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @endsection
    @section('content')

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Save Post</h6>

        </div>
        <div class="row">
            <div class="col-md-10">

            </div>
        </div>

        <div class="card-body">
            <form id="save_post_form" action="{{route('save-post')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>POST TITLE</label>
                            <input type="text" class="form-control" name="postTitle" id="postTitle" @if(isset($post['name']) && $post['name'] !='' ) value="{{$post->name}}" @else value="" @endif />

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>POST DESCRIPTION</label>
                            <textarea rows="15" columns="80" class="form-control" name="postDescription" id="postDescription">@if(isset($post['description']) && $post['description']!=''){{$post->description}}  @else  @endif  </textarea>




                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>POST IMAGE</label>
                            <input type="file" class="form-control" name="postImage" id="postImage" />
                            <img id="previewImage" @if(isset($post['url']) && $post['url'] !='' ) src="{{$post->url}}" @else src="{{asset('images/noimage.png')}}" @endif alt="your image" width="200px" height="200px" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <input type="hidden" @if(isset($post['id']) && $post['id'] !='' ) value="{{$post->id}}" @else value="" @endif name="id" id="id" />
                            <input type="submit" value="submit" name="save_post" id="save_post" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>




    @endsection
    @section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('postDescription');
    </script>

    <script>
        $(document).ready(function() {
            $("#postImage").change(function() {
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
                $('#save_post_form').on('submit', function(event) {
                    event.preventDefault();
                    data = $("#save_post_form")[0];
                    formdata = new FormData(data);
                    alert("the value is"+CKEDITOR.instances.postDescription.getData());
                    $.ajax({
                        url: "{{ config('constants.BASE_PATH') }}savepost/",
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
                                window.location.href = "{{ config('constants.BASE_PATH') }}getposts/";
                            }
                        },
                        'error': function(xhr) {
                         if(xhr.status == 422){
                             response= JSON.parse(xhr.responseText);
                             toastr.success(response.message);
                             window.location.reload();
                         }
                        }
                    })
                }));
        })
    </script>


    @endsection
</x-admin-master>