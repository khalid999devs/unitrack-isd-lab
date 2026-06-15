@php
    $role = 'admin';
    $title = 'Teachers';
    $active = 'teachers';
@endphp

@extends('layouts.app')

@section('title', 'Teachers - UniTrack')

@section('content')
    <x-placeholder-state icon="user-star" title="Teachers Management" />
@endsection
