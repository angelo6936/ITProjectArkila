<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ban Trans | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script>
        window.Laravel = @php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); @endphp
    </script>

    @if(!auth()->guest())
        <script>
            Laravel.userId = @php echo auth()->user()->id; @endphp
        </script>
    @endif
    @section('links')
        @include('layouts.partials.stylesheets_form')
    @show
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
    <div id="app" class="wrapper">    
            @include('layouts.partials.header_2')
        <!-- Full Width Column -->
        <div class="content-wrapper bgform-image">
                <div class="container">
                    <section class="content">
                        <div class="form-box">
                            <form id="form" action="@yield('form-action')" method="POST" class="parsley-form" data-parsley-validate="">
                            {{csrf_field()}} @yield('method_field')
                            <div class="form-box-header">
                                    <p>
                                        <a href="@yield('back-link')">
                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    <span class="text-center">
                                        @yield('form-title')
                                    </span>
                                    </p>
                            </div>
                            <div class="form-box-body">
                                @yield('form-body')
                            </div>
                            <!-- /.login-box-body -->
                            <div class="form-box-footer">
                                @yield('others')
                                <div class="form-group pull-right">
                                    @yield('form-btn')
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            </form>
                        </div>
                    </section>

                    <div class="modal in" id="submit-loader" class="hidden">
                        <div class="modal-dialog modal-sm" style="margin-top: 15%;">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="text-center">
                                <img src="{{ URL::asset('img/loading.gif') }}">
                                <h4>Please  wait...</h4>
                              </div>
                            </div> 
                          </div>
                        </div>
                    </div>
                
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->


        @include('layouts.partials.footer')
        @include('layouts.partials.queue_sidebar')
    </div>
    <!-- ./wrapper -->

    @section('scripts')
        @include('layouts.partials.scripts_form')
        @include('message.error')

        <script>
            $(document).ready(function() {
                $("form").on('submit', function(e){
                    var form = $(this);

                    if (form.parsley().isValid()){
                      $('#submit-loader').removeClass('hidden');
                      $('#submit-loader').css("display","block");
                    }
                    return true;
                });
            });
        </script>
    @show
</body>
 
</html>