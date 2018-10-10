@extends('adminlte::layouts.app')
@section('staff')
{!! 'class="active"' !!}
@stop
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.AddStaff') }}
@endsection
@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Add New Staff Member</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <b>Staff Details</b>
                                </div>
                                <div class="panel-body ">
                                    <form enctype="multipart/form-data" action="/saveStaff" method="POST">
                                        <div class="form-group required has-feedback ">
                                        {{ Form::label('name','Name','class','control-label')}}
                                            <input placeholder="Full Name" name="name" value="" autofocus="autofocus" class="form-control" type="text" required>
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>
                                        <div class="form-group required has-feedback">
                                        {{ Form::label('name','Email')}}
                                            <input placeholder="Email" name="email" value="{{ $user->email }}" class="form-control" type="email"  required/>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group required has-feedback">
                                        {{ Form::label('name','Password')}}
                                            <input minlength="12" id="password-field" placeholder="Enter Password here" name="password" class="form-control" type="password" required />
                                            <span title="Show Password" toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password "></span>                                        
                                        </div>	
                                        <div class="form-group required has-feedback">
                                        {{ Form::label('name','User Type')}}
                                        <select id="usertype" name ="usertype" class="form-control form-control-lg" required>
                                            <option value=''>Please Select A Role</option>
                                            <option value="admin">Administrator</option>
                                            <option value="standard">Custom</option>
                                        </select>       
                                        <span class="glyphicon glyphicon-compressed form-control-feedback"></span>
                                        </div>

                                        <div class="form-group  has-feedback user-module-roles" style="display:none">
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                {{ Form::label('name','Manage Clients :')}}
                                                    <!-- <input class="member_role" type="checkbox" name="roles[manager]"> -->
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <input class="member_role" type="checkbox" id="clientR" name="role[readonly]">
                                                    {{ Form::label('clientR','Read Only')}}
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <input class="member_role" type="checkbox" id="clientRW" name="role[readwrite]">         
                                                    {{ Form::label('clientRW','Read & Write')}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                {{ Form::label('name','Manage Staff :')}}
                                                    <!-- <input class="member_role" type="checkbox" name="roles[manager]"> -->
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <input class="member_role" type="checkbox" id="staffR" name="roles[readonly]">
                                                    {{ Form::label('staffR','Read Only')}}
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <input class="member_role" type="checkbox" id="staffRW" name="roles[readwrite]">         
                                                    {{ Form::label('staffRW','Read & Write')}}
                                                </div>
                                            </div>
                                        <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                                        </div>

                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Avatar Image')}}
                                            <input placeholder="Upload Profile Avatar" name="avatar" class="form-control" type="file">
                                            <span class="glyphicon glyphicon-camera form-control-feedback"></span>
                                        </div>	

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
@section('customscripts')
<script type="text/javascript">
        $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                // alert("hello");
                input.attr("type", "text");
            } else
            {
                // alert("hello2");
                input.attr("type", "password");
            }
        });
        $(function() {
            $('#usertype').change(function(){
                // alert($(this).val());
                if($(this).val()==='standard')
                {
               $('.user-module-roles').show();
                }
                else{
                    $('.user-module-roles').hide();
                }
                // $('#' + $(this).val()).show();
            });
            });
    </script>
@endsection