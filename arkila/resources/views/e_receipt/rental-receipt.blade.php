<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Arkila- BanTrans | Receipt</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    .table>tbody>tr>th,.table>tbody>tr>td {
      border-top: none;
    }
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body> <!-- onload="window.print();" -->
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Arkila - BanTrans 
          <small class="pull-right">Date: 2/10/2014</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12">
        <h4>Customer Information</h4>
      </div>
      <div class="col-sm-4 invoice-col">
        <table class="table borderless">
          <tbody>
            <tr>
              <th>Rental Code:</th>
              <td>{{$rental->rental_code}}</td>
            </tr>
          </tbody>
        </table>
        <address>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <table class="table borderless">
          <tbody>
            <tr>
              <th>Customer:</th>
              <td>{{$rental->customer_name}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-sm-3 invoice-col">
        <table class="table borderless">
          <tbody>
            <tr>
              <th>Receipt Type:</th>
              <td> Rental
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <h4>Itenerary</h4>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Destination</th>
            <th>Departure Date</th>
            <th>Departure Time</th>
            <th>Number of Days</th>
            <th>Fare</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>{{$rental->destination}}</td>
            <td>{{$rental->departure_date->formatLocalized('%d %B %Y')}}</td>
            <td class="text-right">{{date('g:i A', strtotime($rental->departure_time))}}</td>
            <td class="text-right">{{$rental->number_of_days}}</td>
            <td class="text-right">₱{{$rental->rental_fare}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-xs-6">
        <h4>Receipt</h4>
        <div class="well">
          <div class="table-responsive">
            <table class="table ">
            @if(!$destinations)
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td class="text-right">₱{{$rental->rental_fare}}</td>
              </tr>
              <tr>
                <th>Rental Fee</th>
                <td class="text-right">₱{{$rule->fee}}</td>
              </tr>
              <tr style="border-top: 2px solid black;">
                <th class="text-blue"><h4>Total:</h4></th>
                <td class="text-blue text-right"><h4>₱{{$rental->rental_fare + $rule->fee}}</h4></td>
              </tr>
              @else
              <tr style="border-top: 2px solid black;">
                <th class="text-blue"><h4>Total:</h4></th>
                <td class="text-blue text-right"><h4>₱{{$rental->rental_fare}}</h4></td>
              </tr>
              @endif              
            </table>
          </div>
        </div>
        <div>
          <p><strong>Date Paid:</strong> {{Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</p>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
          <h4>Van Details</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Van Unit</th>
                <th>Van Model</th>
                <th>Seating Capacity</th>
                <th>Driver</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$rental->van->plate_number}}</td>
                <td>{{$rental->van->model->description}}</td>
                <td class="text-right">{{$rental->van->seating_capacity}}</td>
                <td>{{$rental->driver->full_name}}</td>
              </tr>
            </tbody>
          </table>
        <div class="padding-side-15">
          <p class="well text-center">PLEASE BRING A VALID ID</p>
        </div>
      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->


        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          <strong>NOTE:</strong> Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>