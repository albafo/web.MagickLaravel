@extends('magia::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Listado de {{$modelObject->getTitle()}}</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                @foreach($modelObject->first()->getAttributes() as $attribute=>$value)
                                <th>{{$attribute}}</th>
                                @endforeach
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($modelObject->all() as $item)

                            <tr>
                                @foreach($item->getAttributes() as $attribute)
                                <td>{{$attribute}}</td>
                                @endforeach
                                <td><a href="{{route('admin_edit', ['model'=>$modelName, 'id'=>"$primaryKey:{$item->$primaryKey}"])}}">Editar</a></td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection