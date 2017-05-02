@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/pre-login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('secret_key') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Secret Key</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="secret_key">

                                @if ($errors->has('secret_key'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('secret_key') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
