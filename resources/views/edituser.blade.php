@extends('adminlte::layouts.app')
@section('staff')
{!! 'class="active"' !!}
@stop
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.editstaff') }}
@endsection
@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">

				<!-- Default box -->
        		<div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Update User Details</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <b>Edit Details of `{{ $staff->name }}`</b>
                                </div>
                                <div class="panel-body">

{{ Form::model($staff,array('route'=>array('updateUser', $staff->id),'method'=>'PUT','enctype'=>'multipart/form-data'))}}
<div class="row text-center">
                                                    <img src="/uploads/avatars/{{ $staff->avatar }}" class="img-circle" style="width:100px;height:100px" alt="User Image" />
                                                </div>

                                        <div class="form-group required has-feedback ">
                                            {{ Form::label('name','Name')}}
                                           {{ Form ::text('name',null,array('class'=>'form-control ','required'=>'required'))}}
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>

                                    <div class="form-group required has-feedback ">
                                            {{ Form::label('name','Email')}}
                                           {{ Form ::email('email',null,array('class'=>'form-control','required'=>'required'))}}
                                           <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Password')}}
                                            <input id="password-field" minlength="12" placeholder="Please leave empty to use old existing password" name="password" class="form-control" type="password" >
                                            <span title="Show Password" toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password "></span>                                        
                                        </div>	
                                        <div class="form-group has-feedback">
                                        {{ Form::label('name','Confirm Password')}}
                                            <input id="password-field1" minlength="12" placeholder="Confirm password" name="password" class="form-control" type="password" >
                                            <span title="Show Password" toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password "></span>                                        
                                        </div>	                                        
                                        <div class="form-group required has-feedback">
                                        {{ Form::label('name','User Type')}}

                                        <select id="usertype" name ="usertype" class="form-control form-control-lg" required>
                                            <option value=''>Please Select A Role</option>
                                            <option value="custom" <?php if ($staff->usertype=='custom'){ echo "selected='selected'"; } ?>>Custom</option>
                                            <option value="admin"<?php if ($staff->usertype=='admin'){ echo "selected='selected'"; } ?>>Administrator</option>
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
                                                    <input class="client_role" {{ $staff->hasRole('client-readonly') ? 'checked' : '' }} type="checkbox" id="clientR" name="rolecustom[client-readonly]">
                                                    <!-- <input type="radio" name="client" {{-- $staff->hasRole('client-readonly') ? 'checked' : '' --}} id="clientR"  value="client-readonly" > -->

                                                    {{ Form::label('clientR','Read Only')}}
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <input class="client_role" {{ $staff->hasRole('client-readwrite') ? 'checked' : '' }} type="checkbox" id="clientRW" name="rolecustom[client-readwrite]">  
                                                        
                                                        <!-- <input type="radio" name="client" {{-- $staff->hasRole('client-readwrite') ? 'checked' : '' --}}  id="clientRW" value="client-readwrite" > -->
                                                    {{ Form::label('clientRW','Read & Write')}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                {{ Form::label('name','Manage Staff :')}}
                                                    <!-- <input class="member_role" type="checkbox" name="roles[manager]"> -->
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <input class="staff_role" {{ $staff->hasRole('staff-readonly') ? 'checked' : '' }}  type="checkbox" id="staffR" name="rolecustom[staff-readonly]">
                                                    <!-- <input type="radio" name="staff" {{-- $staff->hasRole('staff-readonly') ? 'checked' : '' --}}  id="staffR" value="staff-readonly" > -->
                                                    {{ Form::label('staffR','Read Only')}}
                                                </div>
                                                <div class="col-md-4 text-center">
                                             <input class="staff_role" {{ $staff->hasRole('staff-readwrite') ? 'checked' : '' }} type="checkbox" id="staffRW" name="rolecustom[staff-readwrite]">   
                                            
                                                       <!-- <input type="radio" name="staff" {{-- $staff->hasRole('staff-readwrite') ? 'checked' : '' --}}  id="staffRW" value="staff-readwrite" > -->

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

                                    <input class="admin-role hidden" {{ $staff->hasRole('admin') ? 'checked' : '' }}  type="checkbox" id="adminbox" name="roleadmin[admin]">

                                    {{Form::submit('Save',array('id'=>'submit','class'=>'pull-right btn btn-primary'))}}
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
@section('customscripts')
<script type="text/javascript">
    if($("#usertype").prop('selectedIndex')==1){
        $('.user-module-roles').show();
        $("#adminbox").prop('checked', false); 
    }
    $('.client_role').on('change', function() {
		    $('.client_role').not(this).prop('checked', false);  
		});
        $('.staff_role').on('change', function() {
		    $('.staff_role').not(this).prop('checked', false);  
		});

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
                if($(this).val()==='custom')
                {
               $('.user-module-roles').show();
               $("#adminbox").prop('checked', false); 
            //    $(".user-module-roles input").attr("required","required");
                }
                else{
                    $('.user-module-roles').hide();
                    $("#adminbox").prop('checked', true); 
                    $(".client_role").prop('checked', false); 
                    $(".staff_role").prop('checked', false); 

                    
                    // $(".user-module-roles input").removeAttr("required");
                }
                // $('#' + $(this).val()).show();
            });
            });
            $('#submit').click(function(e){
			if($("#password-field").val().length > 0){
				$("#password-field1").prop('required', true);
					if ($("#password-field").val() != $("#password-field1").val()) {
						// alert("12");
			            $("#password-field1")[0].setCustomValidity('Password Must be Matching.');
			        } else {
			        	// alert("15");
			            // input is valid -- reset the error message
		           		 $("#password-field1")[0].setCustomValidity('');

			        }


			}
			else{
				$("#password-field1").prop('required', false);

			}
			
		});
    </script>
@endsection
