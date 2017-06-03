@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Signup</div>

                    <div class="panel-body text-center">
                    <div class="col-sm-9 center">
                        {!! Form::open(['method'=>'POST', 'route' => 'save.plan', 'id' => 'plan', 'class' => 'form-horizontal']) !!}

                        <div class="form-group">
                            <label for="FirstName" class="col-sm-3 control-label pull-left">First Name</label>
                            <div class="col-sm-7">
                                <input class="form-control" name="firstname" value="{{$user['firstname']}}" />
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label for="LastName" class="col-sm-3 control-label pull-left">Last Name</label>
                            <div class="col-sm-7">
                                <input class="form-control" name="lastname" value="{{$user['lastname']}}" />
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <label for="Company" class="col-sm-3 control-label pull-left"> Company</label>
                            <div class="col-sm-7">
                                <input class="form-control" name="company" value="{{$user['company'][0]->name}}" />
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <label for="CurrentPlan" class="col-sm-3 control-label pull-left">Current Plan</label>
                            <div class="col-sm-7">
                                <input class="form-control" name="plan" value="{{$user['plan']}}" />
                            </div>
                        </div>
                        <br/>
                        <div class="clearfix"></div>
                        @foreach($user['signup_options'] as $key=>$plans)
                            <div class="form-group">
                                <label class="col-sm-2 control-label pull-left"> {{$key}}</label>
                            @foreach($plans as $plan)
                                    <select class="form-control col-sm-4 pull-right" style="width:72%" name="{{$key}}[]">
                                @foreach($plan as $option)
                                      <option id="{{$option['id']}}" value="{{$option['name']}}">

                                          ${{$option['cost']}}
                                          {{$option['description']}}
                                    @foreach($option as $key=>$opt)
                                    @endforeach
                                        </option>
                                @endforeach
                                </select>
                            @endforeach
                            </div>
                            <div class="clearfix"></div>
                        @endforeach

                        <div class="form-group">
                            <div class="col-sm-10 col-sm-10 text-center">
                                {!! Form::button('<i class="fa fa-save"></i> Save',['class'=>'btn','type'=>'submit']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
