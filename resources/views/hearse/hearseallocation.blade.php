@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3>
        @if(isset($order) && !isset($is_pview))
            <a href="/hearse">Hearse</a> / Order H{{$order_nr}}
        @elseif(isset($is_pview))
            <a href="/hearse">Hearse</a>: {{$hearsesdetails->name}}
        @else
            Hearse Allocation
        @endif
    </h3>
</div>

@if(!isset($is_view))
<input type="hidden" id="token" value="{{ csrf_token() }}">
<div class="section">   
    <div class="section_title">Hearse allocation</div>
    <div>
        <div class="filter_zone">
            <form method="get">
            <table>
                <tr>
                    <td>Date from</td>
                    <td><input type="text" class="form-control" id="filter_booked_from_day" name="filter_booked_from_day" value="{{ (isset($filter_booked_from_day)?$filter_booked_from_day:"") }}" /></td>
                    <td>to</td>
                    <td><input type="text" class="form-control" id="filter_booked_to_day" name="filter_booked_to_day" value="{{ (isset($filter_booked_to_day)?$filter_booked_to_day:"") }}" /></td>
                </tr>
                <tr>
                    <td>Hearse</td>
                    <td colspan="3">
                        <select class="form-control" name="filter_hearses[]" data-toggle="select2" multiple="">
                            <option></option>
                            @foreach($items as $key => $item)
                            <option value="{{$item->id}}"
                                    @if(isset($filter_hearses))
                                        @if (in_array($item->id, $filter_hearses))
                                            selected="selected"
                                        @endif
                                    @endif
                                    >{{$item->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Staff Allocation Status</td>
                    <td colspan="3">
                        <select class="form-control" name="filter_hearse_manpower" id="filter_hearse_manpower">
                            <option></option>
                            <option value="2" {{ ((isset($filter_hearse_manpower) && $filter_hearse_manpower == 2)?"selected":"") }}>Allocated</option>
                            <option value="1" {{ ((isset($filter_hearse_manpower) && $filter_hearse_manpower == 1)?"selected":"") }}>Not allocated</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Filter" class="btn btn-blue-500" id="hearsesallocationfilter_bttn" /></td>
                    <td colspan="3"></td>
                </tr>
            </table>
            </form>
        </div>
        
        <div style="clear: both; height:50px"></div>
        <div id="listing">
            <table  id="hearsallclisting_tbl" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th onclick="window.location='/hearse/hearseallocation?ord=hearse_name&<?php if(isset($ordrTblBy) && $ordrTblBy=="asc" ){ echo "ordby=desc"; } else{ echo "ordby=asc"; } ?>'" style="cursor: pointer">Hearse Name</th>
                        <th onclick="window.location='/hearse/hearseallocation?ord=booked_from_day&<?php if(isset($ordrTblBy) && $ordrTblBy=="asc" ){ echo "ordby=desc"; } else{ echo "ordby=asc"; } ?>'" style="cursor: pointer">Date</th>
                        <!-- th onclick="window.location='/hearse/hearseallocation?ord=booked_to_day&<?php if(isset($ordrTblBy) && $ordrTblBy=="asc" ){ echo "ordby=desc"; } else{ echo "ordby=asc"; } ?>'" style="cursor: pointer">Date To</th -->
                        <th>Time from</th>
                        <th>Time to</th>
                        <th>{{$company_prefix}} no.</th>
                        <th>Order taken by</th>
                        <th onclick="window.location='/hearse/hearseallocation?ord=order_nr&<?php if(isset($ordrTblBy) && $ordrTblBy=="asc" ){ echo "ordby=desc"; } else{ echo "ordby=asc"; } ?>'" style="cursor: pointer">Order no.</th>
                        <th>Manpower</th>
                    </tr>
               </thead>
               <tbody>
                    @foreach ($hearsesorders as $hearsesOrdersVal)
                        <tr>
                            <td>
                                {{ $hearsesOrdersVal->hearse_name }}
                            </td>
                            <td>
                                {{ date("d-m-Y", strtotime($hearsesOrdersVal->booked_from_day)) }}
                            </td>
                            <!-- td>
                                {{ date("d-m-Y", strtotime($hearsesOrdersVal->booked_to_day)) }}
                            </td -->
                            <td>
                                {{ date("H:i", strtotime($hearsesOrdersVal->booked_from_day . " ". $hearsesOrdersVal->booked_from_time)) }}
                            </td>
                            <td>
                                {{ date("H:i", strtotime($hearsesOrdersVal->booked_to_day . " ". $hearsesOrdersVal->booked_to_time)) }}
                            </td>
                            <td>
                                <a href='/fa/view/{{ $hearsesOrdersVal->funeral_arrangement_id }}'>{{ ($hearsesOrdersVal->funeralArrangement)?$hearsesOrdersVal->funeralArrangement->getFullCode():"" }}</a>
                            </td>
                            <td>
                                {{ ($hearsesOrdersVal->creator)?$hearsesOrdersVal->creator->name:"" }}
                            </td>
                            <td>
                                <a href="/hearse/view/{{ $hearsesOrdersVal->id }}">H {{ sprintf("%05d",$hearsesOrdersVal->order_nr) }}</a>
                            </td>
                            <td>
                                @if( $usersdata )
                                    <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                        @foreach( $usersdata as $usersdataVal )
                                            <option value="{{ $usersdataVal->id }}"
                                                    @if (in_array($usersdataVal->id, $hearsesOrdersVal->members()->getRelatedIds()->toArray()))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                            </option>
                                        @endforeach
                                    </select> 
                                @endif
                            </td>
                            <td class="text-right">
                                <button class="btn btn-info btn-xs" onclick="App.updateHearsesManpower(this)"
                                        data-hearse-id="{{ $hearsesOrdersVal->id }}">
                                    <i class="fa fa-fw fa-save"></i>Save
                                </button>
                            </td>
                        </tr>
                    @endforeach    
               </tbody>
            </table>
        </div>
            
    </div>
</div>
@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/hearseallocation.js"></script>
    <script src="/js/app/general_form.js"></script>    
@endpush