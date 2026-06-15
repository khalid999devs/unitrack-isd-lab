@php
    $role = 'admin';
    $title = 'Students';
    $active = 'students';
@endphp

@extends('layouts.app')

@section('title', 'Students - UniTrack')

@section('content')
    <x-placeholder-state icon="users" title="Students Management" />
@endsection
