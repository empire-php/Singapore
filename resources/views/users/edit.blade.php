@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Edit User
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ url('/users/update/' . $user->id ) }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                                        <label class="control-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : ''}}">
                                        <label class="control-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="{{ $user->username }}"/>

                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('nickname') ? ' has-error' : ''}}">
                                        <label class="control-label">Nickname</label>
                                        <input type="text" maxlength="3" class="form-control" name="nickname" value="{{ $user->nickname}}"/>

                                        @if ($errors->has('nickname'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Supervisor</label>
                                        <div class="checkbox checkbox-info margin-none">
                                            <input type="hidden" name="is_supervisor" value="0" />
                                            <input type="checkbox" name="is_supervisor" id="is_supervisor" value="1"
                                                   @if ($user->is_supervisor) checked="checked" @endif  />
                                            <label for="is_supervisor"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                                        <label class="control-label">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}"/>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('department_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Department</label>
                                        <select class="select form-control" name="department_id">
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
                                    </div>
                                    <div class="form-group{{ $errors->has('supervisor_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Direct Supervisor</label>
                                        <select class="select form-control" name="supervisor_id">
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
                                    </div>
                                    <div class="form-group{{ $errors->has('manager_id') ? ' has-error' : ''}}">
                                        <label class="control-label">Manager</label>
                                        <select class="select form-control" name="manager_id">
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
        </div>
    </div>
@endsection
