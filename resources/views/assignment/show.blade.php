@extends('layouts.master')
@php $nav_path = ['assignment']; @endphp
@section('page-title')
    View {{$assignment->name}}
@endsection
@section('page-header-title')
    View {{$assignment->name}}
@endsection
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignments</a></li>
        <li class="breadcrumb-item active" aria-current="location">View {{$assignment->name}}</li>
    </ol>
@endsection
@section('content')
    <div class="row mb-4">
        <div class="col-md-5">

                     @component('../components/std-show-field', ['value' => $assignment->id])
            Id            @endcomponent
                     @component('../components/std-show-field', ['value' => $assignment->name])
            Name            @endcomponent
                     @component('../components/std-show-field', ['value' => $assignment->client_id])
            Client Id            @endcomponent
                     @component('../components/std-show-field', ['value' => $assignment->user_id])
            User Id            @endcomponent
                     @component('../components/std-show-field', ['value' => $assignment->deleted_at])
            Deleted At            @endcomponent
         

            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                    <a href="/assignment/{{ $assignment->id }}/edit">
                        <button type="submit" class="btn btn-primary">
                            Edit
                        </button>
                    </a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                    <form class="form" role="form" method="POST" action="/assignment/{{ $assignment->id }}">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}

                        <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">

                    </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right">
                    <a href="{{ url('/assignment') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete this Assignments?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
@endsection
