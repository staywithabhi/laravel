@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Dashboard</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <b>Staff Info</b>
            <a href="{{ url('/addNewStaff') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ trans('adminlte_lang::message.AddStaff') }}</span>
            </a>
    
                                </div>
                                <div class="panel-body">
                                 
                                {!! $html->table(['class'=>'table-stripped']) !!}
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
<!-- @section('customscripts')
{!! $html->scripts() !!}
@stop -->