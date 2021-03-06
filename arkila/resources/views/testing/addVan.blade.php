
@extends('layouts.form') 
@section('title', 'Add Van')
@section('back-link','facebook.com')
@section('form-title', 'Add Van') 
@section('form-body')
	<div class="form-group">
	<label for="">Operator:</label>
    <select name="" id="" class="form-control select2">
    	<option value="">awdawdaw</option>
    	<option value="">awdawd</option>
    	<option value="">awdwa</option>
    	<option value="">awdaw</option>
    	<option value=""></option>
    </select>
    </div>
	<div class="form-group">
	<label for="">Plate Number:</label>
    <input type="text" class="form-control" placeholder="Plate Number"> 
    </div>
    <div class="form-group">
	<label for="">Van Model</label>
    <input type="text" class="form-control" placeholder=" Van Model"> 
    </div>

    <div class="form-group">
	<label for="">Seating Capacity</label>
    <input type="number" class="form-control" placeholder="Seating Capacity" max="15" min="1">
    </div>
@endsection 
@section('others')
<input type="checkbox"> <span>Add new driver to this van unit</span>
@endsection


@section('form-btn')
<a href="changeDriver.html" class="btn btn-primary" data-toggle="modal" data-target="#form-modal">Add unit</a> 
@endsection 
@section('modal-title', 'Alert') 
@section('modal-body')
<h4>Are you sure you want to add?</h4>
@endsection 
@section('modal-btn')
<button type="submit" class="btn btn-primary"> Yes</button>
<button type="submit" class="btn btn-default"> No</button>
@endsection
@section('scripts')
	@parent
	<script>
    $(function () {
        $('.select2').select2()
    })
	</script>
@endsection
