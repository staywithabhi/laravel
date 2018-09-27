@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Delete This Client
            </div>
            <div class="modal-body">
                Are you sure you want to delete this client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-right">
                                    <b style="float:left;margin-top:5px">Clients Management Area</b>
            <a href="{{ url('/clientAdd') }}" class="btn btn-primary btn-add-new" style="border: 1px solid;">
                <i class="voyager-plus"></i> <span>{{ trans('adminlte_lang::message.AddClients') }}</span>
            </a>
                                </div>
                                <div class="panel-body">
                                    @foreach($clients as $client)
                                        <div class="col-lg-3 col-md-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <i class="fa fa-tasks fa-5x"></i>
                                                        </div>
                                                        <div class="col-xs-9 text-right" style="margin-top: 20px;">
                                                            <div class="huge">
                                                          {{-- @if($count=$members::where('client_id',$client->id)->get()->count()) 
                                        {{ $count }} Members 
                                        @else
                                        No Members
                                        @endif--}}
                                                            </div>
                                                            <div>{{ $client->title }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('editClient', ['id' => $client->id]) }}">
                                                    <div class="panel-footer">
                                                        <span class="pull-left">Edit Client</span>
                                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </a>

                                                <a data-href="{{ route('clientDelete', ['id' => $client->id]) }}"  class="close" aria-label="Delete" style="position: absolute;top: 3px;   right: 20px" data-toggle="modal" data-target="#confirm-delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a href="{{ route('manage', ['id' => $client->id]) }}">
                                                    <div class="panel-footer">
                                                        <span class="pull-left">Manage Members</span>
                                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </a>                        
                                            </div>
                                        </div>
                                    @endforeach
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
