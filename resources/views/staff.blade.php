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
                                </div>
                                <div class="panel-body">
                                    <table  id="staff-table"class="table table-hover table-bordered">
                                        <thead>
                                            <th>Id</th> 
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                           
                                        </thead>
                                        <tbody>
                                        @foreach($staff as $member)
                                        <tr>
                                            <td>{{ $member->id }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->avatar }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
@section('customscripts')
<script type="text/javascript">
 $("#staff-table").DataTable({
    serverside:false,
 });
</script>
@stop