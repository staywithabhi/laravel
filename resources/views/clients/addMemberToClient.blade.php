@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.AddClient') }}
@endsection
@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Add New Member</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <b>Client Details</b>
                                </div>
                                <div class="panel-body">
                                    <form enctype="multipart/form-data" action="/memberSave" method="POST">
                                        <div class="form-group has-feedback ">
                                        {{ Form::label('name','Name')}}
                                            <input placeholder="Full Name" name="name" value="" autofocus="autofocus" class="form-control" type="text" required>
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Email')}}
                                            <input placeholder="Email" name="email" value="{{ $user->email }}" class="form-control" type="email"  required/>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Password')}}
                                            <input placeholder="Enter Password here" name="password" class="form-control" type="password" required>
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        </div>	
  
                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Avatar Image')}}
                                            <input placeholder="Upload Profile Avatar" name="avatar" class="form-control" type="file" required>
                                            <span class="glyphicon glyphicon-camera form-control-feedback"></span>
                                        </div>	

                                                        <!-- <label>Update Profile Image</label>
                                        <input type="file" name="avatar">	 -->
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="client_id" value="{{ $id }}">
                                        <input type="submit" class="pull-right btn btn-sm btn-primary">
                                    
                                    </form>
            </div>

                            </div>
                        </div>

                    </div>

                </div>

				<!-- /.box -->
        	</div>
		</div>
	</div>

@endsection
