@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action {{(isset($model_code) && 'answer'== $model_code )? 'active' : ''}}"
                       href="/admin/answer">Ответы</a>
                    <a class="list-group-item list-group-item-action {{(isset($model_code) && 'answerChoice'== $model_code) ? 'active' : ''}}"
                       href="/admin/answerChoice">Действия</a>
                </div>
            </div>
            <div class="col-10" class="pb-2">
                <div class="col-sm-12">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                </div>
                @if (isset($model_code))
                    @if (isset($table) && count($table['data']) > 0)
                        @include('admin.table',['table'=>$table,'code'=>$model_code])
                    @else
                        <div class="text-center mb-3">
                            <p>Нет записей</p>
                            <a class="btn btn-primary" href="{{route( $model_code.'.create')}}">Добавить запись</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@stop
