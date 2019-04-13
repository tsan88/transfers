@extends('layouts.app')

@section('content')
{{-- 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> 
--}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create transfer</div>

                <div class="card-body">
                    @if ($currentUser->account->assumed_value) 

                        <form action="{{ url('/planner/transfer') }}" method="POST" class="form-horizontal">

                            {!! csrf_field() !!}
                            
                            <div class="form-group">
                                <label for="user" class="col-sm-3 control-label">User: </label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="user" id="user">
                                        @forelse ($users as $item)
                                            <option value="{{ $item->id }}"  >{{ $item->name }}</option>
                                        @empty
                                            <option value="0" disabled>Empty</option>
                                        @endforelse
                                        <option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="planeDate" class="col-sm-3 control-label">Date: </label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="date" name="planeDate" id="planeDate" min="{{ $minDate }}" class="date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value" class="col-sm-3 control-label">Value: </label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" name="value" id="value"  min="1" max="{{ $currentUser->account->assumed_value }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" name="submitBtn" class="btn btn-default"><i class="fa fa-plus"></i>Submit</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p>Sorry, no manny on Your account.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script type="text/javascript">
    $('.date').datepicker({  
       format: 'mm-dd-yyyy'
     });  
</script>   --}}

@endsection