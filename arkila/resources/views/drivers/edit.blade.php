@extends('layouts.app')

@section('content')
<h1>Edit </h1><hr>
<form method="post" action="{{ route('drivers.index')}} {{ isset($driver) ? '/' . $driver->driver_id : '' }}">
{{ csrf_field() }}

    @if (isset($driver))
        {{ method_field('PUT')}}
    @endif

    <label>First Name</label>
    <input type="name" class="form-control" name="first" placeholder="Enter Driver's First Name" value="{{ isset($driver) ? $driver->first_name : '' }}">

    <label>Last Name</label>
    <input type="name" class="form-control" name="last" placeholder="Enter Driver's Last Name" value="{{ isset($driver) ? $driver->last_name : '' }}">

    <label>Middle Name</label>
    <input type="name" class="form-control" name="middle" placeholder="Enter Driver's Middle Name" value="{{ isset($driver) ? $driver->middle_name : '' }}">

    <label>Address</label>
    <input type="text" class="form-control" name="address" placeholder="Enter Driver's Address" value="{{ isset($driver) ? $driver->address : '' }}">

    <label>Contact Number</label>
    <input type="number" class="form-control" name="contactn" placeholder="Enter Driver's Contact Number" value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Provincial Address</label>
    <input type="text" class="form-control" name="paddress" placeholder="Enter Driver's Provincial Address" value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Age</label>
    <input type="number" class="form-control" name="age" placeholder="Enter Driver's Age" value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Birth Date</label>
    <input type="date" class="form-control" name="birthdate" placeholder="Enter Driver's Birth Date" value="{{ isset($driver) ? $driver->birth_date : '' }}">

    <label>Birth Place</label>
    <input type="text" class="form-control" name="bplace" placeholder="Enter Driver's Birth Place" value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Gender</label><br>
    <input type="radio" name="gender" value="Male">Male<br>
    <input type="radio" name="gender" value="Female">Female

    <label>Citizenship</label>
    <input type="text" class="form-control" name="citizenship" placeholder="Enter Driver's Citizenship"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Civil Status</label><br>
    <input type="radio" name="cstatus" value="Single">Single<br>
    <input type="radio" name="cstatus" value="Married">Married<br>
    <input type="radio" name="cstatus" value="Divorced">Divorced

    <label>Number Of Children</label>
    <input type="number" class="form-control" name="nochild" placeholder="Enter Driver's Number of Children"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Spouse</label>
    <input type="name" class="form-control" name="spouse" placeholder="Enter Driver's Spouse Name"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Spouse Birth Date</label>
    <input type="date" class="form-control" name="spousebday"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Father's Name</label>
    <input type="name" class="form-control" name="father" placeholder="Enter Driver's Father Name"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Father's Occupation</label>
    <input type="text" class="form-control" name="fatheroccup" placeholder="Enter Driver's Father Occupation"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Mother's Name</label>
    <input type="name" class="form-control" name="mother" placeholder="Enter Driver's Mother Name"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Mother's Occupation</label>
    <input type="text" class="form-control" name="motheroccup" placeholder="Enter Driver's Mother Occupation"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Person in Case of Emergency</label>
    <input type="name" class="form-control" name="personemergency" placeholder="Enter Driver's Contact in Case of Emergency"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Address</label>
    <input type="text" class="form-control" name="peAddress" placeholder="Enter Driver's Contact in Case of Emergency Address"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Contact Number</label>
    <input type="number" class="form-control" name="peContactnum" placeholder="Enter Driver's Contact in Case of Emergency Contact Number"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>SSS #</label>
    <input type="text" class="form-control" name="sss" placeholder="Enter Driver's SSS Number"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>License Number</label>
    <input type="text" class="form-control" name="licenseNum" placeholder="Enter Driver's License Number"value="{{ isset($driver) ? $driver->driver_id : '' }}">

    <label>Expiry Date</label>
    <input type="date" class="form-control" name="exp"value="{{ isset($driver) ? $driver->driver_id : '' }}">



  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a href="/home/drivers">View All Drivers</a>


@endsection