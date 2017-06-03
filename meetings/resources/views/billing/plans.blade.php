@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Plans</div>

                    <div class="panel-body">


                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                Bronze</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="the-price">
                                                <h1>
                                                    $20<span class="subscript">/mo</span></h1>
                                                <small>1 month FREE trial</small>
                                            </div>
                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        1 Account
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        50 Events
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        50 Messages
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        100K API Access
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Custom Cloud Services
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        Weekly Reports
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="{{url('signup/bronze')}}" class="btn btn-success" role="button">Sign Up</a>
                                            1 month FREE trial</div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <div class="panel panel-success">
                                        <div class="cnrflash">

                                        </div>
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                Silver</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="the-price">
                                                <h1>
                                                    $40<span class="subscript">/mo</span></h1>
                                                <small>1 month FREE trial</small>
                                            </div>
                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        50 Accounts
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        100 Events
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        100 Messages
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        100K API Access
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Custom Cloud Services
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        Weekly Reports
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="{{url('signup/silver')}}" class="btn btn-success" role="button">Sign Up</a>
                                            1 month FREE trial</div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                Gold</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="the-price">
                                                <h1>
                                                    $80<span class="subscript">/mo</span></h1>
                                                <small>1 month FREE trial</small>
                                            </div>
                                            <table class="table">
                                                <tr>
                                                    <td>
                                                        Unlimited Accounts
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        Unlimited Events
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        Unlimited Messages
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        300K API Access
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Custom Cloud Services
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        Weekly Reports
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="{{url('signup/gold')}}" class="btn btn-success" role="button">Sign Up</a> 1 month FREE trial</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
