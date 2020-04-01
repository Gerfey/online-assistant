@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
    <div class="container" style="max-width: 768px;">
        <h1>Форма {{(isset($edit) && $edit) ? 'редактирования' : 'добавления'}} ответа</h1>
        <form method="post"
              action="{{ (isset($edit) && $edit)  ? route('answer.update', $answer->id) : route('answer.store') }}">
            @csrf
            @if(isset($edit) && $edit)
                <input type="hidden" name="_method" value="put"/>
            @endif
            @if(isset($answer->id))
                <div class="form-group">
                    <label for="id">id</label>
                    <input type="text" class="form-control" id="id" value="{{$answer->id}}" readonly/>
                </div>
            @endif
            <div class="form-group">
                <label for="answer_field">Ответ</label>
                <textarea name="answer"
                          class="form-control"
                          id="answer_field"
                          rows="3"
                          required
                >{{$answer->answer ?? ''}}</textarea>
            </div>
            <div class="form-group">
                <label>Клюевые слова
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addKeyword();">+</button>
                </label>
                <div id="keywords" style="max-width: 200px;">
                    @if(isset($answer->keywords))
                        @foreach($answer->keywords as $keyword)
                            <input type="text" class="form-control mb-1" name="keywords[]" value="{{$keyword}}"/>
                        @endforeach
                    @else
                        <input type="text" class="form-control mb-1" name="keywords[]"/>
                    @endif
                </div>


            </div>
            <button type="submit"
                    class="btn btn-primary mt-2"> {{(isset($edit) && $edit) ? 'Обновить' : 'Создать'}} </button>
            <a type="submit"
               class="btn btn-secondary mt-2" href="{{ route('answer.index') }}"> Назад </a>
        </form>

        <script>
            function addKeyword() {
                $('#keywords').append('<input type="text" class="form-control mb-1" name="keywords[]"/>');
            }
        </script>
    </div>
@stop
