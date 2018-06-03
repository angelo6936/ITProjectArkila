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

        var submitStatus = false;
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

                <form id="@yield('form-id')" class="parsley-form" action="@yield('form-action')" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                {{csrf_field()}}
                @yield('method_field')

                <section class="content">
                @yield('form-body')
                    <div class="modal fade" id="form-modal">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"> @yield('modal-title') </h4>
                                </div>
                                <!-- /.modal-header -->
                                <div class="modal-body">
                                    @yield('modal-body')
                                </div>
                                <!-- /.modal-body -->
                                <div class="modal-footer">
                                    @yield('modal-btn')
                                </div>
                                <!--/.modal-foorer -->
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </section>
                </form>

                @include('layouts.partials.preloader_div')
            </div>
            <!-- /.container -->

        </div>
        <!-- /.content-wrapper -->

        @include('layouts.partials.footer')

        @include('layouts.partials.queue_sidebar')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    @section('scripts')
        @include('layouts.partials.scripts_form')
        @include('message.error')

        <script>
            $(document).ready(function() {
                $("form").on('submit', function(e){
                    var form = $(this);
                    if(submitStatus) {
                        e.preventDefault();
                    } else {
                        if (form.parsley().isValid()){
                            submitStatus = true;
                            $('#submit-loader').removeClass('hidden');
                            $('#submit-loader').css("display","block");
                        }
                    }
                });
            });
        </script>
    @show
</body>

</html>
