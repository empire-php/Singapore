@extends('layouts.app')

@section('content')
 
<div class="row">
    <div class="col-md-12" style="width: 100%">

        
        <div class="section">
            <div class="page-header">
                    Search
            </div>

            <form action="" method="post" class="master_form needs_exit_warning">
                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                <input type="hidden" id="ordersalesId" value="">
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
                </table>
            </form>
        
      
            <br><br>
                <table class="search-details table-bordered table-hover">
                    <thead>
                        <th>WCS number</th><th>Deceased Name</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td ><a href="javascript:void(0)" class="fill-wsc-number" id=""></a></td><td class="fill-deceased-name"></td>              
                        </tr>
                    </tbody>
                </table>
            </div>
         
        
        
        <!--End second section-->
    </div>
</div>

<!--Popup for make payment button event-->
<div class="modal fade" id="make_payment_popup" tabindex="-1" role="dialog">
     <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
    <input type="hidden" value="<?php echo date('m/d/Y',time()); ?>" name="payment_date" id="payment_date" />
    <input type="hidden" value="<?php $user = Auth::user();echo $user['id']; ?>" id="payment_user_id" />
    <div class="modal-dialog" role="document" style="width:40%">
            <div class="modal-content">
                <div class="modal-header" style="border:0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">payment details</h4>
                </div>

                <div class="modal-body" style="padding:0">
                    <div class="col-md-6" style="width:100%;text-align: center;">
                        <table class="table popup-table">
                            <tr>
                                <td>Payment date & time</td><td><?php echo date('m/d/Y',time());?></td>
                            </tr>
                            <tr>
                                <td>Payment amount</td><td><input class="form-control" type="text" id="payment_amount" /></td>
                            </tr>
                            <tr>
                                <td>Payment mode</td>
                                <td>
                                    <select class="form-control" name = "payment-mode-popup" id="payment_mode_popup">
                                        <option value="1">Cash</option>
                                        <option value="2">NET</option>
                                        <option value="3">cheque</option>
                                        <option value="4">Credit Card</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Payment reference/description</td><td><input class="form-control" type="text" id="payment_description" /></td>
                            </tr>
                            <tr>
                                <td></td> <td></td>
                            </tr>
                            <tr>
                                <td>Collected by</td><td><?php $user = Auth::user();echo $user['name']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default payment-submit" onclick="submit_payment()">Submit</button>
                </div>

            </div>
        </div>
    </div>
<!--End popup for make payment button event-->























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