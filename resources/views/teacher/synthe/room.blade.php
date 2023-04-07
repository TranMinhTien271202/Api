@extends('teacher.layout.app')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">start_date</th>
                <th scope="col">end_date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ date('m/d/Y', strtotime($item->start_date)) }}</td>
                    <td>{{ date('m/d/Y', strtotime($item->end_date)) }}</td>
                    <td>
                        <button type="submit" class="btn btn-primary xs" id="saveBtn" value="create">show</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('script')
    @parent
    <script type="text/javascript" charset="utf-8">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            var id = $('#id').val();
            var url = '/teacher/syn-room/' + id;
            console.log(id, url);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(res) {
                    console.log(res);
                    window.location = '/teacher/syn-room/' + id
                }
            })
        });
    </script>
@endsection
