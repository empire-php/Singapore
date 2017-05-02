@extends('layouts.app')

@section('content')

    <style type="text/css">
        .tlBox1 .select2-container-multi .select2-choices .select2-search-choice {
            color: #f00;
            background: none;
            border: none;
        }

        .tlBox2 .select2-container-multi .select2-choices .select2-search-choice {
            color: #217dbb;
            background: none;
            border: none;
        }

        .tlBox3 .select2-container-multi .select2-choices .select2-search-choice {
            color: #424242;
            background: none;
            border: none;
        }

        .tlBox1 .select2-container-multi .select2-choices .select2-search-choice a {
            color: #f00;
        }

        .tlBox2 .select2-container-multi .select2-choices .select2-search-choice a {
            color: #217dbb;
        }

        .tlBox3 .select2-container-multi .select2-choices .select2-search-choice a {
            color: #424242;
        }

    </style>

    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                               aria-expanded="true" aria-controls="collapseOne">
                                <em class="fa fa-fw fa-plus"></em> Login Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="inputWarning1">Landing Page Password</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="secretKey"
                                                   value="{{ $secret_key->value }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="button"
                                                        onclick="App.saveSecretKey(this)">Save</button>
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
                                                           id="companyName{{ $company->id }}"
                                                           value="{{ $company->name }}">
                                                    <span class="input-group-btn">
                                                            <button class="btn btn-info" type="button"
                                                                    onclick="App.updateCompany(this)"
                                                                    data-company-id="{{ $company->id }}">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <em class="fa fa-fw fa-plus"></em> General Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingTwo">
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
                                                               id="departmentName{{ $department->id }}"
                                                               value="{{ $department->name }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-info" type="button"
                                                                    onclick="App.updateDepartment(this)"
                                                                    data-department-id="{{ $department->id }}">
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
                                                    <button class="btn btn-info" type="button"
                                                            onclick="App.createDepartment(this)">Save</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <button class="btn btn-success" type="button"
                                                        onclick="App.showNewDepartmentForm(this)">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <em class="fa fa-fw fa-plus"></em> New Shifting Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <em class="fa fa-fw fa-plus"></em> Funeral Arrangement Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingFour">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <em class="fa fa-fw fa-plus"></em> Gemstone Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingFive">
                        <div class="" style="width: 30%;margin-bottom:20px;padding-left: 20px; font-weight: bold;">Terms & Conditions</div>
                        <div class="col-md-12">
                            <textarea class="form-control" style="width: 50%;min-width: 300px;" rows="7" name="gemstone_terms" id="gemstone_terms">@if(isset($gemstone_terms_conditions->value)){{ $gemstone_terms_conditions->value }}@endif</textarea>
                        </div>
                        <div class="col-md-12" style="margin-top:15px; margin-bottom: 10px">
                            <button class="btn btn-primary" id="save_gemstone_btn" value="" type="button"> <i class="fa fa-save"></i> Save</button>
                        </div>
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <em class="fa fa-fw fa-plus"></em> Columbarium Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingSix">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                <em class="fa fa-fw fa-plus"></em> FA Ala-carte Items Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingSeven" aria-expanded="false">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                <em class="fa fa-fw fa-plus"></em> Hearse Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingEight" aria-expanded="false">
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

                <!-- For point 5 -->
                <div class="panel panel-default" id="columbarium_items">
                    <div class="panel-heading" role="tab" id="headingTwelve">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                <em class="fa fa-fw fa-plus"></em> Columbarium Items Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwelve" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingTwelve" aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button" id="add_columbarium_items">
                                        <i class="fa fa-plus"></i> Add more
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- -->
                <div class="panel panel-default" id="individual_sales_items">
                    <div class="panel-heading" role="tab" id="headingNine">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                <em class="fa fa-fw fa-plus"></em> FA Individual Sales Items Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine"
                         aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button"
                                            id="add_individual_sales_items">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                <em class="fa fa-fw fa-plus"></em> Inventory Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen"
                         aria-expanded="false">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="departments_ids" data-toggle="select2"
                                                    multiple="">
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
                                            <select class="form-control" name="users_ids" data-toggle="select2"
                                                    multiple="">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                <em class="fa fa-fw fa-plus"></em> Parlour Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11"
                         aria-expanded="false">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                <em class="fa fa-fw fa-plus"></em> SCC Buddhist settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12"
                         aria-expanded="false">
                        <div class="panel-body">

                            <div class="table_container">
                                <?php $items = $scc_buddhist["items"]; $elem = "scc_buddhist"; $pdf = (!empty($scc_buddhist["pdf"])) ? $scc_buddhist["pdf"] : null;?>
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                <em class="fa fa-fw fa-plus"></em> SCC Christian settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13"
                         aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_christian["items"]; $elem = "scc_christian"; $pdf = (!empty($scc_christian["pdf"])) ? $scc_christian["pdf"] : null;?>
                                @include('settings.items_settings')
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success add_items" type="button"
                                            id="add_scc_christian_items">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                <em class="fa fa-fw fa-plus"></em> SCC Tidbits & Drinks settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14"
                         aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_tidbits["items"]; $elem = "scc_tidbits"; $pdf = (!empty($scc_tidbits["pdf"])) ? $scc_tidbits["pdf"] : null;?>
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                <em class="fa fa-fw fa-plus"></em> SCC Tentage
                            </a>
                        </h4>
                    </div>
                    <div id="collapse15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading15"
                         aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_tentage["items"]; $elem = "scc_tentage"; $pdf = (!empty($scc_tentage["pdf"])) ? $scc_tentage["pdf"] : null;?>
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                <em class="fa fa-fw fa-plus"></em> SCC Chanting
                            </a>
                        </h4>
                    </div>
                    <div id="collapse16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading16"
                         aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <?php $items = $scc_chanting["items"]; $elem = "scc_chanting"; $pdf = (!empty($scc_chanting["pdf"])) ? $scc_chanting["pdf"] : null;?>
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                <em class="fa fa-fw fa-plus"></em> Preset discount settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading17"
                         aria-expanded="false">
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
                                            <input type="number" name="fa_discount_0" id="fa_discount_0"
                                                   class="form-control" style="display:table-cell; width: 90%"
                                                   value=""/>
                                            <span id="span_fa_discount_0"></span>%
                                        </td>
                                        <td>
                                            <a href="#" id="fa_save_0"><i class="fa fa-save"></i> save</a>
                                            <a href="#" id="fa_edit_0" style="display:none"><i class="fa fa-pencil"></i>
                                                edit</a>
                                            <a href="#" id="fa_delete_0" style="display:none"><i
                                                        class="fa fa-remove"></i> delete</a>
                                        </td>
                                    </tr>

                                    @if ($fa_discount)
                                        @foreach($fa_discount as $key => $discount)

                                            <tr>
                                                <td>
                                                    <input type="number" name="fa_discount_{{$key}}"
                                                           id="fa_discount_{{$key}}" class="form-control"
                                                           style="display:none; width: 90%" value="{{$discount}}"/>
                                                    <span id="span_fa_discount_{{$key}}">{{$discount}}</span>%
                                                </td>
                                                <td>
                                                    <a href="#" id="fa_save_{{$key}}" style="display:none"><i
                                                                class="fa fa-save"></i> save</a>
                                                    <a href="#" id="fa_edit_{{$key}}"><i class="fa fa-pencil"></i> edit</a>
                                                    <a href="#" id="fa_delete_{{$key}}"><i class="fa fa-remove"></i>
                                                        delete</a>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @else

                                        <tr>
                                            <td>
                                                <input type="number" name="fa_discount_1" id="fa_discount_1"
                                                       class="form-control" style="display:table-cell; width: 90%"
                                                       value=""/>
                                                <span id="span_fa_discount_1"></span>%
                                            </td>
                                            <td>
                                                <a href="#" id="fa_save_1"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="fa_edit_1" style="display:none"><i
                                                            class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="fa_delete_1" style="display:none"><i
                                                            class="fa fa-remove"></i> delete</a>
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
                            <br/>
                            <br/>
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
                                            <input type="number" name="far_discount_0" id="far_discount_0"
                                                   class="form-control" style="display:table-cell; width: 90%"
                                                   value=""/>
                                            <span id="span_far_discount_0"></span>%
                                        </td>
                                        <td>
                                            <a href="#" id="far_save_0"><i class="fa fa-save"></i> save</a>
                                            <a href="#" id="far_edit_0" style="display:none"><i
                                                        class="fa fa-pencil"></i> edit</a>
                                            <a href="#" id="far_delete_0" style="display:none"><i
                                                        class="fa fa-remove"></i> delete</a>
                                        </td>
                                    </tr>
                                    @if ($far_discount)
                                        @foreach($far_discount as $key => $discount)

                                            <tr>
                                                <td>
                                                    <input type="number" name="far_discount_{{$key}}"
                                                           id="far_discount_{{$key}}" class="form-control"
                                                           style="display:none; width: 90%" value="{{$discount}}"/>
                                                    <span id="span_far_discount_{{$key}}">{{$discount}}</span>%
                                                </td>
                                                <td>
                                                    <a href="#" id="far_save_{{$key}}" style="display:none"><i
                                                                class="fa fa-save"></i> save</a>
                                                    <a href="#" id="far_edit_{{$key}}"><i class="fa fa-pencil"></i> edit</a>
                                                    <a href="#" id="far_delete_{{$key}}"><i class="fa fa-remove"></i>
                                                        delete</a>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @else

                                        <tr>
                                            <td>
                                                <input type="number" name="far_discount_1" id="far_discount_1"
                                                       class="form-control" style="display:table-cell; width: 90%"
                                                       value=""/>
                                                <span id="span_far_discount_1"></span>%
                                            </td>
                                            <td>
                                                <a href="#" id="far_save_1"><i class="fa fa-save"></i> save</a>
                                                <a href="#" id="far_edit_1" style="display:none"><i
                                                            class="fa fa-pencil"></i> edit</a>
                                                <a href="#" id="far_delete_1" style="display:none"><i
                                                            class="fa fa-remove"></i> delete</a>
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                <em class="fa fa-fw fa-plus"></em> FA Package Builder
                            </a>
                        </h4>
                    </div>
                    <div id="collapse18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading18"
                         aria-expanded="false">
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                <em class="fa fa-fw fa-plus"></em> FA for Repatriation item settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading19"
                         aria-expanded="false">
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

                <!----Roster Settings- -->
                <div class="panel panel-default" id="roster_settings">
                    <div class="panel-heading" role="tab" id="heading20">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse20" aria-expanded="false" aria-controls="collapse20">
                                <em class="fa fa-fw fa-plus"></em> Roster Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse20" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading20"
                         aria-expanded="false">
                        <div class="panel-body">
                            <div class="table_container">
                                <div class="section_title" style="width: 30%">Roster Settings</div>
                                <div id="tbl_list_roster">
                                    <?php if(!empty($rosters)){ ?>
                                    <table class="table table-bordered" id="tbl_listing_roster">
                                        <thead>
                                        <tr>
                                            <th>Team</th>
                                            <th>Team Leader</th>
                                            <th>Embalmers</th>
                                            <th>Others</th>
                                            <th>Add to Roster</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($rosters as $roster){
                                        $team_leaders = explode(",", $roster->team_leader);
                                        $embalmers = explode(",", $roster->embalmers);
                                        $others = explode(",", $roster->others);
                                        ?>
                                        <form name="updateTbl" id="update_RosterSetting_<?php echo $roster->id;?>"
                                              method="post" action="settings/update_roster_setting">
                                            <tr>
                                                <?php echo csrf_field(); ?>
                                                <td><input type="text" readonly="readonly" name="team_name"
                                                           id="team_name_<?php echo $roster->id;?>"
                                                           value="<?php echo $roster->team_name;?>"></td>
                                                <td class="tlBox1">
                                                    <?php if (!empty($users)) { ?>
                                                    <select class="form-control" name="team_leader[]"
                                                            id="team_leader_<?php echo $roster->id;?>"
                                                            data-toggle="select2" multiple="">
                                                        <?php foreach ($users as $user) {?>
                                                        <option value="<?php echo $user->nickname;?>"
                                                                <?php if (in_array($user->nickname, $team_leaders)) { ?>
                                                                selected="selected"
                                                        <?php } ?>
                                                        >
                                                            <?php echo $user->nickname;?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php } ?>
                                                </td>
                                                <td class="tlBox2">
                                                    <?php if (!empty($users)) { ?>
                                                    <select class="form-control" name="embalmers[]"
                                                            id="embalmers_<?php echo $roster->id;?>"
                                                            data-toggle="select2" multiple="">
                                                        <?php foreach ($users as $user) {?>
                                                        <option value="<?php echo $user->nickname;?>"
                                                                <?php if (in_array($user->nickname, $embalmers)) { ?>
                                                                selected="selected"
                                                        <?php } ?>
                                                        >
                                                            <?php echo $user->nickname;?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php } ?>
                                                </td>
                                                <td class="tlBox3">
                                                    <?php if (!empty($users)) { ?>
                                                    <select class="form-control" name="others[]"
                                                            id="others_<?php echo $roster->id;?>" data-toggle="select2"
                                                            multiple="">
                                                        <?php foreach ($users as $user) {?>
                                                        <option value="<?php echo $user->nickname;?>"
                                                                <?php if (in_array($user->nickname, $others)) { ?>
                                                                selected="selected"
                                                        <?php } ?>
                                                        >
                                                            <?php echo $user->nickname;?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                            id="add_to_roster_<?php echo $roster->id;?>"
                                                            name="add_to_roster">
                                                        <option <?php echo $roster->add_to_roster == "1" ? "selected" : '';?> value="1">
                                                            Yes
                                                        </option>
                                                        <option <?php echo $roster->add_to_roster == "0" ? "selected" : '';?> value="0">
                                                            No
                                                        </option>
                                                    </select>
                                                </td>
                                                <input type="hidden" id="id_<?php echo $roster->id;?>"
                                                       value="<?php echo $roster->id;?>" name="id">
                                                <td>
                                                    <a href="#" id="roster_delete_<?php echo $roster->id;?>"><i
                                                                class="fa fa-remove"></i> delete</a>
                                                    <button class="btn btn-info"
                                                            onclick="updateRosterSetting(<?php echo $roster->id;?>)">
                                                        Save
                                                    </button>
                                                </td>
                                            </tr>
                                        </form>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-success" type="button" id="openrostermodal">
                                        <i class="fa fa-plus"></i> Add more teams
                                    </button>
                                </div>
                            </div>
                            <div id="edit_roster_container">

                            </div>
                        </div>
                    </div>
                </div>


                <!-----------updated by David, 2017-03-23,  Niche Setting----------------- -->
                <div class="panel panel-default" id="niche">
                    <div class="panel-heading" role="tab" id="heading21">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse21" aria-expanded="false" aria-controls="collapse21">
                                <em class="fa fa-fw fa-plus"></em> Niche Settings
                            </a>
                        </h4>
                    </div>
                    <div id="collapse21" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading22"
                         aria-expanded="false">
                        <div class="panel-body" id="niche_panel_body">
                            <div class="panel">
                                <form class="form-horizontal" method="post" name="niche_form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="panel-body">
                                        <div class="section_title" style="width: 30%;margin-bottom:20px;">Terms & Conditions</div>
                                        <div class="col-md-12">
                                            <textarea class="form-control" style="width: 50%;min-width: 300px;" rows="7" name="terms" id="terms">@if($niche->value) {{ $niche->value }} @endif</textarea>
                                        </div>
                                        <div class="col-md-12" style="margin-top:15px;">
                                            <button class="btn btn-success" id="addBlock" value="" type="button"> <i class="fa fa-plus"></i> Add Block</button>&nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-primary" id="save_terms_btn" value="" type="button"> <i class="fa fa-save"></i> Save</button>
                                        </div>
                                        <div class="panel-group col-md-12 col-sm-12" id="accordion" role="tablist" aria-multiselectable="true" style="padding-top:20px;">
                                            @if($niche_blocks)
                                                @foreach($niche_blocks as $niche_block)
                                                    <div class="col-md-12" style="margin-bottom: 0;">
                                                        <div class="panel panel-default" id="panel_{{ $niche_block->id }}">
                                                            <div class="panel-heading" role="tab" id="heading_{{ $niche_block->id }}" style="border-bottom: 1px solid #919191;">
                                                                <a class="" id="panelLabel_{{ $niche_block->id }}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $niche_block->id }}" aria-expanded="true" aria-controls="collapse_{{ $niche_block->id }}" style="font-size:15px;"> &nbsp;&nbsp;{{ $niche_block->name }} </a>
                                                                <input type="hidden" id="panelName_{{ $niche_block->id }}" name="panelName_{{ $niche_block->id }}" value="{{ $niche_block->name }}">
                                                                <div class="actions_div" style="position: relative; top: -20px;">
                                                                    <a href="#" accesskey="{{ $niche_block->id }}" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                                                    <a href="#" accesskey="{{ $niche_block->id }}" class="edit_ctg_label pull-right"><span class="glyphicon glyphicon-edit "></span> Edit</a>
                                                                </div>
                                                            </div>
                                                            <div id="collapse_{{ $niche_block->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{ $niche_block->id }}">
                                                                <div class="panel-body" id="block_panel_{{ $niche_block->id }}">
                                                                    <div class="col-md-12" style="min-height: 50px;"><a href="#" accesskey="{{ $niche_block->id }}" class="btn btn-success" id="addButton2"> <i class="fa fa-plus"></i> Add Suite</a></div>

                                                                    @foreach($niche_block->niche_suites as $niche_suite)
                                                                        <div class="col-md-12" style="margin-bottom: 0;">
                                                                            <div class="panel panel-default" id="panel_{{ $niche_block->id }}_{{ $niche_suite->id }}">
                                                                                <div class="panel-heading" role="tab" id="suite_heading_{{ $niche_block->id }}_{{ $niche_suite->id }}" style="border-bottom: 1px solid #919191;">
                                                                                    <a class="" id="panelLabel_{{ $niche_block->id }}_{{ $niche_suite->id }}" role="button" data-toggle="collapse" data-parent="#accordion" href="#suite_collapse_{{ $niche_block->id }}_{{ $niche_suite->id }}" aria-expanded="true" aria-controls="suite_collapse_{{ $niche_block->id }}_{{ $niche_suite->id }}" style="font-size:14px;"> &nbsp;&nbsp;{{ $niche_suite->name }} </a>
                                                                                    <input type="hidden" id="panelName_{{ $niche_block->id }}_{{ $niche_suite->id }}" name="panelName_{{ $niche_block->id }}_{{ $niche_suite->id }}" value="{{ $niche_suite->name }}">
                                                                                    <div class="actions_div" style="position: relative; top: -20px;">
                                                                                        <a href="#" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                        <a href="#" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}" class="edit_ctg_label pull-right"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div id="suite_collapse_{{ $niche_block->id }}_{{ $niche_suite->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="suite_heading_{{ $niche_block->id }}_{{ $niche_suite->id }}">
                                                                                    <div class="panel-body" id="suite_{{ $niche_block->id }}_{{ $niche_suite->id }}">
                                                                                        <div class="col-md-12" style="min-height: 50px;"><a href="#" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}" class="btn btn-success" id="addButton3"> <i class="fa fa-plus"></i> Add Section</a></div>
                                                                                        @foreach($niche_suite->niche_sections as $niche_section)
                                                                                            <div class="col-md-12" style="margin-bottom: 0;">
                                                                                                <div class="panel panel-default" id="panel_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}">
                                                                                                    <div class="panel-heading" role="tab" id="section_heading_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" style="border-bottom: 1px solid #919191;">
                                                                                                        <a class="" id="panelLabel_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" role="button" data-toggle="collapse" data-parent="#accordion" href="#section_collapse_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" aria-expanded="true" aria-controls="section_collapse_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" style="font-size:13px;"> &nbsp;&nbsp;{{ $niche_section->name }} </a><input type="hidden" id="panelName_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" name="panelName_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" value="{{ $niche_section->name }}">
                                                                                                        <div class="actions_div" style="position: relative; top: -20px;">
                                                                                                            <a href="#" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                                            <a href="#" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" class="edit_ctg_section pull-right" ><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div id="section_collapse_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" class="panel-collapse collapse"role="tabpanel" aria-labelledby="section_heading_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}">
                                                                                                        <div class="panel-body" id="section_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}">
                                                                                                            <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                    <div class="col-md-offset-1 col-md-11" style="padding:10px;">
                                                                                                                        <button class="btn btn-primary" id="save_section_btn" value="" type="button" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}"> <i class="fa fa-save"></i> Save</button>
                                                                                                                    </div>
                                                                                                                    <label for="sectionText_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" class="col-md-1 col-form-label" style="text-align:right;" value="{{ $niche_section->name }}">Name</label>
                                                                                                                    <div class="col-md-11">
                                                                                                                        <input class="form-control" type="text" value="{{ $niche_section->name }}" id="sectionText_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-group">
                                                                                                                    <label for="sectionDescription_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" class="col-md-1 col-form-label" style="text-align:right;">Description</label>
                                                                                                                    <div class="col-md-11">
                                                                                                                        <textarea class="form-control" id="sectionDescription_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" rows="5">{{ $niche_section->description }}</textarea>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <?php $rows = App\NicheRow::where('niche_section_id', $niche_section->id)->count(); $rowspan = $rows + 1;?>
                                                                                                                <?php $leftColumns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'left')->count(); ?>
                                                                                                                <?php $rightColumns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'right')->count(); ?>
                                                                                                                <?php $columns = $leftColumns + $rightColumns; ?>
                                                                                                                @if($rows > 0)
                                                                                                                <div class="col-md-2 col-lg-1" style="padding:10px;"><button type="button" style="width:100%; min-height: 100px; text-wrap: none;" class="btn btn-default" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" id="add_left_column">Add Column to left aisle</button></div>
                                                                                                                <div class="col-md-8 col-lg-10 table-responsive" style="text-align:center;">
                                                                                                                    <table class="table table-bordered" id="empty_table_{{ $niche_section->id }}" style="display:none;"><tr style="min-height: 50px;"><td>&nbsp;</td><td align="center">Entrance</td><td>&nbsp;</td></tr></table>
                                                                                                                    <table class="table table-bordered suite-table" id="suiteTable_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" leftcolumns="@if($leftColumns >0){{ $leftColumns+1 }}@else 1 @endif" rightcolumns="@if($rightColumns >0){{ $rightColumns+1 }}@else 1 @endif">
                                                                                                                        <tr>
                                                                                                                            <td style="width:30px;"></td>
                                                                                                                            <td></td>
                                                                                                                            @if($leftColumns > 0)
                                                                                                                                <?php $left_columns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                                                                                                                                @foreach($left_columns as $left_column)
                                                                                                                                <?php
                                                                                                                                    $cell_count = App\NicheCell::where('niche_column_id', $left_column->id)->whereIn('status', [0,2])->count();
                                                                                                                                    if($cell_count > 0)
                                                                                                                                        $remove_class="";
                                                                                                                                    else
                                                                                                                                        $remove_class = "remove_ctg_td";
                                                                                                                                ?>
                                                                                                                                <td columnid="{{ $left_column->id }}" side="left"><a href="#" accesskey="left" tdkey="{{ $left_column->id }}" class="edit_td_text">{{ $left_column->name }}</a>&nbsp;&nbsp;<a href="#" accesskey="left" class="{{ $remove_class }} exit-btn"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                                                                                @endforeach
                                                                                                                            @else
                                                                                                                            <td side="left" style="display: none;"></td>
                                                                                                                            @endif

                                                                                                                            <?php if($rows == 0) $rowspan = 2; else $rowspan=$rowspan+1; ?>
                                                                                                                            <td align="center" class="border-td" rowspan="{{$rowspan}}" style="width: 30px;vertical-align:middle;" id="entrance_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}">Entrance</td>

                                                                                                                            @if($rightColumns > 0)
                                                                                                                            <?php $right_columns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                                                                                                                                @foreach($right_columns as $right_column)

                                                                                                                                    <?php
                                                                                                                                    $cell_count = App\NicheCell::where('niche_column_id', $right_column->id)->whereIn('status', [0,2])->count();
                                                                                                                                    if($cell_count > 0)
                                                                                                                                        $remove_class="";
                                                                                                                                    else
                                                                                                                                        $remove_class = "remove_ctg_td";
                                                                                                                                    ?>
                                                                                                                                    <td columnid="{{ $right_column->id }}" side="right"><a href="#" accesskey="left" tdkey="{{ $right_column->id }}" class="edit_td_text">{{ $right_column->name }}</a>&nbsp;&nbsp;<a href="#" accesskey="left" class="{{ $remove_class }} exit-btn"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                                                                                @endforeach
                                                                                                                            @else
                                                                                                                            <td side="right" style="display:none;"></td>
                                                                                                                            @endif
                                                                                                                            <td></td>
                                                                                                                        </tr>

                                                                                                                        <?php $rrows = App\NicheRow::where('niche_section_id', $niche_section->id)->orderby('sort_order')->get(); ?>

                                                                                                                        @foreach($rrows as $row)
                                                                                                                            <?php
                                                                                                                            $cell_count = App\NicheCell::where('niche_row_id', $row->id)->whereIn('status', [0,2])->count();
                                                                                                                            if($cell_count > 0)
                                                                                                                                $remove_class="";
                                                                                                                            else
                                                                                                                                $remove_class = "remove_ctg_tr";
                                                                                                                            ?>
                                                                                                                            <tr rowid="{{ $row->id }}">
                                                                                                                                <td style="width:30px;"><a rindex="'{{ $rowspan }}" href="#" accesskey="{{ $row->id }}" class="{{ $remove_class }} exit-btn"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                                                                                <td><a rindex="'{{ $rowspan }}" href="#" accesskey="{{ $row->id }}" class="edit_tr_text">{{ $row->name }}</a></td>
                                                                                                                                @if($leftColumns > 0)
                                                                                                                                    <?php $left_columns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                                                                                                                                    @foreach($left_columns as $left_column)
                                                                                                                                        <?php $cell = App\NicheCell::where('niche_row_id', $row->id)->where('niche_column_id', $left_column->id)->first(); ?>
                                                                                                                                        @if($cell)
                                                                                                                                            <?php
                                                                                                                                                if($cell->status == 0){
                                                                                                                                                    $style = "background-color:#92cf51;";
                                                                                                                                                    $edit_class = "";
                                                                                                                                                }

                                                                                                                                                if($cell->status == 1){
                                                                                                                                                    $style = "background-color:#fff;";
                                                                                                                                                    $edit_class = "re-editable";
                                                                                                                                                }

                                                                                                                                                if($cell->status == 2){
                                                                                                                                                    $style = "background-color:yellow;";
                                                                                                                                                    $edit_class = "re-editable";
                                                                                                                                                }

                                                                                                                                                if($cell->status == 3) {
                                                                                                                                                    $style = "background-color:#abb8ca;";
                                                                                                                                                    $edit_class = "re-editable";
                                                                                                                                                }

                                                                                                                                            ?>
                                                                                                                                            <td class="border-td {{ $edit_class }}" columnid="{{ $cell->niche_column_id }}" side="left" id="td_{{ $cell->niche_row_id }}_{{ $cell->niche_column_id }}" cellid="{{ $cell->id }}" style="{{ $style }}">
                                                                                                                                                {{ $cell->name }}
                                                                                                                                            </td>
                                                                                                                                        @else
                                                                                                                                            <td class="border-td editable" cellid="" id="td_{{ $row->id }}_{{ $left_column->id }}" side="left" columnid="{{$left_column->id}}"></td>
                                                                                                                                        @endif

                                                                                                                                    @endforeach
                                                                                                                                @else
                                                                                                                                    <td side="left" class="border-td editable" style="display:none"></td>
                                                                                                                                @endif

                                                                                                                                @if($rightColumns > 0)
                                                                                                                                    <?php $right_columns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                                                                                                                                    @foreach($right_columns as $right_column)
                                                                                                                                        <?php $cell = App\NicheCell::where('niche_row_id', $row->id)->where('niche_column_id', $right_column->id)->first(); ?>
                                                                                                                                        @if($cell)
                                                                                                                                            <?php
                                                                                                                                                if($cell->status == 0){
                                                                                                                                                    $style = "background-color:#92cf51;";
                                                                                                                                                    $edit_class = "";
                                                                                                                                                }

                                                                                                                                                if($cell->status == 1){
                                                                                                                                                    $style = "background-color:#fff;";
                                                                                                                                                    $edit_class = "re-editable";
                                                                                                                                                }

                                                                                                                                                if($cell->status == 2){
                                                                                                                                                    $style = "background-color:yellow;";
                                                                                                                                                    $edit_class = "re-editable";
                                                                                                                                                }

                                                                                                                                                if($cell->status == 3) {
                                                                                                                                                    $style = "background-color:#abb8ca;";
                                                                                                                                                    $edit_class = "re-editable";
                                                                                                                                                }
                                                                                                                                            ?>
                                                                                                                                            <td class="border-td {{ $edit_class }}" columnid="{{ $cell->niche_column_id }}" side="left" id="td_{{ $cell->niche_row_id }}_{{ $cell->niche_column_id }}" cellid="{{ $cell->id }}" style="{{ $style }}">
                                                                                                                                                {{ $cell->name }}
                                                                                                                                            </td>
                                                                                                                                        @else
                                                                                                                                            <td class="border-td editable" cellid="" id="td_{{ $row->id }}_{{ $right_column->id }}" side="left" columnid="{{$right_column->id}}"></td>
                                                                                                                                        @endif
                                                                                                                                    @endforeach
                                                                                                                                @else
                                                                                                                                    <td side="right" class="border-td editable" style="display: none;"></td>
                                                                                                                                @endif
                                                                                                                                <td><a rindex="'{{ $rowspan }}" href="#" accesskey="{{ $row->id }}" class="edit_tr_text exit-btn">{{ $row->name }}</a></td>
                                                                                                                            </tr>
                                                                                                                        @endforeach
                                                                                                                    </table><br>
                                                                                                                    <button type="button" class="btn btn-default" style="width:100%;margin-bottom: 10px;min-width:150px;" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" id="add_row">Add Row</button>
                                                                                                                </div>
                                                                                                                <div class="col-md-2 col-lg-1" style="padding:10px;"><button type="button" class="btn btn-default" style="width:100%; min-height: 100px; text-wrap: none;" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" id="add_right_column">Add Column to right aisle</button></div>
                                                                                                                <div class="col-md-offset-1 col-md-11">
                                                                                                                    <table class="table table-bordered" id="legend_table" style="width:300px;">
                                                                                                                        <tr><td style="min-height: 30px; font-size:14px;" colspan="2">Legend</td></tr>
                                                                                                                        <tr><td style="width:100px; background: yellow; height:30px;">&nbsp;</td><td>Not Avail</td></tr>
                                                                                                                        <tr><td style="width:100px;background: #fff; height:30px;">&nbsp;</td><td>Avail</td></tr>
                                                                                                                        <tr><td style="width:100px;background: #92cf51; height:30px;">&nbsp;</td><td>On Hold</td></tr>
                                                                                                                        <tr><td style="width:100px;background: #abb8ca; height:30px;">&nbsp;</td><td>Future Development</td></tr>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                                @else
                                                                                                                    <div class="col-md-2 col-lg-1" style="padding:10px;"><button type="button" style="width:100%; min-height: 100px; text-wrap: none;" class="btn btn-default" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" id="add_left_column">Add Column to left aisle</button></div>
                                                                                                                    <div class="col-md-8 col-lg-10 table-responsive" style="text-align:center;">
                                                                                                                        <table class="table table-bordered" id="empty_table_{{ $niche_section->id }}" style="display:none;"><tr style="min-height: 50px;"><td>&nbsp;</td><td align="center">Entrance</td><td>&nbsp;</td></tr></table>
                                                                                                                        <table class="table table-bordered suite-table" id="suiteTable_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" leftcolumns="@if($leftColumns >0){{ $leftColumns+1 }}@else 1 @endif" rightcolumns="@if($rightColumns >0){{ $rightColumns+1 }}@else 1 @endif">
                                                                                                                            <tr>
                                                                                                                                <td style="width:30px;"></td>
                                                                                                                                <td></td>
                                                                                                                                @if($leftColumns > 0)
                                                                                                                                    <?php $left_columns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                                                                                                                                    @foreach($left_columns as $left_column)
                                                                                                                                        <?php
                                                                                                                                        $cell_count = App\NicheCell::where('niche_column_id', $left_column->id)->whereIn('status', [0,2])->count();
                                                                                                                                        if($cell_count > 0)
                                                                                                                                            $remove_class="";
                                                                                                                                        else
                                                                                                                                            $remove_class = "remove_ctg_td";
                                                                                                                                        ?>
                                                                                                                                        <td columnid="{{ $left_column->id }}" side="left"><a href="#" accesskey="left" tdkey="{{ $left_column->id }}" class="edit_td_text">{{ $left_column->name }}</a>&nbsp;&nbsp;<a href="#" accesskey="left" class="{{ $remove_class }} exit-btn"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                                                                                    @endforeach
                                                                                                                                @else
                                                                                                                                    <td side="left" style="display: none;"></td>
                                                                                                                                @endif

                                                                                                                                <?php if($rows == 0) $rowspan = 2; else $rowspan=$rowspan+1; ?>
                                                                                                                                <td align="center" class="border-td" rowspan="{{$rowspan}}" style="width: 30px;vertical-align:middle;" id="entrance_{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}">Entrance</td>

                                                                                                                                @if($rightColumns > 0)
                                                                                                                                    <?php $right_columns = App\NicheColumn::where('niche_section_id', $niche_section->id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                                                                                                                                    @foreach($right_columns as $right_column)

                                                                                                                                        <?php
                                                                                                                                        $cell_count = App\NicheCell::where('niche_column_id', $right_column->id)->whereIn('status', [0,2])->count();
                                                                                                                                        if($cell_count > 0)
                                                                                                                                            $remove_class="";
                                                                                                                                        else
                                                                                                                                            $remove_class = "remove_ctg_td";
                                                                                                                                        ?>
                                                                                                                                        <td columnid="{{ $right_column->id }}" side="right"><a href="#" accesskey="left" tdkey="{{ $right_column->id }}" class="edit_td_text">{{ $right_column->name }}</a>&nbsp;&nbsp;<a href="#" accesskey="left" class="{{ $remove_class }} exit-btn"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                                                                                    @endforeach
                                                                                                                                @else
                                                                                                                                    <td side="right" style="display:none;"></td>
                                                                                                                                @endif
                                                                                                                                <td></td>
                                                                                                                            </tr>
                                                                                                                            <tr style="display: none;">
                                                                                                                                <td style="width:30px;"></td><td>[Row Text]</td>
                                                                                                                                @if($leftColumns > 0)
                                                                                                                                    @for($i=0; $i<$leftColumns; $i++)
                                                                                                                                        <td side="left" class="border-td"></td>
                                                                                                                                    @endfor
                                                                                                                                @else
                                                                                                                                    <td side="left" class="border-td"></td>
                                                                                                                                @endif
                                                                                                                                @if($rightColumns > 0)
                                                                                                                                    @for($i=0; $i<$leftColumns; $i++)
                                                                                                                                        <td side="right" class="border-td"></td>
                                                                                                                                    @endfor
                                                                                                                                @else
                                                                                                                                    <td side="right" class="border-td"></td>
                                                                                                                                @endif
                                                                                                                                <td>[RowText]</td></tr>
                                                                                                                        </table>
                                                                                                                        <button type="button" class="btn btn-default" style="width:100%;margin-bottom: 10px;min-width:150px;" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" id="add_row">Add Row</button>
                                                                                                                    </div>
                                                                                                                    <div class="col-md-2 col-lg-1" style="padding:10px;"><button type="button" style="width:100%; min-height: 100px; text-wrap: none;" class="btn btn-default" accesskey="{{ $niche_block->id }}_{{ $niche_suite->id }}_{{ $niche_section->id }}" id="add_right_column">Add Column to right aisle</button></div>
                                                                                                                    <div class="col-md-offset-1 col-md-11">
                                                                                                                        <table class="table table-bordered" id="legend_table" style="width:300px;">
                                                                                                                            <tr><td style="min-height: 30px; font-size:14px;" colspan="2">Legend</td></tr>
                                                                                                                            <tr><td style="width:100px; background: yellow; height:30px;">&nbsp;</td><td>Not Avail</td></tr>
                                                                                                                            <tr><td style="width:100px;background: #fff; height:30px;">&nbsp;</td><td>Avail</td></tr>
                                                                                                                            <tr><td style="width:100px;background: #92cf51; height:30px;">&nbsp;</td><td>On Hold</td></tr>
                                                                                                                            <tr><td style="width:100px;background: #abb8ca; height:30px;">&nbsp;</td><td>Future Development</td></tr>
                                                                                                                        </table>
                                                                                                                    </div>

                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--------------------------------------------------------->

            </div>
        </div>
    </div>



    <div class="modal fade" id="add_ala_carte_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">FA Ala-carte Items Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group" style="padding: 15px">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="" class="form-control"/>
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
                            <input type="text" id="selection_category" name="selection_category" class="form-control"/>
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected"
                                   class="form-control"/>
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name"
                                   class="form-control"/>
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control"/>
                            <label class="control-label">Image</label>
                            <input type="file" id="ala_carte_images" name="image" value="" multiple="true"
                                   accepts="image/*" class="form-control"/>
                            <input type="hidden" name="unit_price" value="" class="form-control"/>
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

    <!--   For point 5 -->
    <div class="modal fade" id="add_columbarium_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Columbarium Items Settings</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="padding: 15px">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="" class="form-control"/>
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
                            <input type="text" id="selection_category" name="selection_category" class="form-control"/>
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected"
                                   class="form-control"/>
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name"
                                   class="form-control"/>
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control"/>
                            <label class="control-label">Image</label>
                            <input type="file" id="columbarium_images" name="image" value="" multiple="true"
                                   accepts="image/*" class="form-control"/>
                            <input type="hidden" name="unit_price" value="" class="form-control"/>
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

    <!-- modal pop up end  @ copy ala-carte -->
    <div class="modal fade" id="add_hearse_items_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hearse Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="order_nr" value="" class="form-control"/>

                            <label class="control-label" for="inputWarning1">Hearse name</label>
                            <input type="text" name="hearse_name" value="" class="form-control"/>
                            <br/>
                            <label class="control-label">Image</label>
                            <input type="file" name="image" value="" class="form-control"/>
                            <br/>
                            <label class="control-label">Unit Price</label>
                            <input type="text" name="unit_price" value="" class="form-control"/>

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">FA Individual Sales Items Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="" class="form-control"/>

                            <label class="control-label" for="inputWarning1">Package name</label>

                            <input name="package_name" id="package_name" class="form-control"/>

                            <div style="height: 20px"></div>
                            <label class="control-label">Selection category</label>
                            <input type="text" id="selection_category" name="selection_category" class="form-control"/>
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected"
                                   class="form-control"/>
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name"
                                   class="form-control"/>
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control"/>

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

                            <input type="hidden" name="unit_price" value="" class="form-control"/>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Parlour Settings</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="order_nr" value="" class="form-control"/>

                            <label class="control-label" for="inputWarning1">Parlour name</label>
                            <input type="text" name="parlour_name" value="" class="form-control"/>
                            <br/>
                            <label class="control-label" for="inputWarning1">Capacity</label>
                            <input type="text" name="capacity" value="" class="form-control"/>
                            <br/>
                            <label class="control-label">Image</label>
                            <input type="file" id="parlour_images" name="image" value="" multiple="true"
                                   accepts="image/*" class="form-control"/>
                            <br/>
                            <label class="control-label">Unit Price</label>
                            <input type="text" name="unit_price" value="" class="form-control"/>

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <form>
                            {!! csrf_field() !!}
                            <input type="hidden" id="item_type" name="elem" value=""/>
                            <input type="hidden" id="id" name="id" value=""/>

                            <label class="control-label" id="package_label">Package name</label>

                            <input name="package_name" id="package_name" class="form-control"/>


                            <label class="control-label" id="category_label">Category Name</label>

                            <input type="text" name="category_name" id="category_name" class="form-control"/>
                            <input type="hidden" name="category_name_selected" id="category_name_selected"
                                   class="form-control"/>

                            <div style="height: 20px"></div>
                            <label class="control-label">Selection category</label>
                            <input type="text" id="selection_category" name="selection_category" class="form-control"/>
                            <input type="hidden" id="selection_category_selected" name="selection_category_selected"
                                   class="form-control"/>
                            <div style="height: 20px"></div>
                            <label class="control-label">Selection item</label>
                            <input type="text" id="selection_item_name" name="selection_item_name"
                                   class="form-control"/>
                            <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control"/>

                            <!-- For Point 1 -->
                            <label class="control-label">Image</label>
                            <input type="file" id="" name="image" value="" multiple="true" accepts="image/*"
                                   class="form-control"/>

                            <!--   -->
                            <input type="hidden" name="unit_price" value="" class="form-control"/>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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

    <div class="modal fade" id="roster_settings_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add new Team</h4>
                </div>

                <div class="modal-body">
                    <div class="spanmsg" id="spanmsg"></div>
                    <form name="addrostersettings" method="post" id="roster_settings_form">
                        <?php echo csrf_field() ?>
                        <table>
                            <tr>
                                <td>
                                    Team:
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="team_name" id="team_name" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Team Leader:
                                </td>
                                <td>
                                    <?php if (!empty($users)) { ?>
                                    <select class="form-control" name="team_leader[]" data-toggle="select2" multiple="">
                                        <?php foreach ($users as $user) {?>
                                        <option value="<?php echo $user->nickname;?>">
                                            <?php echo $user->nickname;?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Embalmers:
                                </td>
                                <td>
                                    <?php if (!empty($users)) { ?>
                                    <select class="form-control" name="embalmers[]" data-toggle="select2" multiple="">
                                        <?php foreach ($users as $user) {?>
                                        <option value="<?php echo $user->nickname;?>">
                                            <?php echo $user->nickname;?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Others:
                                </td>
                                <td>
                                    <?php if (!empty($users)) { ?>
                                    <select class="form-control" name="others[]" data-toggle="select2" multiple="">
                                        <?php foreach ($users as $user) {?>
                                        <option value="<?php echo $user->nickname;?>">
                                            <?php echo $user->nickname;?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Add to Roster:
                                </td>
                                <td>
                                    <select class="form-control" id="add_to_roster" name="add_to_roster">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="btn btn-primary" type="submit" name="submit" id="roster_save_bttn"
                                           value="Add Team"/>

                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="niche_block_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Block</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="inputWarning1">Block Name</label>
                        <input type="text" name="new_block_name" id="new_block_name" value="" class="form-control" maxlength="30"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="add_new_block">SAVE</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="niche_suite_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Suite</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="inputWarning1">Suite Name</label>
                        <input type="text" name="new_suite_name" id="new_suite_name" value="" class="form-control" maxlength="30"/>
                        <input type="hidden" name="suite_key" id="suite_key" value="" class="form-control" maxlength="20"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="add_new_suite">SAVE</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="niche_section_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Section</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="new_section_name">Section Name</label>
                        <input type="text" name="new_section_name" id="new_section_name" value="" class="form-control" maxlength="30"/>
                        <label class="control-label" for="section_description">Description</label>
                        <textarea name="section_description" id="section_description" class="form-control"/></textarea>
                        <input type="hidden" name="section_key" id="section_key" value="" class="form-control" maxlength="20"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="add_new_section">SAVE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="label_edit_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Name</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="inputWarning1">Name</label>
                        <input type="text" name="new_label_name" id="new_label_name" value="" class="form-control" maxlength="30"/>
                        <input type="hidden" name="accesskey" id="accesskey" value="" class="form-control"/>
                        <input type="hidden" name="element_type" id="element_type" value="" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="edit_save_button">SAVE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="table_row_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Row</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="row_text">Row Text</label>
                        <input type="text" name="row_text" id="row_text" value="" class="form-control" maxlength="30"/>
                        <input type="hidden" name="tbl_accesskey" id="tbl_accesskey" value="" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="row_position">Create row</label>
                        <select id="row_position" class="form-control">
                            <option value="below">Below</option>
                            <option value="above">Above</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="current_row">of row</label>
                        <select id="current_row" class="form-control">
                            <option value="0">Select Row</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="add_row_button">Add Row</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="table_column_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Column</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="column_text">Column Text</label>
                        <input type="text" name="column_text" id="column_text" value="" class="form-control" maxlength="30"/>
                        <input type="hidden" name="tbl_accesskey" id="tbl_accesskey" value="" class="form-control"/>
                        <input type="hidden" name="tbl_side" id="tbl_side" value="" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="column_position">Create column on the</label>
                        <select id="column_position" class="form-control">
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="current_column">of column</label>
                        <select id="current_column" class="form-control">
                            <option value="0">Select Column</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="add_column_button">Add Column</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="cell_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cell Information</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="cell_status">Status</label>&nbsp;&nbsp;&nbsp;
                        {{--<label class="radio-inline"><input type="radio" name="cell_status" id="cell_status" value="0" /> On Hold</label>--}}
                        <label class="radio-inline"><input type="radio" name="cell_status" id="cell_status" value="1" /> Available</label>
                        <label class="radio-inline"><input type="radio" name="cell_status" id="cell_status" value="2" /> Not Available</label>
                        <label class="radio-inline"><input type="radio" name="cell_status" id="cell_status" value="3" /> Future Development</label>

                        <input type="hidden" name="row_id" id="row_id" />
                        <input type="hidden" name="column_id" id="column_id" />
                        <input type="hidden" name="cell_act" id="cell_act" />
                        <input type="hidden" name="cell_id" id="cell_id" />
                        <input type="hidden" name="td_index" id="td_index" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="cell_name">Name</label>
                        <input type="text" name="cell_name" id="cell_name" value="" class="form-control" maxlength="30"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="cell_description">Description</label>
                        <textarea name="cell_description" id="cell_description" class="form-control" maxlength="100"/></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="selling_price">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" step='0.01' placeholder='0.00' class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="maintenance_fee">Maintenance Fees</label>
                        <input type="number" name="maintenance_fee" id="maintenance_fee" step='0.01' placeholder='0.00' class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="cell_type">Type</label>
                        <input type="text" name="cell_type" id="cell_type" value="" class="form-control" maxlength="30"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="cell_info_button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="info_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3498db;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" style="color:#fff; font-weight: bold;">Information</h4>
                </div>
                <div class="modal-body" style="font-size:14px;">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@push('css')
<link href="{{ url('')}}/css/app/settings.css" rel="stylesheet">
@endpush


@push('scripts')
<script src="{{ url('')}}/js/vendor/core/jquery-ui/autocomplete.js"></script>
<script src="{{ url('')}}/js/app/settings.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tbl_listing_roster [id^=roster_edit]").click(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('')}}/settings/edit_roster_setting",
                method: "GET",
                dataType: "html",
                data: {id: $(this).attr("id").replace("roster_edit_", "")},

                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (html) {

                $("#edit_roster_container").html(html);
                $("#edit_roster_container").show();

            });
        });

        $("#tbl_listing_roster [id^=roster_delete]").click(function (e) {
            e.preventDefault();

            if (confirm("Are you sure?")) {
                $.ajax({
                    url: "{{ url('')}}/settings/delete_roster_setting",
                    method: "GET",
                    data: {id: $(this).attr("id").replace("roster_delete_", "")},
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (html) {

                    $.ajax({
                        url: "{{ url('')}}/settings/list_roster_setting",
                        method: "GET",
                        dataType: "html",

                        statusCode: {
                            401: function () {
                                alert("Login expired. Please sign in again.");
                            }
                        }
                    }).done(function (html) {
                        location.reload();
                    });
                });
            }
        });

        $('#roster_settings_form').on("submit", function (e) {
            e.preventDefault();
            $('#spanmsg').html("");
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: '{{ url('')}}/settings/save_roster_setting',
                    data: $(this).serialize(),
                    type: 'POST',
                    success: function (results) {
                        var res = $.parseJSON(results);
                        if (res.result == 'success') {
                            $('#spanmsg').html('<span class="alert alert-success">' + res.message + '</span>');
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            $('#spanmsg').html('<span class="alert alert-danger">' + res.message + '</span>');
                        }
                    }
                });
            }
        });

        $('#openrostermodal').click(function (e) {
            e.preventDefault();
            $('#roster_settings_popup').modal();
        });

        /////////////////////////////////////////////////////////////////////////////////////////////////

        /********Developed by Dorin********/

        var wrapper = $("#accordion");

        //Gemstone Save Terms & Conditions
        $('#save_gemstone_btn').on('click', function(e){
            e.preventDefault();
            var terms = $('#gemstone_terms').val();
            if(terms == '') {
                $('#terms').focus();
                return false;
            }
            //Save Terms & Conditions
            $.ajax({
                url: "{{ url('')}}/settings/gemstone_setting",
                method: "POST",
                data: {terms: terms,"_token": "{{ csrf_token() }}",},
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (msg) {
                $('#info_modal').find(".modal-body").html('<p>'+msg+'</p>');
                $('#info_modal').modal();
            });
        });

        //Niche Save Terms & Conditions
        $('#save_terms_btn').on('click', function(e){
            e.preventDefault();
            var terms = $('#terms').val();
            if(terms == '') {
                $('#terms').focus();
                return false;
            }
            //Save Terms & Conditions
            $.ajax({
                url: "{{ url('')}}/settings/niche_setting",
                method: "POST",
                data: {terms: terms,"_token": "{{ csrf_token() }}",},
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (msg) {
                $('#info_modal').find(".modal-body").html('<p>'+msg+'</p>');
                $('#info_modal').modal();
            });
        });
        //-------------------------------------------------


        //Add New Block
        $("#addBlock").on("click", function(e){
            e.preventDefault();
            $('#new_block_name').val('');
            $('#niche_block_popup').modal();
        });

        $("#add_new_block").on("click", function(e) {
            e.preventDefault();
            var blockName = $('#new_block_name').val();

            if(blockName.length > 0){
                var ariaExpanded = true;
                var expandedClass = 'in';
                var collapsedClass = '';

                //Save Block into DB and Show Block
                $.ajax({
                    url: "{{ url('')}}/settings/add_niche_block",
                    method: "POST",
                    data: {block: blockName, "_token": "{{ csrf_token() }}",},
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (block_id) {
                    $(wrapper).append('<div class="col-md-12" style="margin-bottom: 0;"><div class="panel panel-default" id="panel_'+ block_id +'">' +
                            '<div class="panel-heading" role="tab" id="heading_'+ block_id +'" style="border-bottom: 1px solid #919191;">' +
                            '<a class="'+collapsedClass+'" id="panelLabel_'+ block_id +'" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_'+ block_id +'" ' +
                            'aria-expanded="'+ariaExpanded+'" aria-controls="collapse_'+ block_id +'" style="font-size:15px;"> &nbsp;&nbsp;'+blockName+' </a>' +
                            '<input type="hidden" id="panelName_'+ block_id +'" name="panelName_'+ block_id +'" value="'+blockName+'">' +
                            '<div class="actions_div" style="position: relative; top: -20px;">' +
                            '<a href="#" accesskey="'+ block_id +'" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>' +
                            '<a href="#" accesskey="'+ block_id +'" class="edit_ctg_label pull-right"><span class="glyphicon glyphicon-edit "></span> Edit</a>' +
                            '</div></div>' +
                            '<div id="collapse_'+ block_id +'" class="panel-collapse collapse '+expandedClass+'" role="tabpanel" aria-labelledby="heading_'+ block_id +'">'+
                            '<div class="panel-body" id="block_panel_'+ block_id +'">' +
                            '<div class="col-md-12" style="min-height: 50px;"><a href="#" accesskey="'+ block_id +'" class="btn btn-success" id="addButton2"> <i class="fa fa-plus"></i> Add Suite</a></div>' +
                            '</div></div></div></div>');
                });

                $('#niche_block_popup').modal('hide');
            }
            else{
                $('#new_block_name').focus();
                return false;
            }
        });

        //Edit Block & Suite Name
        $(wrapper).on("click",".edit_ctg_label", function(e){
            e.preventDefault();
            var panelId = $(this).attr('accesskey');
            $('#accesskey').val(panelId);
            var oldName = $('#panelName_'+panelId).val();
            $('#new_label_name').val(oldName);
            $('#label_edit_popup').modal();

        });


        $('#edit_save_button').on("click", function(e){
            e.preventDefault();
            var panelId = $('#accesskey').val();
            var newName = $('#new_label_name').val();
            var id;
            var element_kind;
            var element_type = $('#element_type').val();

            if(newName == ''){
                return false;
            }
            if(newName != null){

                var idArray = panelId.split('_');
                if(element_type == '') {
                    if(idArray.length > 1) { //Suite
                        id = idArray[1];
                        element_kind = 'suite'
                    } else{// Block
                        id = panelId;
                        element_kind = 'block'
                    }
                }
                else { //Row and Column
                    id = panelId;
                    element_kind = element_type;
                }



                $.ajax({
                    url: "{{ url('')}}/settings/update_niche_block_suite",
                    method: "POST",
                    data: {
                        id: id,
                        element_name: newName,
                        element_kind: element_kind,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (eid) {

                    if(element_kind == 'row_edit') {
                        $('.edit_tr_text[accesskey="'+ eid +'"]').html(newName);

                    } else if(element_kind == 'column_edit') {
                        $('.edit_td_text[tdkey="'+ eid +'"]').html(newName);
                    } else {
                        $('#panelName_'+panelId).val(newName);
                        $('#panel_'+panelId).find("#panelLabel_"+panelId).html('&nbsp;&nbsp;'+newName);
                    }
                    $('#label_edit_popup').modal('hide');

                });
            }
        });

        //Delete Block & Suite Panel
        $(wrapper).on("click",".remove_ctg_panel", function(e){
            e.preventDefault();
            var accesskey = $(this).attr('accesskey');
            var id;
            var element_kind;

            if (confirm("Are you sure?")) {

                var idArray = accesskey.split('_');
                if(idArray.length == 2 ) { //Suite
                    id = idArray[1];
                    element_kind = 'suite'
                } else if(idArray.length == 1){// Block
                    id = accesskey;
                    element_kind = 'block'
                } else if(idArray.length == 3) {
                    id = idArray[2];
                    element_kind = 'section';
                }

                $.ajax({
                    url: "{{ url('')}}/settings/delete_niche_block_suite",
                    method: "POST",
                    data: {
                        id: id,
                        element_kind: element_kind,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (eid) {
                    $('#panel_'+accesskey).remove();
                });
            }
        });
        //------------------------------------------------------------------------

        // Add New Suite
        $(wrapper).on("click","#addButton2", function(e){
            e.preventDefault();
            var parentId = $(this).attr('accesskey');
            $('#new_suite_name').val('');
            $('#niche_suite_popup').modal();
            $('#suite_key').val(parentId);
        });


        $("#add_new_suite").on("click", function(e){
            e.preventDefault();
            var suiteName = $('#new_suite_name').val();
            var parentId = $('#suite_key').val();
            var parentPanel = '#block_panel_'+ parentId;

            if(suiteName.length > 0){
                var ariaExpanded = true;
                var expandedClass = 'in';
                var collapsedClass = '';

                $.ajax({
                    url: "{{ url('')}}/settings/add_niche_suite",
                    method: "POST",
                    data: {
                        suite: suiteName,
                        block_id : parentId,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (suite_id) {
                    $(wrapper).find(parentPanel).append('<div class="col-md-12" style="margin-bottom: 0;"><div class="panel panel-default" id="panel_'+parentId+'_'+ suite_id +'">' +
                            '<div class="panel-heading" role="tab" id="suite_heading_'+parentId+'_'+ suite_id +'" style="border-bottom: 1px solid #919191;">' +
                            '<a class="'+collapsedClass+'" id="panelLabel_'+ parentId +'_'+ suite_id +'" role="button" data-toggle="collapse" data-parent="#accordion" href="#suite_collapse_'+ parentId+'_'+ suite_id +'" ' +
                            'aria-expanded="'+ariaExpanded+'" aria-controls="suite_collapse_'+ parentId+'_'+ suite_id +'" style="font-size:14px;"> &nbsp;&nbsp;'+suiteName+' </a>' +
                            '<input type="hidden" id="panelName_'+ parentId +'_'+ suite_id +'" name="panelName_'+ parentId +'_'+ suite_id +'" value="'+suiteName+'">' +
                            '<div class="actions_div" style="position: relative; top: -20px;">' +
                            '<a href="#" accesskey="'+parentId +'_'+ suite_id +'" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>' +
                            '<a href="#" accesskey="'+ parentId +'_'+ suite_id +'" class="edit_ctg_label pull-right"><span class="glyphicon glyphicon-edit"></span> Edit</a>' +
                            '</div></div>' +
                            '<div id="suite_collapse_'+ parentId+'_'+ suite_id +'" class="panel-collapse collapse '+expandedClass+'" role="tabpanel" aria-labelledby="suite_heading_'+parentId+'_'+ suite_id +'">'+
                            '<div class="panel-body" id="suite_'+ parentId +'_'+ suite_id +'">' +
                            '<div class="col-md-12" style="min-height: 50px;"><a href="#" accesskey="'+ parentId +'_'+ suite_id +'" class="btn btn-success" id="addButton3"> <i class="fa fa-plus"></i> Add Section</a></div>' +
                            '</div></div></div></div>');
                    $('#niche_suite_popup').modal('hide');
                });
            }
            else{
                $('#new_suite_name').focus();
            }
        });
        //----------------------------------------------------------------------------


        // Add New Section
        $(wrapper).on("click","#addButton3", function(e){
            e.preventDefault();
            var parentId = $(this).attr('accesskey');
            $('#new_section_name').val('');
            $('#section_description').val('');
            $('#niche_section_popup').modal();
            $('#section_key').val(parentId);
        });

        $("#add_new_section").on("click", function(e){
            e.preventDefault();
            var sectionName = $('#new_section_name').val();
            var description = $('#section_description').val();
            var parentId = $('#section_key').val();
            var parentPanel = '#suite_'+ parentId;

            var tmp = parentId.split('_');
            var len = tmp.length;
            var suiteID = tmp[len-1];

            if(sectionName.length > 0){
                var ariaExpanded = true;
                var expandedClass = 'in';
                var collapsedClass = '';

                $.ajax({
                    url: "{{ url('')}}/settings/add_niche_section",
                    method: "POST",
                    data: {
                        section: sectionName,
                        description : description,
                        suite_id : suiteID,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (section_id) {
                    $(wrapper).find(parentPanel).append('<div class="col-md-12" style="margin-bottom: 0;"><div class="panel panel-default" id="panel_'+parentId+'_'+ section_id +'">' +
                            '<div class="panel-heading" role="tab" id="section_heading_'+parentId+'_'+ section_id +'" style="border-bottom: 1px solid #919191;">' +
                            '<a class="'+collapsedClass+'" id="panelLabel_'+ parentId +'_'+ section_id +'" role="button" data-toggle="collapse" data-parent="#accordion" href="#section_collapse_'+ parentId+'_'+ section_id +'" ' +
                            'aria-expanded="'+ariaExpanded+'" aria-controls="section_collapse_'+ parentId+'_'+ section_id +'" style="font-size:13px;"> &nbsp;&nbsp;'+sectionName+' </a><input type="hidden" id="panelName_'+ parentId +'_'+ section_id +'" name="panelName_'+ parentId +'_'+ section_id +'" value="'+sectionName+'">' +
                            '<div class="actions_div" style="position: relative; top: -20px;">' +
                            '<a href="#" accesskey="'+parentId +'_'+ section_id +'" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>' +
                            '<a href="#" accesskey="'+ parentId +'_'+ section_id +'" class="edit_ctg_section pull-right" ><span class="glyphicon glyphicon-edit"></span> Edit</a>' +
                            '</div></div>' +
                            '<div id="section_collapse_'+ parentId+'_'+ section_id +'" class="panel-collapse collapse '+expandedClass+'"role="tabpanel" aria-labelledby="section_heading_'+parentId+'_'+ section_id +'">'+
                            '<div class="panel-body" id="section_'+ parentId +'_'+ section_id +'">' +

                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<div class="col-md-offset-1 col-md-11" style="padding:10px;">' +
                            '<button class="btn btn-primary" id="save_section_btn" value="" type="button" accesskey="'+ parentId +'_'+ section_id +'"> <i class="fa fa-save"></i> Save</button>' +
                            '</div>' +
                            '<label for="sectionText_'+ parentId +'_'+ section_id +'" class="col-md-1 col-form-label" style="text-align:right;" value="' + sectionName + '">Name</label>' +
                            '<div class="col-md-11">' +
                            '<input class="form-control" type="text" value="'+ sectionName +'" id="sectionText_'+ parentId +'_'+ section_id +'">' +
                            '</div></div>'+
                            '<div class="form-group">' +
                            '<label for="sectionDescription_'+ parentId +'_'+ section_id +'" class="col-md-1 col-form-label" style="text-align:right;">Description</label>' +
                            '<div class="col-md-11">' +
                            '<textarea class="form-control" id="sectionDescription_'+ parentId +'_'+ section_id +'" rows="5">' + description +'</textarea>' +
                            '</div></div>' +

                            '<div class="col-md-2 col-lg-1" style="padding:10px;"><button type="button" style="width:100%; min-height: 100px; text-wrap: none;" class="btn btn-default" accesskey="'+ parentId +'_'+ section_id +'" id="add_left_column">Add Column to left aisle</button></div>' +
                            '<div class="col-md-8 col-lg-10 table-responsive" style="text-align:center;">' +
                            '<table class="table table-bordered" id="empty_table_' + section_id +'"><tr style="min-height: 50px;"><td>&nbsp;</td><td align="center">Entrance</td><td>&nbsp;</td></tr></table>' +
                            '<table class="table table-bordered suite-table" id="suiteTable_'+ parentId +'_'+ section_id +'" leftcolumns="1" rightcolumns="1" style="display:none">' +
                            '<tr><td style="width:30px;"></td><td></td><td>[ColumnText]</td><td align="center" class="border-td" rowspan="2" style="width: 30px;vertical-align:middle;" id="entrance_'+ parentId +'_'+ section_id +'">Entrance</td><td>[ColumnText]</td><td></td></tr>' +
                            '<tr><td style="width:30px;"></td><td>[Row Text]</td><td class="border-td"></td><td class="border-td"></td><td>[RowText]</td></tr>' +
                            '</table>' +
                            '<button type="button" class="btn btn-default" style="width:100%;margin-bottom: 10px;min-width:150px;" accesskey="'+ parentId +'_'+ section_id +'" id="add_row">Add Row</button>' +
                            '</div>' +
                            '<div class="col-md-2 col-lg-1" style="padding:10px;"><button type="button" style="width:100%; min-height: 100px; text-wrap: none;" class="btn btn-default" accesskey="'+ parentId +'_'+ section_id +'" id="add_right_column">Add Column to right aisle</button></div>' +
                            '<div class="col-md-offset-1 col-md-11">' +
                            '<table class="table table-bordered" id="legend_table" style="width:300px;">' +
                            '<tr><td style="min-height: 30px; font-size:14px;" colspan="2">Legend</td></tr>' +
                            '<tr><td style="width:100px; background: yellow; height:30px;">&nbsp;</td><td>Not Avail</td></tr>' +
                            '<tr><td style="width:100px;background: #fff; height:30px;">&nbsp;</td><td>Avail</td></tr>' +
                            '<tr><td style="width:100px;background: #92cf51; height:30px;">&nbsp;</td><td>On Hold</td></tr>' +
                            '<tr><td style="width:100px;background: #abb8ca; height:30px;">&nbsp;</td><td>Future Development</td></tr>' +
                            '</table>' +
                            '</div>' +
                            '</div>' +

                            '</div></div></div></div>');

                    $('#niche_section_popup').modal('hide');
                });
            }
            else{
                $('#new_section_name').focus();
            }
        });

        //Edit Section Collapse In
        $(wrapper).on("click",".edit_ctg_section", function(e){
            var panelId = $(this).attr('accesskey');
            var collapse = '#section_collapse_'+panelId;
            $(collapse).addClass('in');
        });

        //Update Section and Save Cell(Table)
        $(wrapper).on("click","#save_section_btn", function(e){
            e.preventDefault();
            var panelId = $(this).attr('accesskey');
            var sectionName = $('#sectionText_'+panelId).val();
            var description = $('#sectionDescription_'+panelId).val();

            if(sectionName == '') {
                $('#sectionText_'+panelId).focus();
                return false;
            }

            //===Update Section
            //get section id
            var tmp = panelId.split('_');
            var sectionId = tmp[tmp.length-1];

            $.ajax({
                url: "{{ url('')}}/settings/update_niche_section",
                method: "POST",
                data: {
                    id: sectionId,
                    name: sectionName,
                    description: description,
                    "_token": "{{ csrf_token() }}",
                },
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (eid) {
                $('#panelLabel_'+panelId).html('&nbsp;&nbsp;' + sectionName);
            });
        });

        //------------------------------------------------------------------------------------------------

        // Section Table Operation

        //Add Row
        $(wrapper).on("click","#add_row", function(e){
            e.preventDefault();
            var panelId = $(this).attr('accesskey');

            $('#tbl_accesskey').val(panelId);
            $('#row_text').val('');
            //$('#row_position').val('');

            var tmp = panelId.split('_');
            var sectionId = tmp[tmp.length-1];

            $.get('/section_rows/' + sectionId + '/rows.json', function(rows)
            {
                var $rows = $('#current_row');

                $rows.find('option').remove().end();

                $.each(rows, function(index, row) {
                    $rows.append('<option value="' + row.id + '">' + row.name + '</option>');
                });
            });

            $('#table_row_popup').modal();
        });

        $('#add_row_button').on("click", function (e) {
            e.preventDefault();
            var panelId = $('#tbl_accesskey').val();
            var mtable = '#suiteTable_'+panelId;
            var entrance = '#entrance_'+panelId;
            var rows = $(entrance).attr('rowspan');
            var rowText = $('#row_text').val();
            var pos = $('#row_position').val();
            var current_row = $('#current_row').val();

            // get section id
            var tmp_ids = panelId.split('_');
            var sectionId = tmp_ids[tmp_ids.length-1];

            if(rowText){
                $.ajax({
                    url: "{{ url('')}}/settings/add_niche_row",
                    method: "POST",
                    data: {
                        section_id: sectionId,
                        name: rowText,
                        pos: pos,
                        current_row : current_row,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (new_row) {
                    var sortorder = new_row.sort_order;
                    var row_id = new_row.id;
                    $(mtable).css('display', '');
                    $('#empty_table_' + new_row.niche_section_id).css('display', 'none');
                    if(rows == 2) {
                        $(mtable + ' tbody').append($(mtable+ " tbody tr:last").clone());
                        $(mtable+ " tbody tr:nth-child(2)").remove();

                        $(mtable + ' tbody tr:nth-child('+rows+') td:first').html('<a rindex="'+ rows +'" href="#" accesskey="' + row_id + '" class="remove_ctg_tr exit-btn"><span class="glyphicon glyphicon-remove"></span></a>');
                        $(mtable + ' tbody tr:nth-child('+rows+') td:nth-child(2)').html('<a rindex="'+ rows +'" href="#" accesskey="' + row_id + '" class="edit_tr_text exit-btn">'+rowText + '</a><input type="hidden" name="rowText" value="'+ rowText + '" style="border:0px; width: auto; background:transparent;" readonly>');
                        $(mtable + ' tbody tr:nth-child('+rows+') td:last').html('<a rindex="'+ rows +'" href="#" accesskey="' + row_id + '" class="edit_tr_text exit-btn">' + rowText + '</a><input type="hidden" name="rowText" value="'+ rowText + '" style="border:0px; width: auto; background:transparent;" readonly>');
                        $(mtable + ' tbody tr:nth-child('+rows+')').find('td').not(':first').not(':last').not(':nth-child(2)').html('');
                        $(mtable + ' tbody tr:nth-child('+rows+')').find('td').not(':first').not(':last').not(':nth-child(2)').css('background-color', '#fff');
                        $(mtable + ' tbody tr:nth-child('+ rows +')').attr('rowid',row_id);
                    }
                    else {
                        var tmp = parseInt(sortorder) + 1 ;
                        if(sortorder == 1) {
                            $(mtable+ " tbody tr:nth-child(2)").clone().insertBefore($(mtable+ " tbody tr:nth-child("+tmp+")"));
                        }
                        else{
                            if(pos == 'below'){
                                $(mtable+ " tbody tr:nth-child("+sortorder+")").clone().insertAfter($(mtable+ " tbody tr:nth-child("+sortorder+")"));
                            } else{
                                $(mtable+ " tbody tr:nth-child("+tmp+")").clone().insertBefore($(mtable+ " tbody tr:nth-child("+tmp+")"));
                            }
                        }

                        $(mtable + ' tbody tr:nth-child('+ tmp +') td:first').html('<a rindex="'+ rows +'" href="#" accesskey="' + row_id + '" class="remove_ctg_tr exit-btn"><span class="glyphicon glyphicon-remove"></span></a>');
                        $(mtable + ' tbody tr:nth-child('+ tmp +') td:nth-child(2)').html('<a rindex="'+ rows +'" href="#" accesskey="' + row_id + '" class="edit_tr_text exit-btn">' + rowText + '</a><input type="hidden" name="rowText" value="'+ rowText + '" style="border:0px; width: auto; background:transparent;" readonly>');
                        $(mtable + ' tbody tr:nth-child('+ tmp +') td:last').html('<a rindex="'+ rows +'" href="#" accesskey="' + row_id + '" class="edit_tr_text exit-btn">' + rowText + '</a><input type="hidden" name="rowText" value="'+ rowText + '" style="border:0px; width: auto; background:transparent;" readonly>');
                        $(mtable + ' tbody tr:nth-child('+ tmp +')').find('td').not(':first').not(':last').not(':nth-child(2)').html('');
                        $(mtable + ' tbody tr:nth-child('+ tmp +')').find('td').not(':first').not(':last').not(':nth-child(2)').css('background-color', '#fff');
                        $(mtable + ' tbody tr:nth-child('+ tmp +')').attr('rowid',row_id);
                        $(mtable + ' tbody tr:nth-child('+ tmp +')').each(function(){
                            var td = $(this).find('td');
                            td.removeAttr('cellid');
                            td.attr('id', '');
                            td.removeClass('re-editable');
                            td.addClass('editable');
                        })
                    }

                    rows++;
                    $(entrance).attr('rowspan', rows);

                    //If Column is empty
                    var lefts = parseInt($(mtable).attr('leftcolumns'));
                    var hidden_index, hidden_index2;

                    if($(mtable).attr('rightcolumns')==1){
                        if($(mtable).attr('leftcolumns')==1)
                            hidden_index = lefts + 4;
                        else
                            hidden_index = lefts + 3;
                        hidden_index2 = hidden_index - 1;

                        $(mtable + ' tbody tr:first td:nth-child('+hidden_index+')').css('display','none');
                        $(mtable + ' tbody').find('tr').not(':first').find('td:nth-child('+hidden_index2+')').css('display','none');
                    }

                    if($(mtable).attr('leftcolumns')==1){
                        $(mtable + ' tbody td:nth-child(3)').css('display','none');
                    }

                    $(mtable + ' tbody tr:nth-child(2)').css('display', '');
                });

                $('#table_row_popup').modal('hide');
            }
        });

        //Edit Row text
        $(wrapper).on("click", ".edit_tr_text", function(e){
            e.preventDefault();
            var row_id = $(this).attr('accesskey');
            var row_text = $(this).html();
            $('#new_label_name').val(row_text);
            $('#accesskey').val(row_id);
            $('#element_type').val('row_edit');
            $('#label_edit_popup').modal();

        });

        //Delete row
        $(wrapper).on("click", ".remove_ctg_tr", function(e){
            e.preventDefault();
            var row_id = $(this).attr('accesskey');
            var table_rows = $(this).closest('table').find("[id*='entrance_']").attr('rowspan');
            var right_columns = $(this).closest('table').attr('rightcolumns');
            var left_columns = $(this).closest('table').attr('leftcolumns');
            var table = $(this).closest('table');
            var tr = $(this).closest('tr');

            if (confirm("Are you sure?")) {

                $.ajax({
                    url: "{{ url('')}}/settings/delete_niche_row",
                    method: "POST",
                    data: {
                        row_id: row_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (section_id) {
                    table_rows--;
                    table.find("[id*='entrance_']").attr('rowspan', table_rows);

                    if(table_rows > 2){
                        tr.remove();
                    }
                    else {
                        if(right_columns ==1 && left_columns ==1)
                        {
                            table.css('display', 'none');
                            $('#empty_table_' + section_id).css('display', '');
                        }

                        tr.each(function(){
                            $(this).find('td').html('');
                        });
                        tr.css('display', 'none');
                    }
                });
            }
        });

        //Add Column
        $(wrapper).on("click", "#add_left_column", function(e){
            e.preventDefault();
            var panelId = $(this).attr('accesskey');
            $('#tbl_accesskey').val(panelId);
            $('#tbl_side').val('left');
            $('#column_text').val('');

            var tmp = panelId.split('_');
            var sectionId = tmp[tmp.length-1];

            var side ='left';

            $.get('/section_columns/' + sectionId + '/' + side + '/columns.json', function(columns)
            {
                var $columns = $('#current_column');
                $columns.find('option').remove().end();
                $.each(columns, function(index, column) {
                    $columns.append('<option value="' + column.id + '">' + column.name + '</option>');
                });
            });

            $('#table_column_popup').modal();
        });

        $(wrapper).on("click", "#add_right_column", function(e){
            e.preventDefault();
            var panelId = $(this).attr('accesskey');
            $('#tbl_accesskey').val(panelId);
            $('#tbl_side').val('right');
            $('#column_text').val('');

            var tmp = panelId.split('_');
            var sectionId = tmp[tmp.length-1];
            var side ='right';

            $.get('/section_columns/' + sectionId + '/' + side + '/columns.json', function(columns)
            {
                var $columns = $('#current_column');
                $columns.find('option').remove().end();
                $.each(columns, function(index, column) {
                    $columns.append('<option value="' + column.id + '">' + column.name + '</option>');
                });
            });

            $('#table_column_popup').modal();
        });


        $('#add_column_button').on("click", function (e) {
            e.preventDefault();
            var panelId = $('#tbl_accesskey').val();
            var mtable = '#suiteTable_'+panelId;
            var side = $('#tbl_side').val();
            var columnText = $('#column_text').val();

            var entrance = '#entrance_'+panelId;
            var rows = $(entrance).attr('rowspan');

            var pos = $('#column_position').val();
            var current_column = $('#current_column').val();

            var column_left_count = $(mtable).attr('leftcolumns');
            var column_right_count = $(mtable).attr('rightcolumns');

            // get section id
            var tmp_ids = panelId.split('_');
            var sectionId = tmp_ids[tmp_ids.length-1];

            if(columnText){

                //Insert Column into DB
                $.ajax({
                    url: "{{ url('')}}/settings/add_niche_column",
                    method: "POST",
                    data: {
                        section_id: sectionId,
                        name: columnText,
                        pos: pos,
                        current_column : current_column,
                        side : side,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (new_column) {
                    var sort_order = new_column.sort_order;
                    var column_id = new_column.id;
                    var td_index;
                    var td_index_r;
                    $(mtable).css('display', '');
                    $('#empty_table_' + new_column.niche_section_id).css('display', 'none');
                    if(side == 'left'){
                        if(sort_order == 1){
                            $(mtable + ' tr td:nth-child(3)').before($("<td class='editable' columnid='" + column_id + "' side='left'>"));
                            $(mtable + ' tbody tr:first>td:nth-child(3)').html('<a href="#" accesskey="left" tdkey="'+ column_id +'" class="edit_td_text">' + columnText + '</a>&nbsp;&nbsp;<a href="#" accesskey="left" class="remove_ctg_td exit-btn"><span class="glyphicon glyphicon-remove"></span></a>');
                            if(column_left_count == 1) {
                                $(mtable + ' tr td:nth-child(4)').remove();
                            }
                        } else{
                            td_index = parseInt(sort_order)+2;
                            //td_index = parseInt(sort_order)+3;
                            $(mtable + ' tr td:nth-child('+ td_index +')').before($("<td class='editable' columnid='" + column_id + "' side='left'>"));
                            $(mtable + ' tbody tr:first>td:nth-child('+ td_index +')').html('<a href="#" accesskey="left" tdkey="'+ column_id +'" class="edit_td_text">' + columnText + '</a>&nbsp;&nbsp;<a href="#" accesskey="left" class="remove_ctg_td exit-btn"><span class="glyphicon glyphicon-remove"></span></a>');
                        }

                        column_left_count ++;
                        $(mtable).attr('leftcolumns', column_left_count);


                        //If Column and Row are empty
                        var hidden_index;
                        var hidden_index2
                        if($(mtable).attr('rightcolumns')==1){
                            hidden_index = column_left_count + 3;
                            hidden_index2 = hidden_index - 1;
                            $(mtable + ' tbody tr:first td:nth-child('+ hidden_index+')').css('display','none');
                            $(mtable + ' tbody').find('tr').not(':first').find('td:nth-child(' + hidden_index2 + ')').css('display','none');
                        }

                        $(mtable + ' tbody td:nth-child(3)').css('display','');

                        if(rows == 2) {
                            $(mtable + ' tbody tr:nth-child(2)').css('display', 'none');
                        }

                        $(mtable + ' tbody td:nth-child(3)').css('display','');

                        $('#table_column_popup').modal('hide');
                    } else{ //side == right

                        if(sort_order == 1){
                            $(mtable + ' tr').each(function(){
                                $(this).find('td').eq(-1).before($("<td class='editable' columnid='" + column_id + "' side='right'>"));
                            });

                            $(mtable + ' tbody tr:first td').eq(-2).html('<a href="#" accesskey="left" tdkey="'+ column_id +'" class="edit_td_text">' + columnText + '</a>&nbsp;&nbsp;<a href="#" accesskey="right" class="remove_ctg_td exit-btn"><span class="glyphicon glyphicon-remove"></span></a>');

                            if(column_right_count == 1) {
                                $(mtable + ' tr').each(function(){
                                    $(this).find('td').eq(-3).remove();
                                });
                            }
                        }
                        else {

                            td_index_r = 0 - parseInt(sort_order);

                            $(mtable + ' tr').each(function(){
                                $(this).find('td').eq(td_index_r).before($("<td class='editable' columnid='" + column_id + "' side='right'>"));
                            });

                            $(mtable + ' tbody tr:first td').eq(td_index_r-1).html('<a href="#" accesskey="left" tdkey="'+ column_id +'" class="edit_td_text">' + columnText + '</a>&nbsp;&nbsp;<a href="#" accesskey="right" class="remove_ctg_td exit-btn"><span class="glyphicon glyphicon-remove"></span></a>');
                        }

                        column_right_count ++;
                        $(mtable).attr('rightcolumns', column_right_count);


                        //If Column and row are empty


                        if($(mtable).attr('leftcolumns')==1){
                            $(mtable + ' tbody td:nth-child(3)').css('display','none');
                        } else {
                            $(mtable + ' tbody td:nth-child(3)').css('display','');
                        }

                        var hidden_index;
                        var hidden_index2

                        hidden_index = $(mtable).attr('leftcolumns') + 3;
                        hidden_index2 = hidden_index - 1;

                        $(mtable + ' tbody tr:first td:nth-child('+hidden_index+')').css('display','');
                        $(mtable + ' tbody').find('tr').not(':first').find('td:nth-child('+hidden_index2+')').css('display','');

                        if(rows == 2) {
                            $(mtable + ' tbody tr:nth-child(2)').css('display', 'none');
                        }

                        $('#table_column_popup').modal('hide');

                    }
                });
            }
        });

        //Edit Column text
        $(wrapper).on("click", ".edit_td_text", function(e){
            e.preventDefault();
            var column_id = $(this).attr('tdkey');
            var column_text = $(this).html();
            $('#new_label_name').val(column_text);
            $('#accesskey').val(column_id);
            $('#element_type').val('column_edit');
            $('#label_edit_popup').modal();

        });

        //Delete Column
        $(wrapper).on("click",".remove_ctg_td", function(e){
            e.preventDefault();
            var leftcolumns = $(this).closest('table').attr('leftcolumns');
            var rightcolumns = $(this).closest('table').attr('rightcolumns');
            var side = $(this).closest('td').attr('side');

            var index = $(this).closest('td').index();
            var column_id = $(this).closest('td').attr('columnid');

            var table = $(this).closest('table');
            var td = $(this).closest("td");

            var table_rows = $(this).closest('table').find("[id*='entrance_']").attr('rowspan');

            index++;
            if (confirm("Are you sure?")) {

                $.ajax({
                    url: "{{ url('')}}/settings/delete_niche_column",
                    method: "POST",
                    data: {
                        column_id: column_id,
                        side:side,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (section_id) {
                    if(side=="left") {
                        leftcolumns--;
                        table.attr('leftcolumns', leftcolumns);

                        if(rightcolumns ==1 && leftcolumns ==1 && table_rows==2)
                        {
                            table.css('display', 'none');
                            $('#empty_table_' + section_id).css('display', '');
                        }

                        if(leftcolumns == 1){

                            table.find("td:nth-child(" + index + ")").html('');
                            table.find("td:nth-child(" + index + ")").css("background-color", "#fff");
                            table.find("td:nth-child(" + index + ")").removeClass('re-editable');
                            table.find("td:nth-child(" + index + ")").removeClass('editable');
                            table.find("tr:first td:nth-child(" + index + ")").css("background-color", "#494949");

                            table.find("td:nth-child(" + index + ")").css("display", "none");

                        }

                        else
                            table.find("td:nth-child(" + index + ")").remove();
                    } else{
                        rightcolumns--;
                        table.attr('rightcolumns', rightcolumns);
                        var tmpindex = index - 1;
                        if(rightcolumns == 1){
                            td.html('');
                            td.css('display','none')

                            table.each(function () {
                                $(this).find('tr:not(:first-child) td:nth-child('+ tmpindex +')').html('');
                                $(this).find('tr:not(:first-child) td:nth-child('+ tmpindex +')').css("background-color", "#fff");
                                $(this).find('tr:not(:first-child) td:nth-child('+ tmpindex +')').removeClass('re-editable');
                                $(this).find('tr:not(:first-child) td:nth-child('+ tmpindex +')').removeClass('editable');
                                $(this).find('tr:not(:first-child) td:nth-child('+ tmpindex +')').css("display", "none");
                            });

                            if(rightcolumns ==1 && leftcolumns ==1 && table_rows==2)
                            {
                                table.css('display', 'none');
                                $('#empty_table_' + section_id).css('display', '');
                            }

                        } else {
                            table.each(function () {
                                $(this).find('tr:not(:first-child) td:nth-child('+ tmpindex +')').remove();
                            });

                            td.remove();
                        }
                    }
                });
            }
        });


        //Add Cell Information
        $(wrapper).on("click",".editable", function(e){
            e.preventDefault();
            var row_id = $(this).closest("tr").attr('rowid');

            var side = $(this).attr('side');
            var column_id = $(this).attr('columnid');
            var tdIndex = $(this).index();

            if(row_id != '' && column_id != '' && row_id != null )
            {
                $(this).attr('id', 'td_' + row_id + '_' + column_id);
                $('#cell_id').val('');
                $('#row_id').val(row_id);
                $('#column_id').val(column_id);
                $('#cell_name').val('');
                $('#cell_description').val('');
                $('#selling_price').val('');
                $('#maintenance_fee').val('');
                $('#cell_type').val('');
                $('#cell_act').val('add');
                $('#td_index').val(tdIndex);
                $('#cell_popup').modal();

            }
        });

        //Edit Cell information
        $(wrapper).on("click",".re-editable", function(e){
            e.preventDefault();
            var row_id = $(this).closest("tr").attr('rowid');
            var column_id = $(this).attr('columnid');
            var cell_id = $(this).attr('cellid');
            var tdIndex = $(this).index();

            if(row_id != '' && column_id != '' && row_id != null)
            {
                $.ajax({
                    url: "{{ url('')}}/settings/read_niche_cell",
                    method: "POST",
                    data: {
                        cell_id: cell_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (cell) {
                    $('#cell_id').val(cell.id);
                    $('#row_id').val(cell.niche_row_id);
                    $('#column_id').val(cell.niche_column_id);
                    $('#cell_name').val(cell.name);
                    $('#cell_description').val(cell.description);
                    $('#selling_price').val(cell.selling_price);
                    $('#maintenance_fee').val(cell.maintenance_fee);
                    $('#cell_type').val(cell.type);
                    $('#cell_act').val('update');
                    $('#td_index').val(tdIndex);
                    $("input[name=cell_status][value=" + cell.status + "]").prop('checked', true);
                    //$("input[name=cell_status]").val(cell.status);
                    $('#cell_popup').modal();
                });

            }
        });

        //Save Cell information into DB
        $('#cell_info_button').on("click", function (e) {
            e.preventDefault();

            //Save Cell information
            var cell_id                 = $('#cell_id').val();
            var cell_name               = $('#cell_name').val();
            var cell_status             = $('input[name="cell_status"]:checked').val();
            var cell_row_id             = $('#row_id').val();
            var cell_column_id          = $('#column_id').val();
            var cell_description        = $('#cell_description').val();
            var cell_selling_price      = $('#selling_price').val();
            var cell_maintenance_fee    = $('#maintenance_fee').val();
            var cell_type               = $('#cell_type').val();
            var cell_act                = $('#cell_act').val();
            var cell_td_index           = $('#td_index').val();
            //var cell_side               = $('#side').val();

            if(cell_name == '') {
                $('#cell_name').focus();
                return false;
            }

            $.ajax({
                url: "{{ url('')}}/settings/add_niche_cell",
                method: "POST",
                data: {
                    cell_id : cell_id,
                    name : cell_name,
                    status : cell_status,
                    row_id :cell_row_id,
                    column_id :cell_column_id,
                    description : cell_description,
                    selling_price : cell_selling_price,
                    maintenance_fee : cell_maintenance_fee,
                    type : cell_type,
                    td_index : cell_td_index,
                    act : cell_act,
                    "_token": "{{ csrf_token() }}",
                },
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (new_cell) {
                var cell_id = 'td_' + new_cell.niche_row_id + '_' + new_cell.niche_column_id;

                var cell = $('#' + cell_id);
                cell.removeClass('editable');
                cell.addClass('re-editable');
                cell.attr('cellid', new_cell.id);

                cell.html(cell_name);

                if(cell_status == 0) { //on hold
                    cell.css("background-color", "#92cf51");
                    cell.attr('status', '0');
                    cell.closest('tr').find('td:first').find('.remove_ctg_tr').removeClass('remove_ctg_tr');
                }
                if(cell_status == 1) { //Available
                    cell.css("background-color", "#fff");
                    cell.attr('status', '1');
                }

                if(cell_status == 2) { //Not Available
                    cell.css("background-color", "yellow");
                    //cell.off('click');
                    cell.attr('status', '2');
                    cell.closest('tr').find('td:first').find('.remove_ctg_tr').removeClass('remove_ctg_tr');
                }

                if(cell_status == 3) { //Future Development
                    cell.attr('status', '3');
                    cell.css("background-color", "#abb8ca");
                }

                var status_tr_chk = 0;
                cell.closest('tr').find('td').each(function () {
                    if($(this).attr('status') == 0 || $(this).attr('status') == 2)
                        status_tr_chk ++;
                });

                if(status_tr_chk > 0){
                    cell.closest('tr').find('td:first').find('.remove_ctg_tr').removeClass('remove_ctg_tr');
                } else{
                    cell.closest('tr').find('td:first').find('.exit-btn').addClass('remove_ctg_tr');
                }

                var status_td_chk = 0;
                cell.closest('table').find('[columnid="'+ new_cell.niche_column_id +'"]').each(function () {
                    if($(this).attr('status') == 0 || $(this).attr('status') == 2)
                        status_td_chk ++;
                });

                if(status_td_chk > 0){
                    cell.closest('table').find('[columnid="'+ new_cell.niche_column_id +'"]').find('.remove_ctg_td').removeClass('remove_ctg_td');

                } else{
                    cell.closest('table').find('[columnid="'+ new_cell.niche_column_id +'"]').find('.exit-btn').addClass('remove_ctg_td');
                }

                $('#cell_popup').modal('hide');
            });

        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////
    });

    function updateRosterSetting(updateid) {
        $('#roster_settings_form' + updateid).submit();
    }

</script>
@endpush