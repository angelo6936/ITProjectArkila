@extends('layouts.form')
@section('title', 'Create New Terminal')
@section('back-link', URL::previous())
@section('form-action', route('terminal.store'))
@section('form-title', 'Create Terminal')
@section('form-body')
	
    <div class="form-group">
        
        <div style="margin-top:18%">
            @include('message.error')
        </div>
        
        <label>Terminal Name:</label>
        <input type="text" class="form-control" name="addTerminalName">
    </div>

@endsection
@section('form-btn')
    <a  class="btn btn-primary" data-toggle="modal" data-target="#form-modal">Create</a>
@endsection

@section('modal-title','Alert')
@section('modal-body')
    <p>Are you sure you want to create this terminal?</p>
@endsection

@section('modal-btn')
    <button type="submit" class="btn btn-primary">Yes</a>
    <button class="btn btn-default" data-dismiss="modal">No</button>
@endsection
