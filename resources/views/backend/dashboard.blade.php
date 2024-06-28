@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
<style type="text/css">
    .input-group #image_preview {
    margin-top: 0px !important;
    border: 1px solid #ddd;
    border-right: 0;
    width: 40px;
    height: 40px;
    border-radius: 0.25rem 0 0 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.input-group #image_preview img {
    width: auto;
    max-height: 100%;
    max-width: 100%;
}
</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
    <div class="content-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dashboard</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        @include('layouts.backend.message')
        <div class="row mt-3"> 
            <div class="col-12  ">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="headding-cont">
                            <h2 class="card-headding">{{ __('User Form') }}</h2>
                        </div>
                        <form id="addUserForm" class="form-material  row form-valide" method="post" action="{{ url('api/addUser')}}" enctype="multipart/form-data">
                            <input id="device_id" name="device_id" type="hidden" value="">
                            <input id="device_token" name="device_token" type="hidden" value="">
                            <input id="device_type" name="device_type" type="hidden" value="web">
                            <div class="form-group col-xxl-3 col-xl-4 col-sm-6">
                                <label for="image">Image</label><sup class="text-reddit"> *</sup>
                                <div class="">
                                    <div class="input-group">
                                        <div id="image_preview"><img height="100" width="100" id="previewing" src="{{ URL::asset('images/no-image-available.png')}}"></div>
                                        <input type="file" id="file" required name="image" accept=".jpg, .jpeg, .png" class="form-control">
                                        <small class="help-block error text-danger error_fild" style="position:unset;"></small>
                                    </div>
                                    <span class="text-muted">Note: Image should be JPG, JPEG, PNG Dimension 500x500.</span>
                                </div>
                            </div>
                            <div class="form-group col-xxl-3 col-xl-4 col-sm-6  ">
                                <label>Name</label><sup class="text-reddit"> *</sup>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}">
                                <small class="help-block error text-danger error_fild" style="position:unset;"></small>
                            </div>

                            <div class="form-group col-xxl-3 col-xl-4 col-sm-6">
                                <label>Email</label><sup class="text-reddit"> *</sup>
                                <input type="text" placeholder="Please enter email" class="form-control form-control-line" name="email" value="" maxlength="100">
                                <small class="help-block error text-danger error_fild" style="position:unset;"></small>
                            </div>

                            <div class="form-group overflow-visible col-xxl-3 col-xl-4 col-sm-6 mobileNumber decimalInput numberInput " style="overflow: visible;">
                                <label>Mobile Number</label><sup class="text-reddit"> *</sup>
                                <input type="hidden" class="form-control form-control-line" id="phone_code" name="phone_code"  value="91" placeholder="Please enter phone code 91" >
                                <input type="text" class="form-control form-control-line d-block" id="mobile" name="mobile" value="" placeholder="Please enter phone number">
                                <small class="help-block error text-danger error_fild mobile_error" style="position:unset;"></small>
                            </div>
                            <div class="form-group col-xxl-3 col-xl-4 col-sm-6 ">
                                <label>Select Role</label><sup class="text-reddit"> *</sup>
                                <select required class="form-control form-control-line" name="role_id" id= "role_id">
                                <option value="">Select Role</option>
                                @if(isset($roles))
                                    @foreach($roles as $row)
                                        <option value="{{$row->id}}">{!! ucfirst($row->name) !!}</option>
                                    @endforeach
                                @endif
                                </select>
                                <small class="help-block error text-danger error_fild" style="position:unset;"></small>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-4">Description</label>
                                <textarea class="form-control form-control-line" id="description" name="description" rows="5"></textarea>
                            </div>  
                            <div class="form-group col-md-12">
                                <button type="submit" id="addUser_button" class="btn btn-success submitBtn m-r-10">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
                <div class="col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-header p-3 pb-0">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Recent Submit Data</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="portlet light">
                                <div class="portlet-body">
                                    <div class="tabbable-line">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>User Name</th>
                                                    <th>Mobile Number </th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody class="loadData">
                                                       
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
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
<script>
    var page = 1;
    //add user
        $('#addUser_button').on('click', function() {
            $('.error').text('');
            $('.error').removeClass('has-error');
            var form = $('#addUserForm')[0];
            var formData = new FormData(form);
            $('#addUser_button').html('Processing...');
            $('#addUser_button').prop('disabled', true);
            $('.error').removeClass('has-error');
            $('.error').text('');
            $('input+small').text('');
            $('input').parent().removeClass('has-error');
          
            $.ajax({
                type: 'post',
                url: $('#addUserForm').attr('action'),
                data: formData,
                dataType: "json",
                cache: false,
                mimeType: "multipart/form-data",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + $('#auth_user_token').val()
                },
            })
            .done(function(data) {
                if (data.status == 200) {
                    if (data.data != '') {
                        $(".loadData").empty();
                        $(".loadData").html(data.data);
                    }
                    $('#addUser_button').prop('disabled', false);
                    $('#addUser_button').html('Save');
                    $('#name').val('');
                    // $('#phone_code').val('');
                    $('#mobile').val('');
                    $('#role_id').val('');
                    $('#description').val('');
                    toastr.success(data.message);
                } else if (data.errors) {
                    $('#addUser_button').prop('disabled', false);
                    $('#addUser_button').html('Save');
                    $.each(data.errors, function(key, value) {
                        if (key === 'mobile') {
                            $('.mobile_error').text(value);
                        }
                        var input = '#addUserForm input[name=' + key + ']';
                        $(input + '+small').text(value);
                        
                        $(input).parent().addClass('has-error');

                        var textarea = '#addUserForm textarea[name=' + key + ']';
                        $(textarea + '+small').text(value);
                        $(textarea).parent().addClass('has-error');

                        var select = '#addUserForm select[name=' + key + ']';
                        $(select + '+small').text(value);
                        $(select).parent().addClass('has-error');
                    });
                } else {
                    $('#addUser_button').prop('disabled', false);
                    $('#addUser_button').html('Save');
                    toastr.error(data.message);
                }
            })
        });



</script>
<script type="text/javascript">

    
    loadMoreData(page);
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });
    function loadMoreData(page){
        var search = ''; 
        var from_date = ''; 
        var end_date = ''; 
        var fData = new FormData();
        fData.append('page', page);
        fData.append('from_date', from_date);
        fData.append('end_date', end_date);
        fData.append('search', search);
        fData.append('device_id', $('#device_id').val());
        fData.append('device_token', $('#device_token').val());
        fData.append('device_type', $('#device_type').val());
        $.ajax(
            {
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer ' + $('#auth_user_token').val()
            },
            type: "POST",
            url: "{{ url('api/userList')}}",
            data:fData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function()
            {
               
            }
        })
        .done(function(data)
        {
            if (data.status == 200) {
                if (page == '1') {
                    $(".loadData").empty();
                    $(".loadData").html(data.data);
                }else{
                    $(".loadData").append(data.data);
                }
            }
            
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              
        });
    }
</script>
<script type="text/javascript">
    $("#mobile").intlTelInput({
        preferredCountries: ["IN"],
        separateDialCode: true,
        initialCountry: "IN"
    }).on('countrychange', function (e, countryData) {
        $("#phone_code").val(($("#mobile").intlTelInput("getSelectedCountryData").dialCode));
    });
    document.getElementById('mobile').addEventListener('input', function(event) {
        this.value = this.value.replace(/\D/g, ''); // Remove non-digit characters
    });
    // Allow only numerical input for mobile number
    document.getElementById('mobile').addEventListener('input', function (e) {
        let inputValue = e.target.value;
        inputValue = inputValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        e.target.value = inputValue.slice(0, 10); // Limit to 10 characters
    });

    function imageIsLoaded(e){
        $("#file").css("color","green");
        $('#previewing').attr('src',e.target.result);
    }   
    $("#file").on("change", function(){
        var fileObj = this.files[0];
        var imageFileType = fileObj.type;
        var imageSize = fileObj.size;

        var match = ["image/jpeg","image/png","image/jpg"];
        if(!((imageFileType == match[0]) || (imageFileType == match[1]) || (imageFileType == match[2]))){
        $('#previewing').attr('src','images/image.png');
            toastr.error('Please Select A valid Image File <br> Note: Only jpeg, jpg and png Images Type Allowed!!');
            return false;
        }else{
            if(imageSize < 1000000){
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }else{
                toastr.error('Images Size Too large Please Select 1MB File!!');
                return false;
            } 
        }
    });
</script>       
@endpush