@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        <a href="{{ route('transfer.create') }}"><i class="fa fa-plus"></i>Add transfer</a>
                    </p>

                    @if ($transfers->count())
                        <p>Your last transfers:</p>
                        <div>
                            <div class="list-group">
                                @foreach ($transfers as $transfer)
                                    <a href="{{ route('transfer.show' , [$transfer->id] ) }}" class="list-group-item list-group-item-action">
                                        <div class="list-group-item-heading">
                                            <h5 class="mb-1">{{ $transfer->value }}</h5>
                                        </div>
                                        <p class="mb-1">{{ $transfer->message }}</p>
                                        <small>{{ $transfer->uuid }}</small>
                                        <small class="badge">{{ $transfer->created_at }}</small>
                                    </a>
                                @endforeach 
                                </div>
                        </div>
                    @endif

                    @if (count($all_user_transfers))
                    <br><br>
                        <p>All last transfers:</p>
                        <div>
                            <div class="list-group">
                                @foreach ($all_user_transfers as $transfer)
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="list-group-item-heading">
                                            <h5 class="mb-1">{{ $transfer['user']->name }}</h5>
                                        </div>
                                        <p class="mb-1">{{ $transfer['value'] }}</p>
                                        <p class="mb-1">{{ $transfer['message'] }}</p>
                                        <small>{{ $transfer['uuid'] }}</small>
                                        <small class="badge">{{ $transfer['created_at'] }}</small>
                                    </a>
                                @endforeach 
                                </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
