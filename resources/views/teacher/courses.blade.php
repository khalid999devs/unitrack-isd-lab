@php
    $role = 'teacher';
    $title = 'Assigned Courses';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Assigned Courses - UniTrack')

@section('content')
    <x-placeholder-state icon="book-2" title="Assigned Courses Management" />
@endsection
