@extends('layouts.startup')
@section('title', 'Setting Up')
@section('form-action', route('setup.store'))


@section('form-body')

<div class="box" style="margin: 8% 0%">  
    <div class="box-body">

        <!-- WELCOME -->
        <div class="form-section" style="margin-bottom: 0%; padding: 6% 4% 3% 4%">
            
            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/bantrans-logo.png') }}" alt="profile picture">
            <h2 class="text-center"><strong>Ban Trans - UV Express</strong></h2> 
            <hr>
            <p class="text-justify" style="font-size: 12pt"><strong>WELCOME! </strong>Lets get started by clickin on the next button, you are required to fill in necessary information about the company. As you move along you will be required to set the main terminal, destination terminal and fees by simply filling in necessary information. This web application is created for Ban Trans only.</p>

        </div>

        <!-- Company Profile-->
        <div class="form-section" style="margin-bottom: 10%">
            <div class="box-header with-border text-center">
                <h3 class="box-title">
                Company Information
                </h3>
            </div>

            <div style="padding: 7% 10% 0% 10%">
                <div class="form-group">
                    <label for="contactNumber">Contact Number: </label>
                    <input type="text" class="form-control" name="contactNumber" value="{{old('contactNumber')}}">    
                </div>

                <div class="form-group">
                    <label>Address:</label>
                    <input type="text" class="form-control" name="address" value="{{old('address')}}">
                </div>
                <div class="form-group">
                    <label>Email: </label>
                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                </div>
            </div>
        </div>
        
        <!--Terminals -->
        <div class="form-section" style="padding-right: 5%">
            <div class="box-header with-border text-center">
                <h3 class="box-title">
                Terminal
                </h3>
            </div>
            <div class="box" style="margin: 3%; padding: 3% 5%">
                <h4><strong>Main Terminal</strong></h4> 
                <div class="form-group">
                    <label>Name: <span class="text-red">*</span> </label>
                    <input type="text" class="form-control" name="addMainTerminal" value="{{old('addMainTerminal')}}" required>
                </div>
                <div class="form-group">
                    <label>Booking Fee: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" step="0.25" name="mainBookingFee" value="{{old('mainBookingFee')}}" required>
                </div>
            </div>

            <div class="box" style="margin: 3%; padding: 3% 5%">
                <h4><strong>Destination Terminal</strong></h4> 
                <div class="form-group">
                    <label>Name: <span class="text-red">*</span> </label>
                    <input type="text" class="form-control" name="addTerminal" value="{{old('addTerminal')}}" required>
                </div>
                <div class="form-group">
                    <label>Booking Fee: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" step="0.25" name="bookingFee" value="{{old('bookingFee')}}" required>
                </div>
                <div class="form-group">
                    <label>Regular Fare: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="0" step="0.25" name="regularFare" value="{{old('regularFare')}}" required>
                </div>
                <div class="form-group">
                    <label>Discounted Fare: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="0" step="0.25" name="discountedFare" value="{{old('discountedFare')}}">
                </div>
                <div class="form-group">
                    <label>Number of Regular Tickets: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="1" step="0.25" name="numticket" value="{{old('numticket')}}" required="">
                </div>
                <div class="form-group">
                    <label>Number of Discounted Tickets: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="1" step="0.25" name="numticketDis" value="{{old('numticketDis')}}">
                </div>
                <div class="form-group" id="shotTripReg">
                    <label>Short Trip Fare Regular: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" step="0.25" name="sTripFare" value="{{old('sTripFare')}}" required>
                </div>
                <div class="form-group" id="shotTripDis">
                    <label>Short Trip Fare Discounted: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" step="0.25" name="sdTripFare" value="{{old('sdTripFare')}}" required>
                </div>
            </div>
        </div>

        <!-- Fees -->
        <div class="form-section" style="margin-bottom: 11%">
            <div class="box-header with-border text-center">
                <h3 class="box-title">
                Fees
                </h3>
            </div>

            <div style="padding: 7% 10% 0% 10%">
                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" class="form-control" name="addFeesDescSop" value="SOP" readonly>
                </div>
                <div class="form-group">
                    <label>Amount: <span class="text-red">*</span></label>
                    <input type="number" class="form-control" name="addSop" min="0" step="0.25" placeholder="Php 0.00" value="{{old('addSop')}}" val-settings-amount required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" class="form-control" name="addFeesDescCom" value="Community Fund" readonly>
                </div>
                <div class="form-group">
                    <label>Amount: <span class="text-red">*</span></label>
                    <input type="number" class="form-control" name="addComFund" min="0" step="0.25" placeholder="Php 0.00" value="{{old('addComFund')}}" val-settings-amount required>
                </div>
            </div>
        </div>

    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>


    </div>

    <div class="box-footer">
        <div style="overflow:auto;">
            <div class="form-navigation" style="float:right;">
                <button type="button" id="prevBtn" class="previous btn btn-default">Previous</button>
                <button type="button" id="nextBtn" class="next btn btn-primary">Next</button>
                <input type="submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>  
@endsection
@section('scripts') 
@parent

   <script type="text/javascript">
        $(function () {
          var $sections = $('.form-section');

          function navigateTo(index) {
            // Mark the current section with the class 'current'
            $sections
              .removeClass('current')
              .eq(index)
                .addClass('current');
            // Show only the navigation buttons that make sense for the current section:
            $('.form-navigation .previous').toggle(index > 0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [type=submit]').toggle(atTheEnd);
          }

          function curIndex() {
            // Return the current index by looking at which section has the class 'current'
            return $sections.index($sections.filter('.current'));
          }

          // Previous button is easy, just go back
          $('.form-navigation .previous').click(function() {
            navigateTo(curIndex() - 1);
          });

          // Next button goes forward iff current block validates
          $('.form-navigation .next').click(function() {
            $('.parsley-form').parsley().whenValidate({
              group: 'block-' + curIndex()
            })  .done(function() {
              navigateTo(curIndex() + 1);
            });
          });

          // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
          $sections.each(function(index, section) {
            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
          });
          navigateTo(0); // Start at the beginning
        });
    </script>
    </script>

@endsection
