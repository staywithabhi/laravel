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
                            <h1 class="page-header">Update Member Details</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <b>Edit Details of `{{ $user->name }}`</b>
                                </div>
                                <div class="panel-body">

                                        {{ Form::model($member,array('route'=>array('memberUpdate', $member->id),'method'=>'PUT'))}}
                                        <div class="row text-center">
                                                    <img src="/uploads/avatars/{{ $member->avatar }}" class="img-circle" style="width:100px;height:100px" alt="User Image" />
                                                </div>

                                        <div class="form-group has-feedback ">
                                            {{ Form::label('name','Name')}}
                                           {{ Form ::text('name',null,array('class'=>'form-control ','required'=>'required'))}}
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>

                                    <div class="form-group has-feedback ">
                                            {{ Form::label('name','Email')}}
                                           {{ Form ::email('email',null,array('class'=>'form-control','required'=>'required'))}}
                                           <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Password')}}
                                            <input placeholder="Please leave empty to use old existing password" name="password" class="form-control" type="password" >
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        </div>	

                                        <!-- <input type="hidden" name="client_id" value=""> -->
                                         {{ Form ::hidden('client_id',null,array('class'=>'form-control ','required'=>'required'))}}
                                        <div class="form-group has-feedback">
                                                
                                                  
                                                        {{ Form::label('name','Avatar Image')}}
                                                        {{ Form::file('avatar',null,array('class'=>'form-control image'))}}
                                                    <span class="glyphicon glyphicon-camera form-control-feedback"></span>
                                               
                                        </div>	

                                        
                                    {{Form::submit('Update',array('class'=>'btn btn-primary'))}}
                                    {{ Form::close()}}
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
