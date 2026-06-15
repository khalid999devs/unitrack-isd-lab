@php
    $role = 'admin';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    <x-placeholder-state icon="bell" title="Notices Management" />
@endsection
