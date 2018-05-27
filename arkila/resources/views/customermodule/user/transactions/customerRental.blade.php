@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class=" boxContainer">
                            <div id="reservation">
                            @if ($requests->count() == 0)
                                <h4 class="text-center">NO RESERVATION.</h4>
                            @else
                                <ul class="list-group">
                                    @foreach($requests as $rental)
                                    <li class="list-group-item">
                                        <div class="row">
                                        <div class="col-md-6">
                                        
                                        <h4 style="margin-bottom: 1px;">{{$rental->destination}}</h4>
                                        <p style="color: gray;">{{$rental->created_at->formatLocalized('%d %B %Y')}} {{ date('g:i A', strtotime($rental->created_at)) }}</p>

                                        <small>
                                        @if($rental->status == 'Pending')
                                        <i class="fa fa-circle" style="color:gray;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Unpaid')
                                        <i class="fa fa-dot-circle-o" style="color:orange;"></i>
                                        {{strtoupper($rental->status)}}
                                         @elseif($rental->status == 'Paid')
                                        <i class="fa fa-check-circle" style="color:green;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Cancelled')
                                        <i class="fa fa-minus-circle" style="color:gray;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Departed')
                                        <i class="fa fa-chevron-circle-right" style="color:navyblue;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Expired')
                                        <i class="fa fa-times-circle" style="color:red;"></i>
                                        {{strtoupper($rental->status)}}
                                        @endif
                                        </small>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="pull-right">
                                                    <button id="viewRentalModal{{$rental->id}}" type="button" class="btn btn-primary">View</button>
                                                    @if($rental->status == 'Paid' || $rental->status == 'Unpaid' || $rental->status == 'Pending')
                                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#cancelModal{{$rental->rent_id}}">Cancel</button>                                           
                                                    @endif
                                                </div>
                                        </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <!-- box-->
                    </div>
                    <div class="col-md-3 mt-4 mt-md-0">
                      <!-- CUSTOMER MENU -->
                      <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                          <h3 class="h4 panel-title">MY TRANSACTIONS</h3>
                        </div>
                        <div class="panel-body">
                          <ul class="nav nav-pills flex-column text-sm">
                            <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-list"></i>My Rentals</a></li>
                            <li class="nav-item"><a href="{{route('customermodule.reservationTransaction')}}" class="nav-link"><i class="fa fa-heart"></i> My Reservations</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- boxContainer-->
            </div>
            <!-- container-->
            @foreach ($requests as $rental)
            <div class="modal fade" id="{{'cancelModal'.$rental->rent_id}}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">RESERVATION DETAILS</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                    @php $time = explode(':', $rental->departure_time); @endphp
                                    @if($rental->status == 'Paid')
                                    @if(Carbon\Carbon::now()->gt($rental->departure_date->subDays(1)->setTime($time[0], $time[1], $time[2])))
                                    <p>Its less than 24 hours before your specified departure time, if you will cancel now <strong class="text-red">you will NOT be able to refund</strong>.
                                    Are you sure you want to cancel your van rental?</p>
                                    @else
                                    <p>If you cancel your rental more than 1 day (24 Hours) before your specified departure time, you will receive a full refund minus a cancellation fee.
                                    Are you sure you want to cancel your van rental?</p>
                                    @endif
                                    @elseif($rental->status == 'Pending' || $rental->status == 'Unpaid')
                                    <p>Are you sure you want to cancel your van rental?</p>
                                    @endif

                                    </div>
                                    <div class="modal-footer">   
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                        <form action="{{route('rental.cancel', $rental->rent_id)}}" method="POST">
                                        {{csrf_field()}} {{method_field('PATCH')}}
                                        <button type="submit" name="cancel" value="Cancel" class="btn btn-danger">CANCEL</button>
                                        </form>

                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
            @endforeach
        </div>
        <!-- content-->
    </section>
    <!-- mainSection-->
@stop