$(function () {
    'use strict';

    window['App'] = {
        init: function () {
            this.initListeners();
        },
        initListeners: function () {
            this.submitUserPasswordChangeForm();
            this.accordionPlusMinus();
            this.datePicker();
            this.timePicker();
            this.initSidebarMenu();
        },
        initSidebarMenu: function () {
            var activeAccordionGroup = $.cookie('activeAccordionGroup');
            if (activeAccordionGroup && activeAccordionGroup.length) {
                activeAccordionGroup = activeAccordionGroup.split(',');
                for (var i = 0; i < activeAccordionGroup.length; i++) {
                    $("#" + activeAccordionGroup[i]).collapse("show");
                }
            }
            $('.sidebar').on('shown.bs.collapse', App.saveSidebarMenuChanges);

            $('.sidebar').on('hide.bs.collapse', function () {
                setTimeout(App.saveSidebarMenuChanges, 500)
            });
        },

        saveSidebarMenuChanges: function () {
            var active = [];
            $(".hasSubmenu.open ul").each(function(value, index) {
                active.push($(this).attr('id'));
            });

            $.cookie('activeAccordionGroup', active)
        },

        datePicker: function () {
            $('.datetimepicker').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                format: 'DD/MM/YYYY HH:mm',
                drops: 'up'
            });
        },
        timePicker: function () {
            $('.onlytimepicker').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timeOnly: true,
                format: 'DD/MM/YYYY HH:mm'
            });
        },
        accordionPlusMinus: function () {
            var iconOpen = 'fa fa-minus',
                iconClose = 'fa fa-plus';

            $('[data-toggle="collapse"]').click(function () {
                $(this).find('em').toggleClass(iconOpen + ' ' + iconClose)
            });
        },
        submitUserPasswordChangeForm: function () {
            $('#changePasswordForm').submit(function () {
                $(this).find('button[type="submit"]').button('loading');
                if ($('#password').val()) {
                    $.post('/users/' + $(this).find('input[name="user_id"]').val(), {
                        password: $('#password').val(),
                        _token: App.getCsrfToken()
                    }, function (res) {
                        $(this).find('button[type="submit"]').button('reset');
                        window.location.reload();
                    });
                } else {
                    alert("Please enter a password");
                }

                return false;
            });
        },
        changeUserDirectSupervisor: function (el) {
            var $this = $(el),
                userId = $this.data('userId');

            var supervisor_id = $this.val();

            $this.button('loading');
            $.post('/users/' + userId, {
                supervisor_id: supervisor_id,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        changeUserManager: function (el) {
            var $this = $(el),
                userId = $this.data('userId');

            var manager_id = $this.val();

            $this.button('loading');
            $.post('/users/' + userId, {
                manager_id: manager_id,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        changeUserDepartment: function (el) {
            var $this = $(el),
                userId = $this.data('userId');

            var department_id = $this.val();

            $this.button('loading');
            $.post('/users/' + userId, {
                department_id: department_id,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        changeUserSupervisorState: function (el) {
            var $this = $(el),
                userId = $this.data('userId'),
                state = 0;

            if ($this.is(':checked')) {
                state = 1;
            }
            $this.button('loading');
            $.post('/users/' + userId, {
                is_supervisor: state,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        openChangePasswordModal: function (el) {
            var $this = $(el),
                userId = $this.data('userId');

            $('#changePasswordForm input[name="user_id"]').val(userId);
            $('#changePasswordModal').modal('show');

        },
        getCsrfToken: function () {
            if ($('#token').length) {
                return $('#token').val();
            }
            return false;
        },
        saveSecretKey: function (el) {
            var $this = $(el),
                secret_key = $('#secretKey').val();

            $this.button('loading');
            $.post('/settings/update-secret-key', {
                secret_key: secret_key,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        updateCompany: function (el) {
            var $this = $(el),
                company_id = $this.data('companyId'),
                company_name = $('#companyName' + company_id).val();

            $this.button('loading');
            $.post('/settings/update-company/' + company_id, {
                company_name: company_name,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        updateDepartment: function (el) {
            var $this = $(el),
                department_id = $this.data('departmentId'),
                department_name = $('#departmentName' + department_id).val();

            $this.button('loading');
            $.post('/settings/update-department/' + department_id, {
                department_name: department_name,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        createDepartment: function (el) {
            var $this = $(el),
                department_name = $('#departmentName').val();

            $this.button('loading');
            $.post('/settings/create-department', {
                department_name: department_name,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                window.location.reload();
            });
        },
        showNewDepartmentForm: function (el) {
            var $this = $(el);
            $this.closest('.form-group').addClass('hidden');
            $('#newDepartmentForm').removeClass('hidden');
        },
        saveShiftingSetting: function (el) {
            var $this = $(el),
                uid = $this.data('usersSettingId'),
                did = $this.data('departmentsSettingId'),
                departments_ids = $this.closest('tr').find('select[name="departments_ids"]').val(),
                users_ids = $this.closest('tr').find('select[name="users_ids"]').val();

            $this.button('loading');
            $.post('/settings/update-shifting/' + did + '/' + uid, {
                departments_ids: departments_ids,
                users_ids: users_ids,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
            });
        },
        saveFASetting: function (el) {
            var $this = $(el),
                uid = $this.data('usersSettingId'),
                did = $this.data('departmentsSettingId'),
                departments_ids = $this.closest('tr').find('select[name="departments_ids"]').val(),
                users_ids = $this.closest('tr').find('select[name="users_ids"]').val();

            $this.button('loading');
            $.post('/settings/update-fa/' + did + '/' + uid, {
                departments_ids: departments_ids,
                users_ids: users_ids,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
            });
        },
        saveGemstoneSetting: function (el) {
            var $this = $(el),
                uid = $this.data('usersSettingId'),
                did = $this.data('departmentsSettingId'),
                departments_ids = $this.closest('tr').find('select[name="departments_ids"]').val(),
                users_ids = $this.closest('tr').find('select[name="users_ids"]').val();

            $this.button('loading');
            $.post('/settings/update-gemstone/' + did + '/' + uid, {
                departments_ids: departments_ids,
                users_ids: users_ids,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
            });
        },
        saveColumbariumSetting: function (el) {
            var $this = $(el),
                uid = $this.data('usersSettingId'),
                did = $this.data('departmentsSettingId'),
                departments_ids = $this.closest('tr').find('select[name="departments_ids"]').val(),
                users_ids = $this.closest('tr').find('select[name="users_ids"]').val();

            $this.button('loading');
            $.post('/settings/update-columbarium/' + did + '/' + uid, {
                departments_ids: departments_ids,
                users_ids: users_ids,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
            });
        },
        saveInventorySetting: function (el) {
            var $this = $(el),
                uid = $this.data('usersSettingId'),
                did = $this.data('departmentsSettingId'),
                departments_ids = $this.closest('tr').find('select[name="departments_ids"]').val(),
                users_ids = $this.closest('tr').find('select[name="users_ids"]').val();

            $this.button('loading');
            $.post('/settings/update-inventory/' + did + '/' + uid, {
                departments_ids: departments_ids,
                users_ids: users_ids,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
            });
        },
        updateShifting: function (el) {
            var $this = $(el),
                $row = $this.closest('tr'),
                shifting_id = $this.data('shiftingId'),
                remarks = $row.find('textarea').val(),
                users_ids = $row.find('select[name="users_ids"]').val(),
                start_date = $row.find('input[name="start_date"]').val(),
                end_date = $row.find('input[name="end_date"]').val();

            $this.button('loading');
            $.post('/shifting/update/' + shifting_id, {
                remarks: remarks,
                users_ids: users_ids,
                start_date: start_date,
                end_date: end_date,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                if (res.status && res.reload) {
                    window.location.reload();
                }
            });
        },
        updateManpowerEditingStatus: function (el) {
            var $this = $(el);

            $.post('/manpowerallocation/editingstatus/41', {
                manpower_type: 10,
                _token: App.getCsrfToken()
            }, function (res) {
                if (res.status && res.reload) {
                    //window.location.reload();
                }
            });
        },
        updateManpowerAllocation: function (el) {
           
           var csrfToken = App.getCsrfToken();
           var parlourCount = $('#blockManpowerUsers').find('input[name="parlour_order_record"]').val();
           
            for (var h = 1; h <= 40; h++) {
                var $this = $(el),
                    manpower_id = h,
                    users_ids = $('#blockManpowerUsers').find('select[name="users_ids'+h+'"]').val();
                if( users_ids != "" && users_ids !== undefined && h != 14 && h != 15 ){
                    $.post('/manpowerallocation/updatemanpower/' + manpower_id, {
                        users_ids: users_ids,
                        _token: csrfToken
                    }, function (res) {
                        if (res.status && res.reload) {
                            
                        }
                    });
                } else if( h == 14 || h == 15 ){
                    var manpower_text = $('#blockManpowerUsers').find('input[name="manpower_text'+h+'"]').val();
                    $.post('/manpowerallocation/updatemanpowertext/' + manpower_id, {
                        manpower_text: manpower_text,
                        _token: csrfToken
                    }, function (res) {
                        if (res.status && res.reload) {
                        }
                    });
                }
            }
            
            
            for (var h = 1; h < parlourCount; h++) {
                var $this = $(el),
                    users_ids = $('#blockManpowerUsers').find('select[name="users_ids_parlour_manpower'+h+'"]').val(),
                    usersclean_ids = $('#blockManpowerUsers').find('select[name="users_ids_parlour_cleaning'+h+'"]').val();
                var parlourorder_id = $('#blockManpowerUsers').find('input[name="parlourOrderId'+h+'"]').val();
                if( users_ids != "" && users_ids !== undefined && parlourorder_id != "" ){
                    $.post('/manpowerallocation/updatemanpowerparlour/' + parlourorder_id, {
                        users_ids: users_ids,
                        _token: csrfToken
                    }, function (res) {
                        if (res.status && res.reload) {
                        }
                    });
                }
                
                if( usersclean_ids != "" && usersclean_ids !== undefined && parlourorder_id != "" ){
                    $.post('/manpowerallocation/updatemanpowerparlourcleaning/' + parlourorder_id, {
                        users_ids: usersclean_ids,
                        _token: csrfToken
                    }, function (res) {
                        if (res.status && res.reload) {
                        }
                    });
                }
            }
            
            $.post('/manpowerallocation/editingstatus/41', {
                manpower_type: 9,
                _token: csrfToken
            }, function (res) {
                if (res.status && res.reload) {
                    //window.location.reload();
                }
            });
            
            $("#donemessage").html("<strong>Done editing<strong>");
            
        },
        updateHearsesManpower: function (el) {
            var $this = $(el),
                $row = $this.closest('tr'),
                hearse_id = $this.data('hearseId'),
                users_ids = $row.find('select[name="users_ids"]').val();
            
            $this.button('loading');
            $.post('/hearse/updatemanpower/' + hearse_id, {
                users_ids: users_ids,
                _token: App.getCsrfToken()
            }, function (res) {
                $this.button('reset');
                if (res.status && res.reload) {
                    window.location.reload();
                }
            });
        }
    };
});

$(document).ready(function () {
    App.init();
    
    $.getJSON( "/inventory/check_low_stock", function( data ) {
        var str = "";
        var items = 0;
        if (data){
            $.each( data, function( key, prod ) {
                str += ((items > 0 )?" and ":"") + prod.item + " from category " + prod.category ;
                items++;
            });
        }
        if (str){
            str += ((items > 1)?" are ":" is ") + " currently running low on stock. Please top up.";
        
            $("body").append('<div class="modal fade" id="low_stock_warning_popup" tabindex="-1" role="dialog" >'+
                        '   <div class="modal-dialog" role="document">'+
                        '       <div class="modal-content">'+
                        '           <div class="modal-header">'+
                        '               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '               <h4 class="modal-title" id="myModalLabel">Low Stock Warning</h4>'+
                        '            </div>'+
                        '            <div class="modal-body">'+
                        '                <div class="form-group form_container_elements">'+
                                                str+                     
                        '                </div>'+
                        '            </div>'+
                        '            <div class="modal-footer">'+
                        '                <button type="button" class="btn btn-default cancel_bttn">Ok</button>'+
                        '            </div>'+
                        '        </div>'+
                        '    </div>'+
                        '</div>');
            $("#low_stock_warning_popup").modal("show");
            $("#low_stock_warning_popup .cancel_bttn").click(function(){
                $("#low_stock_warning_popup").modal("hide");
            });
        }
    });
    
    
    
    
    $.getJSON( "/notifications/popup", function( data ) {
        var str = "";
        var items = 0;
        
        if ($("#low_stock_warning_popup").length == 0 && typeof data.id != 'undefined'){
            
            str += data.content;
        
            $("body").append('<div class="modal fade" id="coffin_slip_popup" tabindex="-1" role="dialog" >'+
                        '   <div class="modal-dialog" role="document">'+
                        '       <div class="modal-content">'+
                        '           <div class="modal-header">'+
                        '               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '               <h4 class="modal-title" id="myModalLabel">Coffin Slip</h4>'+
                        '            </div>'+
                        '            <div class="modal-body">'+
                        '                <div class="form-group form_container_elements">'+
                                                str+                     
                        '                </div>'+
                        '            </div>'+
                        '            <div class="modal-footer">'+
                        '                <button type="button" class="btn btn-primary dismiss_bttn">Dismiss</button>'+
                        '                <button type="button" class="btn btn-default postpone_bttn">Postpone</button>'+
                        '            </div>'+
                        '        </div>'+
                        '    </div>'+
                        '</div>');
            $("#coffin_slip_popup").modal("show");
            
            if (data.show_pdf){
                window.open('/notifications/show_pdf/'+ data.id, '_blank').focus();
            }
                        
            $("#coffin_slip_popup .postpone_bttn").click(function(){
                $("#coffin_slip_popup").modal("hide");
            });
            $("#coffin_slip_popup .dismiss_bttn").click(function(){
                 $.getJSON( '/notifications/delete/'+ data.id);
                    
                $("#coffin_slip_popup").modal("hide");
            });
        }
    });
    
    
    $('.datepicker_day').datepicker({
		
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy'
    });
    
    
});
