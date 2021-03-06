@extends('layouts.master')
@section('title', 'General Ledger')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
  @stop
@section('content')

      <section class="content">
        <div class="box">  
           <div class="box-body">
              <div class="col-xl-6">
                <div class="col-md-3 pull-right">
                   <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" class="form-control pull-right" id="reservation">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-info alignTable">Filter</button>
                      </span>
                    </div>
                </div>    
          <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Revenues</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Expenses</a></li>
                  </ul>
             
                 <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                  <table class="table table-bordered table-striped example1">
                    <thead>
                       <tr>
                        <th>Revenue Name</th>
                        <th>Amount</th>
                        <th>Date Stamp</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                   <tbody>
                    <tr>
                      <td>Rentals</td>
                      <td>520.00</td>
                      <td>January 23,2018 8:00 am</td>
                      <td><a href="#" class="btn btn-primary"><i class="fa fa-eye">View</i></a></td>
                    </tr>
                     <tr>
                      <td>Booking fee</td>
                      <td>500.00</td>
                      <td>January 24,2018 9:00 am</td>
                      <td><a href="#" class="btn btn-primary"><i class="fa fa-eye">View</i></a></td>
                    </tbody>
                  </table>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">Generate Report</button>
                </div>
                  
                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Generate Report Confirmation</h4>
                      </div>
                        <div class="modal-body">
                           <p>Are you sure to generate this report from MM/DD/YYYY to MM/DD/YYYY<p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
            
            <!-- /.box-body -->


          
 
              <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

              <table class="table table-bordered table-striped example1">
                <thead>
                <tr>
                  <th>Revenue Name</th>
                  <th>Amount</th>
                  <th>Date Stamp</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Rentals</td>
                  <td>520.00</td>
                  <td>January 23,2018 8:00 am</td>
                  <td><a href="#" class="btn btn-primary"><i class="fa fa-eye">View</i></a></td>
                </tr>
                 <tr>
                  <td>Booking fee</td>
                  <td>500.00</td>
                  <td>January 24,2018 9:00 am</td>
                  <td><a href="#" class="btn btn-primary"><i class="fa fa-eye">View</i></a></td>

                </tbody>
              </table>
                   <div class="form-group">
                         <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal2">Generate Report</button>
              </div>
                        <!-- Modal -->
                <div id="myModal2" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Generate Confirmation</h4>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure to generate this report from MM/DD/YYYY to MM/DD/YYYY<p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>

                  </div>
                </div>
            </div>

              </div>


              </div>
              </div>
            </div>
         <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
      </section>



@stop

@section('scripts')
@parent
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
 <script>
  $(function () {
    $('.example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

@stop