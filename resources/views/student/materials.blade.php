@php
    $role = 'student';
    $title = 'Materials';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Materials - UniTrack')

@section('content')
    <x-placeholder-state icon="files" title="Materials Management" />
@endsection
