<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.2/socket.io.js"></script>
<script>
    var socket = io('http://192.168.10.10:3000');
    window.onload = function() {
        var cont = document.getElementById('1');
        cont.scrollTop = cont.scrollHeight;
    }
</script>
<style>
</style>

@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <p id="created-event" style="display: none" class="bg-success">Event Saved</p>
            <div class="col-md-10 col-md-offset-1">
                <div id="exTab2" class="panel panel-default">
                    <div class="panel-heading"><span style="margin-top: 10px; display: inline-block;">Meeting Scheduler</span>
                        <ul class="nav nav-pills pull-right" id="app-tabs">
                            <li class="active messages">
                                <a  href="#1" data-toggle="tab">Messages</a>
                            </li>
                            <li class="event" ><a href="#2" data-toggle="tab">Create Event</a>
                            </li>
                            <li class="your-events"><a href="#3" data-toggle="tab">Your Events</a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body text-center" style="padding: 0px">
                        <div class="col-sm-12 center" style="padding: 0px">
                                <div  class="tab-content col-sm-12 pull-right">
                                    <div  class="tab-pane active messages" id="1"  style="max-height: 900px; overflow: scroll">
                                        <messages></messages>
                                    </div>
                                    <div class="tab-pane event" id="2">
                                        <h3>Create an Event</h3>
                                        <div class="clearfix"></div> <br />
                                        <mydatepicker></mydatepicker>
                                    </div>
                                    <div class="tab-pane your-events" id="3">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <manage-meetings></manage-meetings>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="clearfix">
                            </div>
                            <br/>
                            <div class="clearfix"></div>
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
