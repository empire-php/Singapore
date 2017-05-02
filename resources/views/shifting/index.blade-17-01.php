@extends('layouts.app')

@section('content')
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="page-header">
        <h3>
            New Shifting
        </h3>
    </div>
    <div class="row">
        <form method="POST" action="{{ url('/shifting/create') }}">
            {!! csrf_field() !!}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Point of Contact
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>1st Contact Person</h5>
                                <hr/>
                                <div class="form-group{{ $errors->has('first_contact_name') ? ' has-error' : ''}}">
                                    <label class="control-label">Name</label>
                                    <input type="text" name="first_contact_name" class="form-control" value="{{ old('first_contact_name') }}"/>

                                    @if ($errors->has('first_contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_contact_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group margin-bottom-none{{ $errors->has('first_contact_number') ? ' has-error' : ''}}">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="first_contact_number" value="{{ old('first_contact_number') }}"/>

                                    @if ($errors->has('first_contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>2nd Contact Person</h5>
                                <hr/>
                                <div class="form-group{{ $errors->has('second_contact_name') ? ' has-error' : ''}}">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="second_contact_name" value="{{ old('second_contact_name') }}"/>

                                    @if ($errors->has('second_contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('second_contact_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group margin-bottom-none{{ $errors->has('second_contact_number') ? ' has-error' : ''}}">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="second_contact_number" value="{{ old('second_contact_number') }}"/>

                                    @if ($errors->has('second_contact_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('second_contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Deceased Information
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('deceased_name') ? ' has-error' : ''}}">
                                    <label class="control-label">Deceased Name</label>
                                    <input type="text" class="form-control" name="deceased_name" value="{{ old('deceased_name') }}">

                                    @if ($errors->has('deceased_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('deceased_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('hospital') ? ' has-error' : ''}}">
                                    <label class="control-label">Hospital/House</label>
                                    <input type="text" class="form-control" name="hospital" value="{{ old('hospital') }}"/>

                                    @if ($errors->has('hospital'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('hospital') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('send_parlour') ? ' has-error' : ''}}">
                                    <label class="control-label">Send Parlour</label>
                                    <input type="text" class="form-control" id="send_parlour" name="send_parlour" value="{{ old('send_parlour') }}"/>

                                    @if ($errors->has('send_parlour'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('send_parlour') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('send_outside') ? ' has-error' : ''}}">
                                    <label class="control-label">Send Outside</label>
                                    <input type="text" class="form-control" name="send_outside" value="{{ old('send_outside') }}"/>

                                    @if ($errors->has('send_outside'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('send_outside') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group margin-bottom-none{{ $errors->has('remarks') ? ' has-error' : ''}}">
                                    <label class="control-label">Remarks</label>
                                    <textarea class="form-control" name="remarks">{{ old('remarks') }}</textarea>

                                    @if ($errors->has('remarks'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Others
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Taken by</label>
                                    <input type="text" class="form-control" disabled value="{{ Auth::User()->name }}">
                                    <input type="hidden" name="creator_id" class="form-control" value="{{ Auth::User()->id }}">
                                </div>
                                <div class="form-group margin-bottom-none">
                                    <label class="control-label">Date/Time</label>
                                    <input type="text" class="form-control" disabled value="{{ date('d/m/Y, H:i') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group margin-bottom-none text-right">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-save"></i>
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if ($pendingShiftingList)
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Update Shiftings
                        </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Deceased Name
                                </th>
                                <th>
                                    Hospital / House
                                </th>
                                <th>
                                    Send Parlour
                                </th>
                                <th>
                                    Send Outside
                                </th>
                                <th>
                                    1st Contact Person
                                </th>
                                <th>
                                    2nd Contact Person
                                </th>
                                <th>
                                    Remarks
                                </th>
                                <th>
                                    Shifted by
                                </th>
                                <th>
                                    Time start
                                </th>
                                <th>
                                    Time end
                                </th>
                                @if ($canUpdate)
                                    <th class="text-right">
                                        Action
                                    </th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pendingShiftingList as $shifting)
                                <tr>
                                    <td>
                                        {{ $shifting->deceased_name }}
                                    </td>
                                    <td>
                                        {{ $shifting->hospital }}
                                    </td>
                                    <td>
                                        {{ $shifting->send_parlour }}
                                    </td>
                                    <td>
                                        {{ $shifting->send_outside }}
                                    </td>
                                    <td>
                                        {{ $shifting->first_contact_name }}, {{ $shifting->first_contact_number }}
                                    </td>
                                    <td>
                                        {{ $shifting->second_contact_name }}, {{ $shifting->second_contact_number }}
                                    </td>
                                    <td>
                                        @if ($canUpdate)
                                            <textarea class="form-control" name="remarks">{{ $shifting->remarks }}</textarea>
                                        @else
                                            {{ $shifting->remarks }}
                                        @endif
                                    </td>
                                    <td style="width:100px" {{ $canUpdate ? ' class="padding-v-5"' : '' }}>
                                        @if ($canUpdate)
                                            <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, $shifting->members()->getRelatedIds()->toArray()))
                                                            selected="selected"
                                                            @endif
                                                    >
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            @if ($shifting->members())
                                                @foreach ($shifting->members()->get() as $user)
                                                    <span class="label label-info margin-v-1">{{ $user->name }}</span>
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($canUpdate)
                                            <input type="text" class="form-control datetimepicker" name="start_date"
                                                   value="{{ $shifting->start_date ? date('d/m/Y, H:i', strtotime($shifting->start_date)) : '' }}">
                                        @else
                                            {{ $shifting->start_date ? date('d/m/Y, H:i', strtotime($shifting->start_date)) : '' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($canUpdate)
                                            <input type="text" class="form-control datetimepicker" name="end_date"
                                                   value="{{ $shifting->end_date ? date('d/m/Y, H:i', strtotime($shifting->end_date)) : '' }}">
                                        @else
                                            {{ $shifting->end_date ? date('d/m/Y, H:i', strtotime($shifting->end_date)) : '' }}
                                        @endif
                                    </td>
                                    @if ($canUpdate)
                                        <td class="text-right">
                                            <button class="btn btn-info btn-xs" onclick="App.updateShifting(this)"
                                                    data-shifting-id="{{ $shifting->id }}">
                                                <i class="fa fa-fw fa-save"></i>Save
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Completed Shiftings
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <form method="GET" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-6"></div>
                                    <label class="col-md-1 control-label">Filter</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control datetimepicker" name="from" id="filterFrom" placeholder="From" value="{{ $fromFilter }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control datetimepicker" name="to" id="filterTo" placeholder="To" value="{{ $toFilter }}">
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="submit" class="btn btn-info btn-block">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-12">
                            @if ($finishedShiftingList)
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>
                                            Deceased Name
                                        </th>
                                        <th>
                                            Hospital / House
                                        </th>
                                        <th>
                                            Send Parlour
                                        </th>
                                        <th>
                                            Send Outside
                                        </th>
                                        <th>
                                            1st Contact Person
                                        </th>
                                        <th>
                                            2nd Contact Person
                                        </th>
                                        <th>
                                            Remarks
                                        </th>
                                        <th>
                                            Shifted by
                                        </th>
                                        <th>
                                            Time start
                                        </th>
                                        <th>
                                            Time end
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($finishedShiftingList as $shifting)
                                        <tr>
                                            <td>
                                                {{ $shifting->deceased_name }}
                                            </td>
                                            <td>
                                                {{ $shifting->hospital }}
                                            </td>
                                            <td>
                                                {{ $shifting->send_parlour }}
                                            </td>
                                            <td>
                                                {{ $shifting->send_outside }}
                                            </td>
                                            <td>
                                                {{ $shifting->first_contact_name }}, {{ $shifting->first_contact_number }}
                                            </td>
                                            <td>
                                                {{ $shifting->second_contact_name }}, {{ $shifting->second_contact_number }}
                                            </td>
                                            <td>
                                                {{ $shifting->remarks }}
                                            </td>
                                            <td>
                                                @if ($shifting->members())
                                                    @foreach ($shifting->members()->get() as $user)
                                                        <span class="label label-info margin-v-1">{{ $user->name }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('d/m/Y, H:i', strtotime($shifting->start_date)) }}
                                            </td>
                                            <td>
                                                {{ date('d/m/Y, H:i', strtotime($shifting->end_date)) }}
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
    </div>
@endsection

@push('scripts')
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/shifting.js"></script>
@endpush