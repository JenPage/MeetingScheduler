<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.2/socket.io.js"></script>
<script>
    var socket = io('http://192.168.10.10:3000');
    window.onload = function() {

    }
</script>

@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>

                    <div class="panel-body">
<edit-meeting></edit-meeting>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
