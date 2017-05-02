@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Notifications
                        </h4>
                    </div>
                    <div class="panel-body">
                        @if ($notifications)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Notification
                                    </th>
                                    <th>
                                        Page
                                    </th>
                                    <th>
                                        Section
                                    </th>
                                    <th>
                                        Details
                                    </th>
                                    <th>
                                        User
                                    </th>
                                    <th>
                                        Date/Time
                                    </th>
                                    <th>
                                        Link
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>
                                            {{ $notification->title }}
                                        </td>
                                        <td>
                                            {{ $notification->page }}
                                        </td>
                                        <td>
                                            {{ $notification->section }}
                                        </td>
                                        <td>
                                            {{ $notification->details }}
                                        </td>
                                        <td>
                                            {{ $notification->creator->name }}
                                        </td>
                                        <td>
                                            {{ date('d/m/Y, H:i', strtotime($notification->created_at)) }}
                                        </td>
                                        <td>
                                            <a href="{{ url($notification->link) }}">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
