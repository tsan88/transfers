@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">Transfer {{ $transfer->uuid }}</div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">To: {{ $transfer->account_id_to }}</li>
                            <li class="list-group-item">Summ: {{ $transfer->value }}</li>
                            <li class="list-group-item">Message: {{ $transfer->message }}</li>
                            <li class="list-group-item">Status: {{ $transfer->status }}</li>
                            <li class="list-group-item">plane_date: {{ $transfer->plane_date }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection