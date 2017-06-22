<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.2/socket.io.js"></script>
<script>

    var socket = io('http://192.168.10.10:3000');

    window.onload = function() {
        var cont = document.getElementById('messageview');

        cont.scrollTop = cont.scrollHeight;
    }


</script>



@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="exTab2" class="panel panel-default">
                    <div class="panel-heading">Meetings
                        <ul class="nav nav-pills pull-right">
                            <li class="active">
                                <a  href="#1" data-toggle="tab">Create Meeting or Schedule Event</a>
                            </li>
                            <li><a href="#2" data-toggle="tab">Without clearfix</a>
                            </li>
                            <li><a href="#3" data-toggle="tab">Solution</a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body text-center">
                        <div class="col-sm-12 center">

                            <div id="messageview" class="tab-content col-sm-12 " style="">
                                <div class="tab-pane active" id="1">
                                    <mydatepicker></mydatepicker>
                                </div>

                                <div class="tab-pane" id="3">
                                    <h3>add clearfix to tab-content (see the css)</h3>
                                </div>
                            </div>
                            <div class="clearfix">

                            </div><br/>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="textarea1" class="materialize-textarea"></textarea>
                                            <label for="textarea1">Textarea</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

