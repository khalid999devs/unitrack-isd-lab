@php
    $role = 'admin';
    $title = 'Routines';
    $active = 'routines';
@endphp

@extends('layouts.app')

@section('title', 'Routines - UniTrack')

@section('content')
    <x-placeholder-state icon="calendar-stats" title="Routines Management" />
@endsection
