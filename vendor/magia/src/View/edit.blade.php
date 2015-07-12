@extends('magia::layout')
@section('content')

    <form>
    <div class="row">
    @foreach($fields as $field)
        @if($field)
            <div class="col-md-4">
                <div class="form-group">
                    <label for="{{$field->labelFor}}">{{$field->labelName}}</label>
                    {!! $field->generateCode(['class'=>'form-control'])!!}
                </div>
            </div>
        @endif
    @endforeach
    </div>
    </form>
@endsection