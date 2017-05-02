@extends('layouts.app')

@section('content')
 
<div class="row">
    <div class="col-md-12" style="width: 100%">

        
        <div class="section">
            <div class="page-header">
                <h3> Search</h3>
            </div>

            <form action="" method="post" class="master_form needs_exit_warning">
                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
               
                <table class="form-content">
                    <tr>
                        <td>Deceased Name</td><td><input class="form-control" type="text" name ="deceasedName" id="deceasedname" /></td>
                    </tr>
                    <tr>
                        <td>WSC Number </td><td><input class="form-control" type="number" name="wscnumber" id="wscnumber" /></td>
                    </tr>
                    <tr>
                        <td></td><td><input type="button" class="btn btn-success" value="Search" id="search_button" /></td>
                    </tr>
                    <!--For comment--> 
                    <tr>
                        <td colspan="2" style="color:red"></td>
                    </tr>
                </table>
            </form>
        
      
            <br><br>
            <form action="<?php echo url('salesorder'); ?>" method="post" >
                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="id" id="wsc_id" value>
              
                <table class="search-details table-bordered table-hover">
                    <thead>
                    <th style="background: ghostwhite">WCS number</th><th style="background:ghostwhite">Deceased Name</th>
                    </thead>
                    <tbody>
<!--                        <tr>
                            <td ><a href="javascript:void(0)" class="fill-wsc-number" id=""></a></td><td class="fill-deceased-name"></td>              
                        </tr>-->
                    </tbody>
                </table>
            </form>
            </div>
         
        
        
        <!--End second section-->
    </div>
</div>






















@endsection

@push('css')
  
    <link href="/css/app/salesorder.css" rel="stylesheet">
@endpush

@push('scripts')

    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/salesorder.js"></script>
   
    
@endpush