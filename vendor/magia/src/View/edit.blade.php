@extends('magia::layout')
@section('content')

    <form>
    <div class="row">
    <?php $count=0 ?>
    @foreach($fields as $field)
        @if($field)
            <div class="col-md-4">
                <div class="form-group">
                    <label for="{{$field->labelFor}}">{{$field->labelName}}</label>
                    {!! $field->generateCode(['class'=>'form-control'])!!}
                </div>
            </div>
            <?php $count++ ?>
            @if($count%3==0)
    </div>
    <div class="row">
            @endif
        @endif
    @endforeach
    </div>
    </form>
@endsection