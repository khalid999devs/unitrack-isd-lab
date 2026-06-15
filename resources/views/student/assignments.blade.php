@php
    $role = 'student';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    <x-placeholder-state icon="clipboard-list" title="Assignments Management" />
@endsection
