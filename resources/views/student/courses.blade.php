@php
    $role = 'student';
    $title = 'Courses';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Courses - UniTrack')

@section('content')
    <x-placeholder-state icon="book-2" title="Courses Management" />
@endsection
