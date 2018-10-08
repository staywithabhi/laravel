@extends('adminlte::layouts.app')
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.editclient') }}
@endsection
@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">
				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Update Client Details</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <b>Edit Details of `{{ $client->title }}`</b>
                                </div>
                                <div class="panel-body">

                                        {{ Form::model($client,array('route'=>array('clientUpdate', $client->id),'method'=>'PUT'))}}

                                        <div class="form-group required has-feedback ">
                                            {{ Form::label('name','Company Name')}}
                                           {{ Form ::text('title',null,array('class'=>'form-control ','required'=>'required'))}}
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>

                                    <!-- // <div class="form-group has-feedback ">
                                    //         {{-- Form::label('name','Email')--}}
                                    //        {{-- Form ::email('email',null,array('class'=>'form-control','required'=>'required'))--}}
                                    //        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    //     </div> -->
                                    	

                                        
                                    {{Form::submit('Save',array('class'=>'pull-right btn btn-primary'))}}
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
