<script src="{{URL::asset('/js/vendor.bundle.base.js')}}"></script>
<script src="{{URL::asset('/js/vendor.bundle.addons.js')}}"></script>
<script src="{{URL::asset('/js/off-canvas.js')}}"></script>
<script src="{{URL::asset('/js/misc.js')}}"></script>
<script src="{{URL::asset('/js/jasny-bootstrap.js')}}"></script>

<script src="{{URL::asset('/plugins/bootstrap-switch/bootstrap-switch.min.js')}}"></script>
<script src="{{URL::asset('/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
<script src="{{URL::asset('/js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('/plugins/nestable/jquery.nestable.js')}}"></script>
<script src="{{URL::asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{URL::asset('/js/jquery.validate-init.js')}}"></script>
<script src="{{URL::asset('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{URL::asset('/plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('/plugins/summernote/summernote.js') }}"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{URL::asset('/frontend/js/soft-ui-dashboard.min.js?v=1.0.5') }}"></script>

        @stack('scripts')



        <script type="text/javascript">
            
        $(document).ready(function () {
    // Remove the "active" class from elements with the class "nav-item"
          $(".logoutAdmin").closest(".nav-item").removeClass("active");
      });
             $(".logoutAdmin").on("click",function(event){
                        event.preventDefault();
                        var type = $(this).attr("type");
                      
                        if(type=="sidebar")
                        {
                            $(".nav-item").removeClass("active");
                            $(this).closest(".nav-item").addClass("active");
                        }
                        else{
                             $(".logoutAdmin").closest(".nav-item").removeClass("active");
                        }

                jQuery.getScript('https://cdn.jsdelivr.net/npm/sweetalert2@11', function() {
                
                Swal.fire({
                  title: 'Logout',
                  text: "Are you sure you want to logout?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#32388E',
                  cancelButtonColor: '#000',
                  confirmButtonText: 'Yes'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $(this).attr("href","{{ route('logout') }}");
                    document.getElementById('logout-form').submit();
                   
                  } else {
                    console.log('clicked cancel');
                  }
                }) ;   
               });
                });
        </script>

        

      