@extends('layouts.app')

@section('content')

    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#standings" role="tab" data-toggle="tab">Standings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#matches" role="tab" data-toggle="tab">Matches</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#references" role="tab" data-toggle="tab">references</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="standings">
                <standings-component></standings-component>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="matches">
                <matches-component></matches-component>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="references">ccc</div>
        </div>
    </div>

{{--<matches-component></matches-component>--}}

@endsection()
