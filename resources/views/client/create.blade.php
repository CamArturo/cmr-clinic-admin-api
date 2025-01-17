@extends('layouts.master')
@php $nav_path = ['client']; @endphp
@section('page-title')
    Add New Applicants
@endsection
@section('page-header-title')
    Add New Applicants
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Applicants</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Applicants</li>
    </ol>
@endsection
@section('content')
    <client-form csrf_token="{{ csrf_token() }}"></client-form>
@endsection
