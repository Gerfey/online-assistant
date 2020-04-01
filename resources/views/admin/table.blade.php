
<table class="table  table-striped">
    <thead>
    <tr>
        @foreach ($table['columns'] as $column)
            <th scope="col">{{ $column}}</th>
        @endforeach
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($table['data'] as $row)
        <tr>
            @foreach ($row as $item)
                <td>{{is_array($item) ? 'array' : $item}}</td>
            @endforeach
            <td>
                <a href="{{ route($code.'.edit',$row['id'])}}" class="btn btn-primary mr-2 mt-2">Редактировать</a>
                <form action="{{ route($code.'.destroy', $row['id'])}}" method="post" style="display: inline-block;" class="mr-2 mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="text-right mb-3">
    <a class="btn btn-primary" href="{{route( $code.'.create')}}">Добавить запись</a>
</div>

