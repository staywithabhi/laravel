@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.addclient') }}
@endsection
@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Add New Client Member</h1>
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
                                    <form enctype="multipart/form-data" action="/clientSave" method="POST">
                                        <div class="form-group has-feedback ">
                                        {{ Form::label('name','Company Name')}}
                                            <input placeholder="Full Name" name="title" value="" autofocus="autofocus" class="form-control" type="text" required>
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>
                                        <!-- <div class="form-group has-feedback">
                                        {{-- Form::label('name','Email') --}}
                                            <input placeholder="Email" name="email" value="{{-- $user->email --}}" class="form-control" type="email"  required/>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div> -->


                                                        <!-- <label>Update Profile Image</label>
                                        <input type="file" name="avatar">	 -->
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" value="Save" class="pull-right btn btn-md btn-primary">
                                    
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
