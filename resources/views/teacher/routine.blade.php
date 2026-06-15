@php
    $role = 'teacher';
    $title = 'Routine';
    $active = 'routine';
@endphp

@extends('layouts.app')

@section('title', 'Routine - UniTrack')

@section('content')
    <x-placeholder-state icon="calendar-event" title="Routine Management" />
@endsection
