@extends('layouts.form_lg') 
@section('title', 'Operator Registration')
@section('form-id','regForm')
@section('form-action',route('operators.store'))
@section('form-body')
  <div class="margin-side-10">  
    <div class="box box-primary with-shadow">
      <div class="box-header with-border text-center">
          <h4>
          <a href="{{route('operators.index')}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
          </h4>
          <h4 class="box-title">
              OPERATOR REGISTRATION
          </h4>
      </div>
      <div class="box-body">
        <div class="padding-side-15"> 
          <h4 class="form-heading-blue">Personal Information</h4>
          <table class="table table-bordered table-striped form-table">
                <tbody>
                  <tr>
                    <th>Last Name <span class="text-red">*</span></th>
                    <td><input value="{{old('lastName')}}" name="lastName" type="text" class="form-control" placeholder="Last Name" val-name required></td>
                  </tr>
                  <tr>
                    <th>First Name <span class="text-red">*</span></th>
                    <td><input value="{{old('firstName')}}" name="firstName" type="text" class="form-control" placeholder="First Name" val-name required></td>
                  </tr>
                  <tr>
                    <th>Middle Name</th>
                    <td><input value="{{old('middleName')}}" name="middleName" type="text" class="form-control" placeholder="Middle Name" val-name></td>
                  </tr>
                  <tr>
                    <th>Contact Number <span class="text-red">*</span></th>
                    <td>  
                      <input type="text" name="contactNumber"  class="form-control" value="{{old('contactNumber')}}" placeholder="Contact Number" required data-parsley-errors-container="#errContactNumber" val-contact required>
                    </td>
                  </tr>
                  <tr>
                    <th>Address <span class="text-red">*</span></th>
                    <td><input value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address" val-address  required></td>
                  </tr>
                  <tr>
                    <th>Provinicial Address <span class="text-red">*</span></th>
                    <td><input value="{{old('provincialAddress')}}" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address  required></td>
                  </tr>
                  <tr>
                    <th>Gender <span class="text-red">*</span></th>
                    <td>
                      <div class="radio">
                          <label for=""> Male</label>
                          <label class="radio-inline">
                              <input type="radio" name="gender" checked="checked"  value="Male" class="flat-blue" @if(old('gender') == 'Male') {{'checked'}}@endif>
                          </label>
                          <label for="">Female</label>
                          <label class="radio-inline">
                              <input type="radio" name="gender" value="Female" class="flat-blue" @if(old('gender') == 'Female') {{'checked'}}@endif>
                          </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>SSS No</th>
                    <td>
                      <input value="{{old('sss')}}" name="sss" type="text" class="form-control" placeholder="SSS No." val-sss >
                    </td>
                  </tr>
                  <tr>
                    <th>Operator/Driver</th>
                    <td class="text-center"><input type="checkbox" id="operatorDriver" class="" name="operatorDriver"> Check the box if this operator is also a driver.</td>
                  </tr>
                  <tr>
                    <th>License No <span class="licenseReq text-red hidden">*</span></th>
                    <td>
                      <input value="{{old('licenseNo')}}" name="licenseNo" type="text" class="form-control" placeholder="License No." disabled="disabled">
                    </td>
                  </tr>
                  <tr>
                    <th>License Expiry Date <span class="licenseReq text-red hidden">*</span></th>
                    <td>
                        <input value="{{old('licenseExpiryDate')}}" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" disabled="disabled">
                    </td>
                  </tr>
                  <tr>
                    <th>Profile Picture</th>
                    <td><input type="file" name="profilePicture" accept="image/*"></td>
                  </tr>
                </tbody>
          </table>
          <h4 class="form-heading-blue">Contact Person</h4>
          <table class="table table-bordered table-striped form-table">
            <tbody>
              <tr>
                <th>Name <span class="text-red">*</span></th>
                <td>
                  <input value="{{old('contactPerson')}}" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-cname required>
                </td>
              </tr>
              <tr>
                <th>Address <span class="text-red">*</span></th>
                <td>
                   <input value="{{old('contactPersonAddress')}}" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" val-address required>
                </td>
              </tr>
              <tr>
                <th>Contact Number <span class="text-red">*</span></th>
                <td>
                  <input type="text" name="contactPersonContactNumber"  class="form-control" value="{{old('contactPersonContactNumber')}}" placeholder="Contact Number" val-contact required>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
          <div style="overflow:auto;">
                  <div class="text-center">
                      <button type="submit" class="btn btn-success">REGISTER</button>
                  </div>
              </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
@parent
 <script>
     $(document).ready(function(){
         function cloneDateMask() {

             $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})

         }

         cloneDateMask();

     });
    </script>

    <script>
      $(document).ready(function() {

          $('#operatorDriver').change(function() {
              if($(this).is(":checked")) {
                $('.licenseReq').removeClass('hidden');
                $('.licenseReq').show();
                $('input[name="licenseNo"]').prop('disabled',false);
                $('[name="licenseExpiryDate"]').prop('disabled',false);
                $('input[name="licenseNo"]').prop('required',true);
                $('[name="licenseExpiryDate"]').prop('required',true);
              } else{
                $('.licenseReq').hide();
                $('[name="licenseNo"]').prop('disabled',true);
                $('[name="licenseExpiryDate"]').prop('disabled',true);
                $('input[name="licenseNo"]').prop('required',false);
                $('[name="licenseExpiryDate"]').prop('required',false);
              }     
          });
      });
    </script>

    <script>
    $(function () {
        $('button[type="submit"]').on('click',function() {
            if($('input[name="licenseExpiryDate"]').val() === "") {
                $('input[name="licenseExpiryDate"]').val(null);
            }
        });

        $('.select2').select2();

        $('#datepicker').datepicker({
          autoclose: true
        });

        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass   : 'iradio_flat-blue'
        });

        $('[data-mask]').inputmask();
        $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true});

        
    });

    


    </script>

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
@endsection