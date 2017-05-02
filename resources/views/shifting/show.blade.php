@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title">
                Shifting
            </span>
            <a href="{{ url('/view_ss') }}" class="pull-right btn btn-xs btn-info">
                Back to the list
            </a>
        </div>
        <div class="panel-body">

            <div class="col-md-6">
                <div class="row-md-6">
                    <dl class="dl-horizontal">
                        <dt>Deceased Name</dt>
                        <dd>{{ $shifting->deceased_title }} {{ $shifting->deceased_name }}</dd>
                        <dt>Religion</dt>
                        <dd>{{ $shifting->deceased_religion }}</dd>
                        <dt>Hospital/House</dt>
                        <dd>{{ $shifting->hospital }}</dd>
                    </dl>
                </div>
                <div class="row-md-6">
                    <dl class="dl-horizontal">
                        <dt>Remarks</dt>
                        <dd>{{ $shifting->remarks }}</dd>
                    </dl>
                </div>
                <div class="row-md-6">
                    <dl class="dl-horizontal">
                        <dt>Shifted By</dt>
                        <dd>
                            @foreach ($shifting->members()->get() as $user)
                                <span class="label label-info margin-v-1">{{ $user->name }}</span>
                            @endforeach
                        </dd>
                    </dl>
                </div>
                <div class="row-md-6">
                    <dl class="dl-horizontal">
                        <dt>Start Time</dt>
                        <dd>
                            @if ($shifting->start_date)
                                {{ date('d/m/Y, H:i', strtotime($shifting->start_date)) }}
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row-md-6">
                    <dl class="dl-horizontal">
                        <dt>Name</dt>
                        <dd>{{ $shifting->first_contact_title }} {{ $shifting->first_contact_name }}</dd>
                        <dt>Religion</dt>
                        <dd>{{ $shifting->first_contact_religion }}</dd>
                        <dt>Mobile Number</dt>
                        <dd>{{ $shifting->first_contact_number }}</dd>
                    </dl>
                </div>
                @if ($shifting->second_contact_name)
                    <div class="row-md-6">
                        <dl class="dl-horizontal">
                            <dt>Name</dt>
                            <dd>{{ $shifting->second_contact_title }} {{ $shifting->second_contact_name }}</dd>
                            <dt>Religion</dt>
                            <dd>{{ $shifting->second_contact_religion }}</dd>
                            <dt>Mobile Number</dt>
                            <dd>{{ $shifting->second_contact_number }}</dd>
                        </dl>
                    </div>
                @endif
                <div class="row-md-6">
                    <dl class="dl-horizontal">
                        <dt>Send Parlour</dt>
                        <dd>{{ $shifting->send_parlour }}</dd>
                        <dt>Send Outside</dt>
                        <dd>{{ $shifting->send_outside }}</dd>
                    </dl>
                </div>
            </div>

            {{--<div class="row">--}}
                {{--<div class="col-md-6">--}}
                    {{--<dl class="dl-horizontal">--}}
                        {{--<dt>Name</dt>--}}
                        {{--<dd>{{ $shifting->first_contact_title }} {{ $shifting->first_contact_name }}</dd>--}}
                        {{--<dt>Religion</dt>--}}
                        {{--<dd>{{ $shifting->first_contact_religion }}</dd>--}}
						{{--<dt>Mobile Number</dt>--}}
                        {{--<dd>{{ $shifting->first_contact_number }}</dd>--}}
                    {{--</dl>--}}
                {{--</div>--}}
                {{--@if ($shifting->second_contact_name)--}}
                    {{--<div class="col-md-6">--}}
                        {{--<dl class="dl-horizontal">--}}
                            {{--<dt>Name</dt>--}}
                            {{--<dd>{{ $shifting->second_contact_title }} {{ $shifting->second_contact_name }}</dd>--}}
                           {{--<dt>Religion</dt>--}}
							{{--<dd>{{ $shifting->second_contact_religion }}</dd>--}}
						  {{--<dt>Mobile Number</dt>--}}
                            {{--<dd>{{ $shifting->second_contact_number }}</dd>--}}
                        {{--</dl>--}}
                    {{--</div>--}}
                {{--@endif--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6">--}}
                    {{--<dl class="dl-horizontal">--}}
                        {{--<dt>Deceased Name</dt>--}}
                        {{--<dd>{{ $shifting->deceased_title }} {{ $shifting->deceased_name }}</dd>--}}
						{{--<dt>Religion</dt>--}}
							{{--<dd>{{ $shifting->deceased_religion }}</dd>--}}
                        {{--<dt>Hospital/House</dt>--}}
                        {{--<dd>{{ $shifting->hospital }}</dd>--}}
                    {{--</dl>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                    {{--<dl class="dl-horizontal">--}}
                        {{--<dt>Send Parlour</dt>--}}
                        {{--<dd>{{ $shifting->send_parlour }}</dd>--}}
                        {{--<dt>Send Outside</dt>--}}
                        {{--<dd>{{ $shifting->send_outside }}</dd>--}}
                    {{--</dl>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<dl class="dl-horizontal">--}}
                        {{--<dt>Remarks</dt>--}}
                        {{--<dd>{{ $shifting->remarks }}</dd>--}}
                    {{--</dl>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@if ($shifting->members())--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<dl class="dl-horizontal">--}}
                            {{--<dt>Shifted By</dt>--}}
                            {{--<dd>--}}
                                {{--@foreach ($shifting->members()->get() as $user)--}}
                                    {{--<span class="label label-info margin-v-1">{{ $user->name }}</span>--}}
                                {{--@endforeach--}}
                            {{--</dd>--}}
                        {{--</dl>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6">--}}
                    {{--<dl class="dl-horizontal">--}}
                        {{--<dt>Start Time</dt>--}}
                        {{--<dd>--}}
                            {{--@if ($shifting->start_date)--}}
                                {{--{{ date('d/m/Y, H:i', strtotime($shifting->start_date)) }}--}}
                            {{--@endif--}}
                        {{--</dd>--}}
                    {{--</dl>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                    {{--<dl class="dl-horizontal">--}}
                        {{--<dt>End Time</dt>--}}
                        {{--<dd>--}}
                            {{--@if ($shifting->end_date)--}}
                                {{--{{ date('d/m/Y, H:i', strtotime($shifting->end_date)) }}--}}
                            {{--@endif--}}
                        {{--</dd>--}}
                    {{--</dl>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>

    </div>
    <div class="form-group margin-bottom-none text-right " style="padding-right: 50px;">
        <a href="{{ url("/shifting/downloadAsPDF/" . $shifting->id) }}" class="btn btn-primary actionModal">Print</a>
    </div>
@endsection
