@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create transfer</div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            Transfer was created with id <a href="{{ url('/planner/transfer/' . $transfer->id) }}" class="alert-link">{{ $transfer->uuid }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection