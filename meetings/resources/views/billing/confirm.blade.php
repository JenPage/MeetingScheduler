@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Signup Complete</div>
                    <div class="panel-body">

                        <div class="container">
                    @foreach($confirmation as $conf)
                        <h4><strong>{{ ucfirst(trans($conf['type'])) }}</strong> - <i>{{$conf['description']}}</i></h4>
                    @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
