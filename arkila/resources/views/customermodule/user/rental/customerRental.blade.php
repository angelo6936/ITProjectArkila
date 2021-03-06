@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div class="container">
            <div class="heading text-center">
                <h2>Rent a Van</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto" id="boxContainer">
                    <form class="contact100-form" action="{{route('customermodule.storeRental')}}" method="POST" data-parsley-validate="">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Van Model: </label>
                            <select id="vanType" name="van_model" class="form-control">
                                <option selected value="">All Van Model</option>
                                @foreach($vanmodels as $vanmodel)
                                    <option value="{{$vanmodel->model_id}}">{{$vanmodel->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Destination: <span class="text-red">*</span></label>
                            <input id="rentalDestination" class="form-control" type="text" name="rentalDestination" val-rent-dest required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Contact Number: <span class="text-red">*</span></label>
                                    <div class="input-group">
                                    <div class="input-group-num">
                                        <span>+63</span>
                                    </div>
                                    <input id="contactNumber" class="form-control" type="text" name="contactNumber" data-inputmask='"mask": "999-999-9999"' data-mask val-phone required>
                                    </div>
                                </div>
                            </div><!-- col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Number of Days: <span class="text-red">*</span></label>
                                    <input id="numberOfDays" class="form-control" type="number" name="numberOfDays" val-num-days required>
                                </div>
                            </div><!-- col-->
                        </div><!-- row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Departure Date: <span class="text-red"> *</span></label>
                                    <input id="date" class="form-control date-mask" type="text" name="date" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask val-book-date data-parsley-valid-departure required>
                                </div>
                            </div><!-- col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Departure Time: <span class="text-red">*</span></label>
                                    <div class="bootstrap-timepicker">
                                        <input type="text" id="timepicker" class="form-control timepicker" name="time" val-book-time required>
                                    </div><!-- bootstrap-timepicker-->
                                </div>
                            </div><!-- col-->
                        </div><!-- row-->
                        <div class="form-group">
                            <label for="">Comment:</label>
                            <textarea id="message" class="form-control" name="message" placeholder="Additional comments..." val-comment></textarea>
                        </div>
                        <div class="container-contact100-form-btn">
                            <button type="submit" class="contact100-form-btn" ><strong>Book</strong></button>
                        </div><!-- container-contact100-form-btn-->
                    </form>
                    <!-- contact100-form-->
                </div>
                <!-- boxContainer-->
            </div>
            <!-- row-->
        </div>
        <!-- container-->
</section>
<!--    main section-->
@stop
@section('scripts')
@parent
<script>
    
        $(function() {
            $('.datepicker').datepicker({
                autoclose: true
            });
            
        $('#timepicker').timepicker({
            template: false
        });
        })
        
    // $('.summary-modal').click(function(){
    //         $('#vehicleType').text($('#vanType option:selected').text());
    //         $('#dest').text($('#rentalDestination').val());
    //         $('#contactNo').text($('#contactNumber').val());
    //         $('#numDays').text($('#numberOfDays').val());
    //         $('#dateDepart').text($('#date').val());
    //         $('#timeDepart').text($('#timepicker').val());
    //         $('#comment').text($('#message').val());
    //     });
    function getVehicle(elementId){
        var sel = document.getElementById(elementId);
        if (sel.selectedIndex == -1){
            return null;
        }
        
        return sel.options[sel.selectedIndex].text;
    }
    function showSummary(){
        document.getElementById('vehicleType').textContent = getVehicle('vanType');
        document.getElementById('dest').textContent = document.getElementById('rentalDestination').value;
        document.getElementById('contactNo').textContent = document.getElementById('contactNumber').value;
        document.getElementById('numDays').textContent = document.getElementById('numberOfDays').value;
        document.getElementById('dateDepart').textContent = document.getElementById('date').value;
        document.getElementById('timeDepart').textContent = document.getElementById('timepicker').value;
        document.getElementById('comment').textContent = document.getElementById('message').value;
    }
</script>
<script>
    $(function(){
        $('[data-mask]').inputmask();
        $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true});
    });
</script>
@endsection