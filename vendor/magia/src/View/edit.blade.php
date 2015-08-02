@extends('magia::layout')
@section('content')

    <form method="post" enctype="multipart/form-data">
        <div class="row">
        <?php $count=0 ?>
        @foreach($fields as $field)
            @if($field)
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="{{$field->labelFor}}">{{$field->labelName}} @if($field->isObligatory())<span style="color: red;">*</span>@endif </label>
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
        <div class="row">
            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Guardar cambios</button>
                <button type="button" class="btn btn-danger">Borrar ficha</button>
            </div>

        </div>
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
    </form>
@endsection