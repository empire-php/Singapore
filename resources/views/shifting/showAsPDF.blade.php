<link href="/css/vendor/all.css" rel="stylesheet">
<div class="col-md-6" style="width: 50%; position: relative;
  min-height: 1px;
  padding-left: 15px;
  padding-right: 15px;float: left;">
    <div class="row-md-6" >
        <dl class="dl-horizontal">
            Deceased Name &nbsp; &nbsp; &nbsp; &nbsp; {{ $shifting->deceased_title }} {{ $shifting->deceased_name }}
<dt>Religion
    &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;{{ $shifting->deceased_religion }}</dt>
Hospital/House &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
{{ $shifting->hospital }}
</dl>
</div>
<div class="row-md-6">
    <dl class="dl-horizontal">
        Remarks &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
        {{ $shifting->remarks }}
    </dl>
</div>
<div class="row-md-6" >
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
        Start Time &nbsp; &nbsp; &nbsp; &nbsp;

            @if ($shifting->start_date)
                {{ date('d/m/Y, H:i', strtotime($shifting->start_date)) }}
            @endif

    </dl>
</div>
</div>

<div class="col-md-6" style="width: 50%; position: relative;
  min-height: 1px;
  padding-left: 15px;
  padding-right: 15px;float: left;">
    <div class="row-md-6">
        <dl class="dl-horizontal">
            <dt>Name
            &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ $shifting->first_contact_title }} {{ $shifting->first_contact_name }}</dt>
            <dt>Religion
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;{{ $shifting->first_contact_religion }}</dt>
            <dt>Mobile Number
            &nbsp; &nbsp; &nbsp; &nbsp;{{ $shifting->first_contact_number }}</dt>
        </dl>
    </div>
    @if ($shifting->second_contact_name)
        <div class="row-md-6">
            <dl class="dl-horizontal">
                <dt>Name
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;{{ $shifting->second_contact_title }} {{ $shifting->second_contact_name }}</dt>
                <dt>Religion
                &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;{{ $shifting->second_contact_religion }}</dt>
                <dt>Mobile Number
                &nbsp; &nbsp; &nbsp; &nbsp; {{ $shifting->second_contact_number }}</dt>
            </dl>
        </div>
    @endif
    <div class="row-md-6">
        <dl class="dl-horizontal">
            <dt>Send Parlour
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; {{ $shifting->send_parlour }}</dt>
            <dt>Send Outside
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; {{ $shifting->send_outside }}</dt>
        </dl>
    </div>
</div>