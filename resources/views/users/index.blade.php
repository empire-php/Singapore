@extends('layouts.app')

@section('content')
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Add New User
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ url('/users/create') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                                        <label class="control-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : ''}}">
                                        <label class="control-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="{{ old('username') }}"/>

                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('nickname') ? ' has-error' : ''}}">
                                        <label class="control-label">Nickname</label>
                                        <input type="text" maxlength="3" class="form-control" name="nickname" value="{{ old('nickname') }}"/>

                                        @if ($errors->has('nickname'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('department_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Department</label>
                                        <select class="select form-control" name="department_id">
                                            <option value="0"> -- Select --</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('department_id'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('department_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('department_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Supervisor</label>
                                        <div class="checkbox checkbox-info margin-none">
                                            <input type="hidden" name="is_supervisor" value="0" />
                                            <input type="checkbox" name="is_supervisor" id="is_supervisor" value="1" />
                                            <label for="is_supervisor"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                                        <label class="control-label">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ old('email') }}"/>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
                                        <label class="control-label">Password</label>
                                        <input type="text" class="form-control" name="password" value="{{ old('password') }}"/>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('supervisor_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Direct Supervisor</label>
                                        <select class="select form-control" name="supervisor_id">
                                            <option value="0"> -- Select --</option>
                                            @foreach ($supervisors as $supervisor)
                                                <option value="{{ $supervisor->id }}">
                                                    {{ $supervisor->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('supervisor_id'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('supervisor_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('manager_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Manager</label>
                                        <select class="select form-control" name="manager_id">
                                            <option value="0"> -- Select --</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}">
                                                    {{ $manager->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('manager_id'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('manager_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group margin-bottom-none">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fa fa-fw fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Users
                        </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Username
                                </th>
								<th>
                                    Nickname
                                </th>
                                <th>
                                    E-mail
                                </th>
                                <th>
                                    Department
                                </th>
                                <th>
                                    Supervisor
                                </th>
                                <th>
                                    Direct Supervisor
                                </th>
                                <th>
                                    Manager
                                </th>
                                <th class="text-right">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->username }}
                                    </td>
									<td>
                                        {{ $user->nickname }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td class="padding-v-5">
                                        <select class="select form-control input-sm"
                                                onchange="App.changeUserDepartment(this)"
                                                data-user-id="{{ $user->id }}">
                                            <option value="0"> -- Select --</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                        @if ($user->department_id == $department->id)
                                                        selected="selected"
                                                        @endif
                                                >
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <div class="checkbox checkbox-info margin-none">
                                            <input onchange="App.changeUserSupervisorState(this)"
                                                   data-user-id="{{ $user->id }}"
                                                   id="userSupervisor{{ $user->id }}" type="checkbox"
                                                   @if ($user->is_supervisor) checked="checked" @endif />
                                            <label for="userSupervisor{{ $user->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="padding-v-5">
                                        <select class="select form-control input-sm"
                                                onchange="App.changeUserDirectSupervisor(this)"
                                                data-user-id="{{ $user->id }}">
                                            <option value="0"> -- Select --</option>
                                            @foreach ($supervisors as $supervisor)
                                                @if ($user->id != $supervisor->id)
                                                    <option value="{{ $supervisor->id }}"
                                                            @if ($user->supervisor_id == $supervisor->id)
                                                            selected="selected"
                                                            @endif
                                                    >
                                                        {{ $supervisor->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="padding-v-5">
                                        <select class="select form-control input-sm"
                                                onchange="App.changeUserManager(this)"
                                                data-user-id="{{ $user->id }}">
                                            <option value="0"> -- Select --</option>
                                            @foreach ($managers as $manager)
                                                @if ($user->id != $manager->id)
                                                    <option value="{{ $manager->id }}"
                                                            @if ($user->manager_id == $manager->id)
                                                            selected="selected"
                                                            @endif
                                                    >
                                                        {{ $manager->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-info"
                                           onclick="App.openChangePasswordModal(this)"
                                           data-user-id="{{ $user->id }}">
                                            Change Password
                                        </a>
                                        <a href="{{ url('/users/edit/' . $user->id) }}" class="btn btn-xs btn-info">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change User Password</h4>
                </div>
                <form id="changePasswordForm">
                    <input type="hidden" name="user_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="inputWarning1">New Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
