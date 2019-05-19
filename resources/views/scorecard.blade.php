@extends('layouts.app')

@section('content')

    <scorecard-component matchId="{{app('request')->input('matchId')}}"></scorecard-component>

@endsection
