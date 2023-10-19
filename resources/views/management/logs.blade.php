@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3 ">
        <h3>User Log</h3>
        @include('inc.alert')


        <div class="row justify-content-center my-3">
            <div class="col-10 table-responsive">
                <table class="table table-light table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Browser</th>
                            <th>Activity Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{ $activity->email }}</td>
                                <td>{{ $activity->ip }}</td>
                                <td>{{ $activity->useragent }}</td>
                                <td>{{ date('m/d/Y h:i:s a',strtotime($activity->created_at)) }}</td>
                                <td>{{ $activity->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
        var table;

        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            table = $(".table").DataTable({
                responsive: true,
                width: '100%',
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
                order: [[3, 'desc']]
            });
        });
    </script>
@endsection
