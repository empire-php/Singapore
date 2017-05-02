@extends('layouts.app')

@section('content')
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <em class="fa fa-fw fa-minus"></em> Login Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="inputWarning1">Landing Page Password</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="secretKey" value="{{ $secret_key->value }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="button" onclick="App.saveSecretKey(this)">Save</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="inputWarning1">Companies</label>
                                    </div>
                                    @if ($companies)
                                        @foreach ($companies as $company)
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                           id="companyName{{ $company->id }}" value="{{ $company->name }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-info" type="button"
                                                                    onclick="App.updateCompany(this)" data-company-id="{{ $company->id }}">
                                                                Save
                                                            </button>
                                                        </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <em class="fa fa-fw fa-minus"></em> General Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ url('/') }}" role="form">
                                        <div class="form-group">
                                            <label class="control-label" for="inputWarning1">Departments</label>
                                        </div>
                                        @if ($departments)
                                            @foreach ($departments as $department)
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                               id="departmentName{{ $department->id }}" value="{{ $department->name }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-info" type="button"
                                                                onclick="App.updateDepartment(this)" data-department-id="{{ $department->id }}">
                                                                Save
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="form-group hidden" id="newDepartmentForm">
                                            <div class="input-group">
                                                <input type="text" id="departmentName" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info" type="button" onclick="App.createDepartment(this)">Save</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <button class="btn btn-success" type="button" onclick="App.showNewDepartmentForm(this)">
                                                    <i class="fa fa-plus"></i> Add new department
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <em class="fa fa-fw fa-minus"></em> New Shifting Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-3">
                                            Details
                                        </th>
                                        <th class="col-xs-4">
                                            Department(s)
                                        </th>
                                        <th class="col-xs-4">
                                            Individuals(s)
                                        </th>
                                        <th class="col-xs-1 text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            New shifting submission e-mail
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $shifting_email_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $shifting_email_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveShiftingSetting(this)"
                                                    data-users-setting-id="{{ $shifting_email_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $shifting_email_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            New shifting submission notification
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $shifting_notification_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $shifting_notification_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveShiftingSetting(this)"
                                                    data-users-setting-id="{{ $shifting_notification_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $shifting_notification_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Update shifting information
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (in_array($department->id, $shifting_update_departments_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, $shifting_update_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveShiftingSetting(this)"
                                                data-users-setting-id="{{ $shifting_update_individuals_ids->id }}"
                                                data-departments-setting-id="{{ $shifting_update_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                
                
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <em class="fa fa-fw fa-minus"></em> Funeral Arrangement Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-3">
                                            Details
                                        </th>
                                        <th class="col-xs-4">
                                            Department(s)
                                        </th>
                                        <th class="col-xs-4">
                                            Individuals(s)
                                        </th>
                                        <th class="col-xs-1 text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            New FA submission e-mail
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $fa_email_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $fa_email_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveFASetting(this)"
                                                    data-users-setting-id="{{ $fa_email_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $fa_email_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            New FA submission notification
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $fa_notification_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $fa_notification_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveFASetting(this)"
                                                    data-users-setting-id="{{ $fa_notification_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $fa_notification_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Update FA information
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (in_array($department->id, $fa_update_departments_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, $fa_update_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveFASetting(this)"
                                                data-users-setting-id="{{ $fa_update_individuals_ids->id }}"
                                                data-departments-setting-id="{{ $fa_update_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <em class="fa fa-fw fa-minus"></em> Gemstone Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-3">
                                            Details
                                        </th>
                                        <th class="col-xs-4">
                                            Department(s)
                                        </th>
                                        <th class="col-xs-4">
                                            Individuals(s)
                                        </th>
                                        <th class="col-xs-1 text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            New Gemstone submission e-mail
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $gemstone_email_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $gemstone_email_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveGemstoneSetting(this)"
                                                    data-users-setting-id="{{ $gemstone_email_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $gemstone_email_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            New Gemstone submission notification
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $gemstone_notification_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $gemstone_notification_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveGemstoneSetting(this)"
                                                    data-users-setting-id="{{ $gemstone_notification_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $gemstone_notification_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Update Gemstone information
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (in_array($department->id, $gemstone_update_departments_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, $gemstone_update_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveGemstoneSetting(this)"
                                                data-users-setting-id="{{ $gemstone_update_individuals_ids->id }}"
                                                data-departments-setting-id="{{ $gemstone_update_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <em class="fa fa-fw fa-minus"></em> Columbarium Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-3">
                                            Details
                                        </th>
                                        <th class="col-xs-4">
                                            Department(s)
                                        </th>
                                        <th class="col-xs-4">
                                            Individuals(s)
                                        </th>
                                        <th class="col-xs-1 text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            New Columbarium submission e-mail
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $columbarium_email_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $columbarium_email_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveColumbariumSetting(this)"
                                                    data-users-setting-id="{{ $columbarium_email_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $columbarium_email_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            New Columbarium submission notification
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $columbarium_notification_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $columbarium_notification_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveColumbariumSetting(this)"
                                                    data-users-setting-id="{{ $columbarium_notification_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $columbarium_notification_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Update Columbarium information
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (in_array($department->id, $columbarium_update_departments_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, $columbarium_update_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                            @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveColumbariumSetting(this)"
                                                data-users-setting-id="{{ $columbarium_update_individuals_ids->id }}"
                                                data-departments-setting-id="{{ $columbarium_update_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-default" id="ala_carte_items">
                    <div class="panel-heading" role="tab" id="headingSeven">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                <em class="fa fa-fw fa-plus"></em> FA Ala-carte Items Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_ala_carte_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                <div class="panel panel-default" id="hearse_items">
                    <div class="panel-heading" role="tab" id="headingEight">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                <em class="fa fa-fw fa-plus"></em> Hearse Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_hearse_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="headingNine">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                <em class="fa fa-fw fa-plus"></em> FA Individual Sales Items Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_individual_sales_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTen">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                <em class="fa fa-fw fa-plus"></em> Inventory Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen" aria-expanded="false">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-3">
                                            Details
                                        </th>
                                        <th class="col-xs-4">
                                            Department(s)
                                        </th>
                                        <th class="col-xs-4">
                                            Individuals(s)
                                        </th>
                                        <th class="col-xs-1 text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Able to edit item(s)
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $inventory_edit_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $inventory_edit_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveInventorySetting(this)"
                                                    data-users-setting-id="{{ $inventory_edit_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $inventory_edit_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Able to delete item(s)
                                        </td>
                                        <td>
                                            @if ($departments)
                                                <select class="form-control" name="departments_ids" data-toggle="select2" multiple="">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                @if (in_array($department->id, $inventory_delete_departments_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($users)
                                                <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                                @if (in_array($user->id, $inventory_delete_individuals_ids->getValueArray()))
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-info" onclick="App.saveInventorySetting(this)"
                                                    data-users-setting-id="{{ $inventory_delete_individuals_ids->id }}"
                                                    data-departments-setting-id="{{ $inventory_delete_departments_ids->id }}"
                                            >
                                                Save
                                            </button>
                                        </td>
                                    </tr>
     
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="heading11">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                <em class="fa fa-fw fa-plus"></em> Parlour Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $parlour["items"]; $elem = "parlour";?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_parlour_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="heading12">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                <em class="fa fa-fw fa-plus"></em> SCC Buddhist settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12" aria-expanded="false">
                        <div class="panel-body">
                            
                            <div class="table_container">
                                <?php $items = $scc_buddhist["items"]; $elem = "scc_buddhist"; $pdf = (!empty($scc_buddhist["pdf"]))?$scc_buddhist["pdf"]:null;?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_scc_buddhist_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="heading13">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                <em class="fa fa-fw fa-plus"></em> SCC Christian settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_christian["items"]; $elem = "scc_christian"; $pdf = (!empty($scc_christian["pdf"]))?$scc_christian["pdf"]:null;?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_scc_christian_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="heading14">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                <em class="fa fa-fw fa-plus"></em> SCC Tidbits & Drinks settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_tidbits["items"]; $elem = "scc_tidbits"; $pdf = (!empty($scc_tidbits["pdf"]))?$scc_tidbits["pdf"]:null;?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_scc_tidbits_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="heading15">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                <em class="fa fa-fw fa-plus"></em> SCC Tentage
                            </a>
                        </h4>
                    </div>
                    <div id="collapse15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading15" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_tentage["items"]; $elem = "scc_tentage"; $pdf = (!empty($scc_tentage["pdf"]))?$scc_tentage["pdf"]:null;?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_scc_tentage_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="heading16">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                <em class="fa fa-fw fa-plus"></em> SCC Chanting
                            </a>
                        </h4>
                    </div>
                    <div id="collapse16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading16" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_chanting["items"]; $elem = "scc_chanting"; $pdf = (!empty($scc_chanting["pdf"]))?$scc_chanting["pdf"]:null;?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_scc_chanting_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-default" id="discount_settings">
                    <div class="panel-heading" role="tab" id="heading17">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                <em class="fa fa-fw fa-plus"></em> Preset discount settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading17" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <div class="section_title" style="width: 30%">Funeral Arrangement</div>
                                <table class="table-bordered" id="tbl_fa_discount">
                                    <thead>
                                        <tr>
                                            <th>Discount %</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        
                                        <tr id="base_fa_discount_tr" style="display:none">
                                            <td>
                                                <input type="number" name="fa_discount_0" id="fa_discount_0" class="form-control" style="display:table-cell; width: 90%" value="" /> 
                                                <span id="span_fa_discount_0"></span>%
                                            </td>
                                            <td>
                                                <a href="#" id="fa_save_0"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="fa_edit_0" style="display:none"><i class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="fa_delete_0" style="display:none"><i class="fa fa-remove"></i> delete</a>
                                            </td>
                                        </tr>
                                        
                                        @if ($fa_discount)
                                        @foreach($fa_discount as $key => $discount)
                                        
                                        <tr>
                                            <td>
                                                <input type="number" name="fa_discount_{{$key}}" id="fa_discount_{{$key}}" class="form-control" style="display:none; width: 90%" value="{{$discount}}" /> 
                                                <span id="span_fa_discount_{{$key}}">{{$discount}}</span>%
                                            </td>
                                            <td>
                                                <a href="#" id="fa_save_{{$key}}" style="display:none"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="fa_edit_{{$key}}"><i class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="fa_delete_{{$key}}"><i class="fa fa-remove"></i> delete</a>
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        @else
                                        
                                        <tr>
                                            <td>
                                                <input type="number" name="fa_discount_1" id="fa_discount_1" class="form-control" style="display:table-cell; width: 90%" value="" /> 
                                                <span id="span_fa_discount_1"></span>%
                                            </td>
                                            <td>
                                                <a href="#" id="fa_save_1"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="fa_edit_1" style="display:none"><i class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="fa_delete_1" style="display:none"><i class="fa fa-remove"></i> delete</a>
                                            </td>
                                        </tr>
                                        
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_fa_discount">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="table_container">
                                <div class="section_title" style="width: 30%">Funeral Arrangement for Repatriation</div>
                                <table class="table-bordered" id="tbl_far_discount">
                                    <thead>
                                        <tr>
                                            <th>Discount %</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                                                                
                                        <tr id="base_far_discount_tr" style="display:none">
                                            <td>
                                                <input type="number" name="far_discount_0" id="far_discount_0" class="form-control" style="display:table-cell; width: 90%" value="" /> 
                                                <span id="span_far_discount_0"></span>%
                                            </td>
                                            <td>
                                                <a href="#" id="far_save_0"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="far_edit_0" style="display:none"><i class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="far_delete_0" style="display:none"><i class="fa fa-remove"></i> delete</a>
                                            </td>
                                        </tr>
                                        @if ($far_discount)
                                        @foreach($far_discount as $key => $discount)
                                        
                                        <tr>
                                            <td>
                                                <input type="number" name="far_discount_{{$key}}" id="far_discount_{{$key}}" class="form-control" style="display:none; width: 90%" value="{{$discount}}" /> 
                                                <span id="span_far_discount_{{$key}}">{{$discount}}</span>%
                                            </td>
                                            <td>
                                                <a href="#" id="far_save_{{$key}}" style="display:none"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="far_edit_{{$key}}"><i class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="far_delete_{{$key}}"><i class="fa fa-remove"></i> delete</a>
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        @else
                                        
                                        <tr>
                                            <td>
                                                <input type="number" name="far_discount_1" id="far_discount_1" class="form-control" style="display:table-cell; width: 90%" value="" /> 
                                                <span id="span_far_discount_1"></span>%
                                            </td>
                                            <td>
                                                <a href="#" id="far_save_1"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="far_edit_1" style="display:none"><i class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="far_delete_1" style="display:none"><i class="fa fa-remove"></i> delete</a>
                                            </td>
                                        </tr>
                                        
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_far_discount">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-default" id="discount_settings">
                    <div class="panel-heading" role="tab" id="heading18">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                <em class="fa fa-fw fa-plus"></em> FA Package Builder
                            </a>
                        </h4>
                    </div>
                    <div id="collapse18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading18" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <div class="section_title" style="width: 30%">Packages</div>
                                <div id="tbl_list_package"></div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_package">
                                        <i class="fa fa-plus"></i> Add new package
                                    </button>
                                </div>
                            </div>
                            <div id="edit_package_container">
                                 
                            </div>  
                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-default" id="far_items">
                    <div class="panel-heading" role="tab" id="heading19">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                <em class="fa fa-fw fa-plus"></em> FA for Repatriation item settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading19" aria-expanded="false">
                        <div class="panel-body">
                            
                            <div class="table_container">
                                <?php $items = $far["items"]; $elem = "far";?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_far_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<!----Roster Settings--->
				 <div class="panel panel-default" id="far_items">
                    <div class="panel-heading" role="tab" id="heading19">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                <em class="fa fa-fw fa-plus"></em> Roster Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading19" aria-expanded="false">
                        <div class="panel-body">
                            
                            <div class="table_container">
                                <?php $items = $far["items"]; $elem = "far";?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_far_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    
    
    
    
    
    <div class="modal fade" id="add_ala_carte_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">FA Ala-carte Items Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group" style="padding: 15px">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="" class="form-control" />
                            <label class="control-label" for="inputWarning1">Category name</label>
                            <select name="category_name" title="" class="form-control selectpicker">
                                <option></option>
                                <option value="1">Backdrop</option>
                                <option value="2">Burial plot</option>
                                <option value="3">Coffin catalog</option>
                                <option value="4">Flowers</option>
                                <option value="5">Gem stones</option>
                                <option value="6">Urns</option>
                            </select>
                            <!--<div style="height: 20px"></div>
                            <label class="control-label">Selection category</label>
                            <select name="selection_category" class="form-control selectpicker">
                                <option></option>
                                <?php foreach( $product_categories as $key => $prod):?>
                                <option value="<?php echo $prod->category?>"><?php echo $prod->category?></option>
                                <?php endforeach;?>
                            </select>
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <select name="selection_item" class="form-control selectpicker">
                                <option></option>
                                <?php foreach( $product_items as $key => $product):?>
                                <option value="<?php echo $product->id?>" data-price="<?php echo $product->unit_price?>"><?php echo $product->item?></option>
                                <?php endforeach;?>
                            </select>-->
          
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection category</label>
                            <input type="text" id="selection_category" name="selection_category" class="form-control" />
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected" class="form-control" />
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name" class="form-control" />
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control" />
                            
                            <input type="hidden"  name="unit_price" value="" class="form-control" />
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_bttn" >SAVE</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="add_hearse_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hearse Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="order_nr" value="" class="form-control" />
                            
                            <label class="control-label" for="inputWarning1">Hearse name</label>
                            <input type="text" name="hearse_name" value="" class="form-control" />
                            <br />
                            <label class="control-label">Image</label>
                            <input type="file" name="image" value="" class="form-control" />
                            <br />
                            <label class="control-label">Unit Price</label>
                            <input type="text" name="unit_price" value="" class="form-control" />
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_bttn">SAVE</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="add_individual_sales_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">FA Individual Sales Items Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="" class="form-control" />
                            
                            <label class="control-label" for="inputWarning1">Package name</label>
                            
                            <input name="package_name" id="package_name" class="form-control" />
                            
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection category</label>
                            <input type="text" id="selection_category" name="selection_category" class="form-control" />
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected" class="form-control" />
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name" class="form-control" />
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control" />
                            
                            <!--<select name="selection_category" class="form-control selectpicker">
                                <option></option>
                                <?php foreach( $product_categories as $key => $prod):?>
                                <option value="<?php echo $prod->category?>"><?php echo $prod->category?></option>
                                <?php endforeach;?>
                            </select>
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <select name="selection_item" class="form-control selectpicker">
                                <option></option>
                                <?php foreach( $product_items as $key => $product):?>
                                <option value="<?php echo $product->id?>" data-price="<?php echo $product->unit_price?>"><?php echo $product->item?></option>
                                <?php endforeach;?>
                            </select>-->
                            
                            <input type="hidden" name="unit_price" value="" class="form-control" />
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_bttn">SAVE</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="add_parlour_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Parlour Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="order_nr" value="" class="form-control" />
                            
                            <label class="control-label" for="inputWarning1">Parlour name</label>
                            <input type="text" name="parlour_name" value="" class="form-control" />
                            <br />
                             <label class="control-label" for="inputWarning1">Capacity</label>
                            <input type="text" name="capacity" value="" class="form-control" />
                            <br />
                            <label class="control-label">Image</label>
                            <input type="file" name="image" value="" class="form-control" />
                            <br />
                            <label class="control-label">Unit Price</label>
                            <input type="text" name="unit_price" value="" class="form-control" />
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_bttn">SAVE</button>
                </div>

            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="add_general_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" id="item_type" name="elem" value="" />
                            <input type="hidden" id="id" name="id" value="" />
                            
                            <label class="control-label" id="package_label">Package name</label>
                            
                            <input name="package_name" id="package_name" class="form-control" />
                            
                            
                            <label class="control-label" id="category_label">Category Name</label>
                            
                            <input type="text" name="category_name" id="category_name" class="form-control" />
                            <input type="hidden" name="category_name_selected" id="category_name_selected" class="form-control" />
                            
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection category</label>
                            <input type="text" id="selection_category" name="selection_category" class="form-control" />
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected" class="form-control" />
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name" class="form-control" />
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control" />
                            
                            <input type="hidden" name="unit_price" value="" class="form-control" />
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_bttn">SAVE</button>
                </div>

            </div>
        </div>
    </div>
    
    <div class="modal fade" id="general_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    
@endsection

@push('css')
    <link href="/css/app/settings.css" rel="stylesheet">
@endpush


@push('scripts')
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/settings.js"></script>
@endpush