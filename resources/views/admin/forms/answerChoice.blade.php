@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
    <div class="container" style="max-width: 768px;">
        <h1>Форма {{(isset($edit) && $edit) ? 'редактирования' : 'добавления'}} действия</h1>
        <form method="post"
              action="{{  (isset($edit) && $edit)  ? route('answerChoice.update', $answerChoice->id) : route('answerChoice.store') }}">
            @csrf
            @if(isset($edit) && $edit)
                <input type="hidden" name="_method" value="put"/>
            @endif
            @if(isset($answerChoice->id))
                <div class="form-group">
                    <label for="id">id</label>
                    <input type="text" class="form-control" id="id" value="{{$answerChoice->id}}" readonly/>
                </div>
            @endif
            <div class="form-group">
                <label for="title">Текст действия</label>
                <input type="text" class="form-control" id="title" name="title" required
                       value="{{$answerChoice->title ?? ''}}"/>
            </div>
            <div class="form-group">
                <label for="answer_id">Привязка к вопросу</label><br/>
                @if(isset($answers))
                    <select name="answer_id" class="form-control" required>
                        @foreach($answers as $answer)
                            <option
                                value="{{$answer->id}}"
                                {{ (isset($answerChoice->answer_id) &&$answer->id == $answerChoice->answer_id) ? 'selected' : ''}}
                            >
                                {{$answer->answer}}
                            </option>
                        @endforeach
                    </select>
                @else
                    <p>Необходимо добавить хотя бы один вопрос</p>
                @endif
            </div>
            <div class="form-group">
                <label>Клюевые слова
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addKeyword();">+</button>
                </label>
                <div id="keywords" style="max-width: 200px;">
                    @if(isset($answerChoice->keywords))
                        @foreach($answerChoice->keywords as $keyword)
                            <input type="text" class="form-control mb-1" name="keywords[]"
                                   value="{{$keyword}}"/>
                        @endforeach
                    @else
                        <input type="text" class="form-control mb-1" name="keywords[]"/>
                    @endif
                </div>


            </div>
            <button type="submit"
                    class="btn btn-primary mt-2"> {{(isset($edit) && $edit) ? 'Обновить' : 'Создать'}} </button>

            <a type="submit"
               class="btn btn-secondary mt-2" href="{{ route('answerChoice.index') }}"> Назад </a>
        </form>

        <script>
            function addKeyword() {
                $('#keywords').append('<input type="text" class="form-control mb-1" name="keywords[]"/>');
            }
        </script>
    </div>
@stop
