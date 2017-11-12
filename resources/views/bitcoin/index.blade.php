@extends('layouts.app')

@section('content')
    <div class="container">
                <table class="table table-bordered">
                    <tr>
                        <th>Time</th>
                    @foreach($columns as $column)
                            <th>{{ $column->currency }}</th>
                    @endforeach
                    </tr>
                    @foreach($result as $bitcoinGroup)
                        <tr>
                            <td>{{ $bitcoinGroup->first()['time'] }}</td>
                            @foreach($bitcoinGroup as $bitcoin)

                                    <td>{{ $bitcoin['exchange_rate'] }}</td>
                            @endforeach
                        </tr>
                        @endforeach

                </table>
        {{ $bitcoins->links() }}
    </div>

@endsection
