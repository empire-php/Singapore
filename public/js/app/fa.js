var pendingReq, pendingFormReq, userMadeChanges;
function dateFormat(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        var day = date.getDate().toString();
        var month = (date.getMonth() + 1).toString();
        // Months use 0 index.

        return (day[1] ? day : '0' + day[0]) + '/' +
            (month[1] ? month : '0' + month[0]) + '/' +
            date.getFullYear();
    }
}

$(document).ready(function () {

    /*$("#deceased_name").change(function(){

     $.ajax({
     url: "/fa/get_gemstone",
     method: "GET",
     data: {name: $("#deceased_name").val()}
     }).done(function(data){
     $("#deceased_title").val(data.deceased_title);
     $("#deceased_religion").val(data.religion);
     $("#first_cp_title").val(data.first_cp_title);
     $("#fa_second_cp_title").val(data.second_cp_title);
     $("#first_cp_name").val(data.first_cp_name);
     $("#second_cp_name").val(data.second_cp_name);
     $("#first_cp_religion").val(data.first_cp_religion);
     $("#second_cp_religion").val(data.second_cp_religion);
     $("#first_cp_mobile_nr").val(data.first_cp_mobile);
     $("#second_cp_mobile_nr").val(data.second_cp_mobile);

     ///
     });
     });*/

    $('body').on("change", "#obituary", function () {
        if ($(this).val()) {
            $.ajax({
                url: "/fa/obituary",
                method: "GET"
            }).done(function (data) {
                var txt;
                var obituary_arranged_by = data.obituary_arranged_by;
                //$("#obituary_arranged_by option[value=2]").attr("selected", true);
                $.each(obituary_arranged_by.split(","), function (i, e) {
                    $("#obituary_arranged_by option[value='" + e + "']").attr("selected", true);
                    txt = $("#obituary_arranged_by option[value='" + e + "']").text();
                    $("#s2id_obituary_arranged_by").find('ul').append('<li class="select2-search-choice"><div>' + txt + '</div><a href="#" class="select2-search-choice-close" tabindex="-1"></a></li>');


                });
                var obituary_followed_up_by = data.obituary_followed_up_by;

                $.each(obituary_followed_up_by.split(","), function (i, e) {
                    $("#obituary_followed_up_by option[value='" + e + "']").attr("selected", true);
                    txt = $("#obituary_followed_up_by option[value='" + e + "']").text();
                    $("#s2id_obituary_followed_up_by").find('ul').append('<li class="select2-search-choice"><div>' + txt + '</div><a href="#" class="select2-search-choice-close" tabindex="-1"></a></li>');
                });
            });
        }

    });

    $("[id^=active_item_]").each(function () {
        if ($(this).is(":checked") == true) {
            $(this).parent().find("img").show();
            $(this).parent().next().css("color", "#000");
        }
    });


    $(".check_td").click(function () {
        if ($(this).find("img").is(":visible") == true) {
            $(this).find("img").hide();
            $(this).find("[id^=active_item_]").prop('checked', false);
            $(this).next().css("color", "red");
        }
        else {
            $(this).find("img").show();
            $(this).find("[id^=active_item_]").prop('checked', true);
            $(this).next().css("color", "#000");
        }
        //    autoSaveChecklist();
    });

    $(".remarks_td input, .remarks_td textarea").keyup(function (event) {
        if (event.which == 8 || event.which == 46 || $(this).val().length > 1) {
            //         autoSaveChecklist();
            var checkTd = $(this).parents("tr").prev("tr").find(".check_td");
            if (!checkTd.find("img").is(":visible")) {
                //    checkTd.find("img").show();
                //    checkTd.find("[id^=active_item_]").prop('checked', true);
                checkTd.next().css("color", "#000");
            }
        }
    });

    $("#deathdate, #birthdate").change(function () {
        if ($("#birthdate").val() && $("#deathdate").val()) {
            var b = $("#birthdate").val().split("/");
            var d = $("#deathdate").val().split("/");
            $("#age").val(parseInt(d[2]) - parseInt(b[2]));
        }
    });

    $("#deceased_name")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("/fa/search_deceased", {
                    term: request.term
                }, response);
            },
            select: function (event, ui) {
                //console.log(ui.item.parlour_order);
                $("#deceased_title").val(ui.item.deceased_title);
                $("#deceased_name").val(ui.item.deceased_name);
                $("#deceased_religion").val(ui.item.deceased_religion);

                $("#first_cp_title").val(ui.item.first_contact_title);
                $("#first_cp_name").val(ui.item.first_contact_name);
                $("#first_cp_religion").val(ui.item.first_contact_religion);
                $("#first_cp_mobile_nr").val(ui.item.first_contact_number);

                $("#second_cp_title").val(ui.item.second_contact_title);
                $("#second_cp_name").val(ui.item.second_contact_name);
                $("#second_cp_religion").val(ui.item.second_contact_religion);
                $("#second_cp_mobile_nr").val(ui.item.second_contact_number);

                $("#collected_from1").val(ui.item.hospital);


                $("[id*=add_parlour]").attr('parlour_order_id', '');
                $("[id*=parlour_order_id]").val('');
                $("[id*=parlour_name]").val('');
                $("[id*=parlour_from_date]").val('');
                $("[id*=parlour_from_time]").val('');
                $("[id*=parlour_to_date]").val('');
                $("[id*=parlour_to_time]").val('');

                //$("[id*=parlour_row_]").hide();
                //$("[id*=parlour_row_]").hide();

                if (ui.item.send_parlour && ui.item.parlout_order_id != 0 && ui.item.parlour_order != null && $("[parlour_order_id=" + ui.item.parlour_order.id + "]").length == 0) {

                    $("#sent_to1").val("Parlour");
                    $("#sent_to2").val(ui.item.send_parlour);

                    $("#parlour_row_0_1").show();
                    $("#parlour_row_0_2").show();


                    $("#add_parlour_0").attr('parlour_order_id', ui.item.parlour_order.id);
                    $("#parlour_order_id_0").val(ui.item.parlour_order.id);
                    $("#parlour_name_0").val(ui.item.parlour_order.parlour_name);

                    var booked_from_day = dateFormat(ui.item.parlour_order.booked_from_day);
                    var booked_to_day = dateFormat(ui.item.parlour_order.booked_to_day);

                    $("#parlour_from_date0").val(booked_from_day);
                    $("#parlour_from_time0").val(ui.item.parlour_order.booked_from_time);

                    $("#parlour_to_date0").val(booked_to_day);
                    $("#parlour_to_time0").val(ui.item.parlour_order.booked_to_time);

                }
                else if (ui.item.send_outside) {
                    $("#sent_to1").val("Outside");
                    $("#sent_to2").val(ui.item.send_outside);

                    /*$( "#add_parlour_0" ).attr('parlour_order_id', '');
                     $( "#parlour_order_id_0" ).val('');
                     $( "#parlour_name_0" ).val('');
                     $( "#parlour_from_date0" ).val('');
                     $( "#parlour_from_time0" ).val('');
                     $( "#parlour_to_date0" ).val('');
                     $( "#parlour_to_time0" ).val('');*/
                }
                else {
                    $("#sent_to1").val('');
                    $("#sent_to2").val('');
                    /* $( "#add_parlour_0" ).attr('parlour_order_id', '');
                     $( "#parlour_order_id_0" ).val('');
                     $( "#parlour_name_0" ).val('');
                     $( "#parlour_from_date0" ).val('');
                     $( "#parlour_from_time0" ).val('');
                     $( "#parlour_to_date0" ).val('');
                     $( "#parlour_to_time0" ).val('');*/
                }
                $("#shifting_id").val(ui.item.id);
                return false;
            }
        })
        .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append("<div>" + item.deceased_name + " - " + item.first_contact_name + "</div>")
            .appendTo(ul);
    };
    $("#deceased_name").on("autocompleteopen", function (event, ui) {
        $(".ui-menu-item").parent().append("<li id='autocomplete_close'>" + $("#deceased_name").val() + " (new case)</li>");
        $("#autocomplete_close").click(function () {
            $("#deceased_name").autocomplete("close");
        });
    });


    $("#dialect")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("/fa/search_dialect", {
                    term: request.term
                }, response);
            },
            select: function (event, ui) {
                $("#dialect").val(ui.item.name);
                return false;
            }
        })
        .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append("<div>" + item.name + "</div>")
            .appendTo(ul);
    };


    // POSTAL CODE

    $("#first_cp_postal_code, #second_cp_postal_code").blur(function () {

        var addressId = $(this).attr("id").replace("postal_code", "address");
        var postalCode = $(this).val();

        $("#" + addressId).val("Searching...");
        $.ajax({
            url: 'http://gothere.sg/maps/geo',
            dataType: 'jsonp',
            data: {
                'output': 'json',
                'q': postalCode,
                'client': '',
                'sensor': false
            },
            type: 'GET',
            success: function (data) {
                var field = $("textarea");
                var myString = "";

                var status = data.Status;

                if (status.code == 200) {
                    for (var i = 0; i < data.Placemark.length; i++) {
                        var placemark = data.Placemark[i];
                        //var status = data.Status[i];
                        $("#" + addressId).val(placemark.address);

                    }
                } else if (status.code == 603) {
                    $(this).parent().append("<span>No Record Found</span>");
                }
                if (status.code != 200) {
                    $("#" + addressId).val("");
                }


            },
            statusCode: {
                404: function () {
                    alert('Page not found');
                    $("#" + addressId).val("");
                }
            },
        });
    });

    $("#funeral_date, #cortege_date").change(function () {
        if ($(this).val()) {
            var wDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
            var parts = $(this).val().split("/");
            var d = new Date(parts[2] + "-" + parts[1] + "-" + parts[0]);
            $("#" + $(this).attr("id") + "_day").val(wDays[d.getDay()]);
        }
    });


    $("#resting_place, #ash_collected_at").change(function () {
        if ($(this).val() == "other") {
            $("#other_" + $(this).attr("id")).show();
        }
        else {
            $("#other_" + $(this).attr("id")).val("");
            $("#other_" + $(this).attr("id")).hide();
        }
    });
    $("#own_ash_collection").change(function () {
        if ($(this).val() == "yes") {
            $("#same_collection_txt").hide();
            $("#same_date_collection").hide();
            $("#ashes_to_be_collected_at_container").hide();
        }
        else {
            $("#same_collection_txt").show();
            $("#same_date_collection").show();
            $("#ashes_to_be_collected_at_container").show();
        }
    });


    var s = $('#signature1').signField().// Setup
    on('change', function () {
        var signature = $(this); // div
    });
    var s = $('#signature2').signField().// Setup
    on('change', function () {
        var signature = $(this); // div
    });
    $("#box1, #box2").click(function () {
        $(this).next().show();
        $(this).hide();

    });
    $(".signature_box button").click(function (e) {
        $(this).parents(".signature_box").prev().show();
        $(this).parents(".signature_box").hide();
        var m = moment().format("DD/MM/YYYY");

        var boxNr = $(this).parents(".signature_box").attr("id").replace("signature_box_", "");
        $("#date_signature_" + boxNr).html(m);
        $("#input_date_signature_" + boxNr).val(m);

        $("#signature_image_" + boxNr).html($(this).parents(".signature_box").find(".imgdata").val());

        $("#box" + boxNr).html("<img src='" + $(this).parents(".signature_box").find(".imgdata").val() + "' style='width: 98px' />");

        e.preventDefault();
    });

    $("#submit_bttn, #submit_email_bttn, #submit_print_bttn, #popup_send_bttn, #save_bttn, #save_print_bttn").click(function () {

        var bttn_clicked_txt = $(this).attr("id");
        var initialText = $(this).val();
        var bttn = $(this);
        if ($(this).attr("id") == "popup_send_bttn") {
            bttn_clicked_txt = "submit_other_email_bttn";
            initialText = $("#submit_other_email_bttn").val();
            var bttn = $("#submit_other_email_bttn");
        }

        if ($(this).attr("id") == "popup_send_bttn") {
            $("#new_email").val($("#popup_new_email").val());
            $("#popup_new_email").val("");
            $('#box_other_email').modal('hide');
        }

        $("#bttn_clicked").val(bttn_clicked_txt);

        $(this).val("Please wait");

        var form_id = "info_frm";		//////////////////////////
        // for view page
        if (bttn_clicked_txt == "save_bttn" || bttn_clicked_txt == "save_print_bttn") {
            form_id = "info_frm";
        }

        var jqxhr = $.ajax({
            url: $("#" + form_id).attr("action"),
            method: 'post',
            data: $("#" + form_id).serialize()
        })
            .done(function (data) {
                bttn.val(initialText);

                if (bttn.attr("id") == "submit_print_bttn" || bttn.attr("id") == "save_print_bttn") {
                    if ($("#faid").length > 0) {
                        var win = window.open('/fa/genpdf/fa/' + $("#faid").val(), '_blank');
                    }
                    else {
                        var win = window.open('/fa/genpdf/fa_repatriation/' + $("#id").val(), '_blank');
                    }
                    win.focus();
                }
                $("#message_container").html(data.msg);
                $("#save_msg").modal("show");


                userMadeChanges = 0;
//                if($("#step").val() ==4) {
//                    location.href("fa/view/"+$("#faid"));
//                }

            })
            .fail(function () {
                $("#message_container").html("Error saving data" + (( bttn_clicked_txt == "submit_other_email_bttn" || bttn_clicked_txt == "submit_email_bttn") ? " or sending mail." : ""));
                $("#save_msg").modal("show");
                bttn.val(initialText);
            })

    });

    $("#submit_other_email_bttn").click(function () {
        $('#box_other_email').modal('show');
    });


    //check for changes
    $("#info_frm input, #info_frm select, #checklist_frm select,#checklist_frm input, #signature_frm input, #signature_frm select").focus(function () {
        var initialValue = $(this).val();
        $(this).blur(function () {
            if ($(this).val() != initialValue) {
                userMadeChanges = 1;
            }
        });
    });
    if ($(".needs_exit_warning").length > 0) {
        userMadeChanges = 1;
        $("[role=navigation] a, [role=search] button, #sidebar-menu a").click(function (e) {
            var elem = $(this);
            var doCheck = false;
            var isLink = false;
            if (elem.attr("href") && elem.attr("href").indexOf("#") < 0) {
                doCheck = true;
                isLink = true;
            }
            if (elem.is("button")) {
                doCheck = true;
            }
            if (doCheck && userMadeChanges) {
                $("#confirm_exit").modal("show");
                $("#cancel_fa_bttn").click(function () {
                    $.ajax({
                        url: $("#info_frm").attr("action").replace("/save", "/delete_current"),
                        method: 'post',
                        data: {_token: $("[name=_token]").val()}
                    });
                    $("#confirm_exit").modal("hide");
                    if (isLink) {
                        window.location = elem.attr("href");
                    }
                    else if ($(this).is("button")) {
                        elem.parents("form").submit();
                    }
                });


                $("#save_fa_bttn").click(function () {
                    autoSaveChecklist();
                    autoSaveForm();
                    $("#confirm_exit").modal("hide");
                });

            }
            else {
                if (isLink) {
                    window.location = elem.attr("href");
                }
                else if ($(this).is("button")) {
                    elem.parents("form").submit();
                }
            }

            e.preventDefault();

        });
    }


    $("#back_button").click(function (e) {
        e.preventDefault();
        $("#go_to_step").val(parseInt($("#step").val()) - 1);

        if ($("#package_items").length > 0 && $("#package_items").val()) {


            if ($("#packages_stock_checked").val() == 1) {
                $("#info_frm, #signature_frm").submit();
            }
            else {
                $.ajax({
                    url: "/fa/get_stock_info",
                    method: "GET",
                    data: {package_items: $("#package_items").val()}
                }).done(function (data) {
                    if (data) {
                        $("#general_popupA").find(".modal-body").html(data);
                        $("#general_popupA").find(".modal-title").text("Stock status");
                        $("#general_popupA").modal("show");

                        $("#general_popupA").find("#save_general_bttn").click(function () {
                            var arr = $("#package_items").val().split(",");
                            for (var i = 0; i < arr.length; i++) {
                                var it_id = arr[i].replace("w", "").replace("s", "");
                                if ($("#storage_select_item_" + it_id).length) {
                                    arr[i] = it_id + $("#storage_select_item_" + it_id).val();
                                }
                            }
                            $("#package_items").val(arr.join(","));
                            $("#packages_stock_checked").val(1);
                            $("#general_popupA").modal("hide");
                            $("#info_frm, #signature_frm").submit();

                        });

                        $("#general_popupA").find("#cancel_general_bttn").click(function () {
                            $("#general_popupA").modal("hide");
                        });
                    }
                    else {
                        $("#info_frm, #signature_frm").submit();
                    }
                });
            }
        }
        else {
            $("#info_frm, #signature_frm").submit();
        }
    });

    //$('body').on('click', '#next_bttn', function(e) {
    $("#next_bttn").click(function (e) {
        e.preventDefault();
        $("#go_to_step").val(parseInt($("#step").val()) + 1);
        // must save files
        autoSaveChecklist();
//       For point 9 To remove items from inventory
        $selected_item_data = "";
        if ($("#ac_selection_item_2").val()) {
            $selected_item_data += "," + $("#ac_selection_item_2").val();
        }
        if ($("#ac_selection_item_0").val()) {
            $selected_item_data += "," + $("#ac_selection_item_0").val();
        }
        if ($("#ac_selection_item_4").val()) {
            $selected_item_data += "," + $("#ac_selection_item_4").val();
        }
        if ($("#ac_selection_item_1").val()) {
            $selected_item_data += "," + $("#ac_selection_item_1").val();
        }
        if ($("#ac_selection_item_3").val()) {
            $selected_item_data += "," + $("#ac_selection_item_3").val();
        }

//                   Start For FA for repartration
        if ($("#si_selection_item_0").val()) {
            $selected_item_data += "," + $("#si_selection_item_0").val();
        }
        if ($("#si_selection_item_1")) {
            $selected_item_data += "," + $("#si_selection_item_1").val();
        }
        if ($("#si_selection_item_2")) {
            $selected_item_data += "," + $("#si_selection_item_2").val();
        }
        if ($("#si_selection_item_3")) {
            $selected_item_data += "," + $("#si_selection_item_3").val();
        }
//                  End for FA for repartration

        if ($selected_item_data) {
            $("#packages_stock_checked").val(0);
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($("#package_items").length > 0 && $("#package_items").val() || $("#group_items").length > 0 && $("#group_items").val()) {

            var arr = $("#package_items").val().split(",");

            for (var i = 0; i < arr.length; i++) {
                var it_id = arr[i].replace("w", "").replace("s", "").replace("Select location", "");

                //if ($("#storage_select_item_"+ it_id ).length){
                arr[i] = it_id + "s";

                //}
            }

            $("#package_items").val(arr.join(","));
            $("#packages_stock_checked").val(1);

            var group = [];


            $("[id ^=ac_selection_item_]").each(function () {

                group.push($(this).val() + "s");

            });

            $("#group_items").val(group.join(","));
            $("#group_items_checked").val(1);

            $("#info_frm, #signature_frm").submit();


            /*if ($("#packages_stock_checked").val() == 1){
             $("#info_frm, #signature_frm").submit();
             }
             else{
             $.ajax({
             url: "/fa/get_stock_info",
             method: "GET",
             data: { package_items: $("#package_items").val(),
             selected_item: $selected_item_data}
             }).done(function(data) {

             if (data){

             $("#general_popupA").find(".modal-body").html(data);
             $("#general_popupA").find(".modal-title").text("Stock status");
             $("#general_popupA").modal("show");

             $("#general_popupA").find("#save_general_bttn").click(function(){
             var arr = $("#package_items").val().split(",");

             for (var i=0; i< arr.length; i++){
             var it_id = arr[i].replace("w","").replace("s","").replace("Select location","");

             if ($("#storage_select_item_"+ it_id ).length){
             arr[i] = it_id + $("#storage_select_item_"+it_id ).val();

             }
             }


             $("#package_items").val(arr.join(","));
             $("#packages_stock_checked").val(1);

             var group =[];
             $("[id ^=group_select_item_]").each(function(){

             group.push($(this).attr("id").replace("group_select_item_","")+ $(this).val());

             });





             $("#group_items").val(group.join(","));
             $("#group_items_checked").val(1);

             $("#general_popupA").modal("hide");


             $("#info_frm, #signature_frm").submit();

             });

             $("#general_popupA").find("#cancel_general_bttn").click(function(){
             $("#general_popupA").modal("hide");
             });
             }
             else{
             $("#info_frm, #signature_frm").submit();
             }
             });
             }*/


        }
        else {
            $("#info_frm").submit();
        }


    });


    // Parlour
    $("form").activateParlourPopup();

    $("#add_more_parlour_rows").click(function (e) {
        e.preventDefault();
        var parlour_rows = $("#parlour_rows").val();
        var form_nr = $("#form_nr").val();
        //if(parlour_rows > 2 ) {
        var html;
        html = '<tr>' +
            '<td class="field_container">' +
            '<a href="#" id="add_parlour_' + parlour_rows + '" class="add_parlour">Add parlour</a>' +
            '<input type="hidden" id="parlour_id_' + parlour_rows + '" name="parlour_id[]"/>' +
            '<input type="hidden" id="parlour_unit_price_' + parlour_rows + '" name="parlour_unit_price[]"/>' +
            '<input type="hidden" id="parlour_total_price_' + parlour_rows + '" name="parlour_total_price[]"/>' +
            '<input type="hidden" id="parlour_hours_' + parlour_rows + '" name="parlour_hours[]"/>' +
            '<input type="hidden" id="parlour_order_id_' + parlour_rows + '" name="parlour_order_id[]"/>' +
            '</td>' +
            '<td class="input_container">' +
            '<input type="text" class="form-control" id="parlour_name_' + parlour_rows + '" name="parlour_name[]"/>' +
            '</td>' +
            '<td class="field_container">From date</td>' +
            '<td class="input_container">' +
            '<input type="text" class="form-control" id="parlour_from_date' + parlour_rows + '" name="parlour_from_date[]"/>' +
            '</td>' +
            '<td class="field_container">From Time</td>' +
            '<td class="input_container">' +
            '<input type="text" class="form-control" id="parlour_from_time' + parlour_rows + '" name="parlour_from_time[]"/>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td></td>' +
            '<td></td>' +
            '<td class="field_container">To date</td>' +
            '<td class="input_container">' +
            '<input type="text" class="form-control" id="parlour_to_date' + parlour_rows + '" name="parlour_to_date[]"/>' +
            '</td>' +
            '<td class="field_container">To Time</td>' +
            '<td class="input_container">' +
            '<input type="text" class="form-control" id="parlour_to_time' + parlour_rows + '" name="parlour_to_time[]"/>' +
            '</td>' +
            '</tr>';
        var newRow = $("#add_more_parlour").before(html);
        parlour_rows++;
        $("#parlour_rows").val(parlour_rows);
        newRow.activateParlourPopup();
        /*}
         else {
         var message = "Please use above parlour form!";
         $("#message_container").html(message);
         $("#save_msg").modal("show");
         return false;
         }*/

    });


    // Hearse
    $("form").activateHearsePopup();


    // step 2
    $("[name^=ac_selection_item]").change(function () {
        var nr = $(this).attr("id").replace("ac_selection_item_", "");
        $("#ac_price_txt_" + nr).text($(this).find("option:selected").data("price"));
        $("#ac_price_" + nr).val($(this).find("option:selected").data("price"));
        $("#ac_price_save_" + nr).val($(this).find("option:selected").data("price"));
    });

    // step 2 & 3
    if ($(".price_col input").length) {
        $("input, select").blur(function () {
            calculateTableTotal();
        });

        $("input, select").change(function () {
            calculateTableTotal();
        });
    }

    // step 3
    $("#add_package").click(function (e) {
        e.preventDefault();
        var newNr = $("[id^=more_package_name]").length;
        var newTr = $("#draft_add_package").clone();
        newTr.find("select, input").each(function () {
            $(this).attr("id", $(this).attr("id").replace("_0", "_" + newNr));
        });
        newTr.removeAttr("id").css("display", "table-row");
        $(this).parents("tr").before(newTr);

        newTr.find("select[id^=more_package_name]").change(function () {
            var parts = $(this).val().split("|");
            $(this).parents("tr").find("[id^=more_package_selection_item]").hide();
            $(this).parents("tr").find("[id^=more_package_selection_item_" + parts[1] + "]").show();
        });

        newTr.find("[id^=more_package_selection_item]").change(function () {
            var str = $(this).parents("tr").find("[id^=more_package_name]").attr("id").replace("name", "price");
            var strSave = $(this).parents("tr").find("[id^=more_package_name]").attr("id").replace("name", "price_save");
            $(this).parents("tr").find("[id^=" + str + "],[id^=" + strSave + "]").val(($(this).find("option:selected").data("price")).toFixed(2));
        });

        newTr.find("input, select").change(function () {
            calculateTableTotal();
        });
    });

    $("select[id^=more_package_name]").change(function () {
        var parts = $(this).val().split("|");
        $(this).parents("tr").find("[id^=more_package_selection_item]").hide();
        $(this).parents("tr").find("[id^=more_package_selection_item_" + parts[1] + "]").show();
    });
    $("[id^=more_package_selection_item]").change(function () {
        var str = $(this).parents("tr").find("[id^=more_package_name]").attr("id").replace("name", "price");
        var strSave = $(this).parents("tr").find("[id^=more_package_name]").attr("id").replace("name", "price_save");
        $(this).parents("tr").find("[id^=" + str + "],[id^=" + strSave + "]").val($(this).find("option:selected").data("price"));
    });


    $("[id^=si_selection_item]").change(function () {
        var str = $(this).attr("id").replace("selection_item", "price");
        var strSave = $(this).attr("id").replace("selection_item", "price_save");
        $("[id^=" + str + "],[id^=" + strSave + "]").val($(this).find("option:selected").data("price"));
    });

    $("#miscellaneous_selection").change(function () {
        if ($(this).val() == "special_discount") {
            $("#special_discount_popup").modal("show");
            $("#special_discount_popup").find(".submit_bttn").click(function () {
                $("#miscellaneous_amount").val($(this).parents(".modal-content").find("#discount_amount").val());
                $("#miscellaneous_approving_supervisor").val($(this).parents(".modal-content").find("#approving_supervisor").val());
                $("#miscellaneous_approval_code").val($(this).parents(".modal-content").find("#approval_code").val());
                $("#special_discount_popup").modal("hide");
            });
        }

    });


    $("#repatriation_add_package").click(function () {
        var tr = $("#repatriation_add_more_default").clone();
        tr.removeAttr("id");
        tr.css("display", "table-row");
        $(this).parents("tr").before(tr);
    });

    $("[id^=box_pack]").click(function () {

        $("[id^=box_pack]").removeClass("selected");
        $(this).addClass("selected");

        $("#packages_stock_checked").val(0);
        //   $(".product_box").removeClass("selected");

        $("#package_items").val("");
        $("#package_total").val(0);

        $("[id^=pack_]").hide();
        var pid = $(this).attr("id").replace("box_pack_", "");
        $("#pack_" + pid).show();
        //$("#add_hearse .modal-body").html('<div class=package_items_listing>'+$("#pack_" + pid ).html()+'</div>');

        var promotion_price = $(this).find('.promo_price').html();
        promotion_price = promotion_price.replace("$", "");
        $(".package_total_s").html(promotion_price);


        $("#package_items_modal_" + pid).modal("show");


        // $("#package_listing").slideUp();
        $("#open_packages").show();

    });

    /////
    $(".btn-primary").click(function () {
        $("[id^=package_items_modal]").modal("hide");
    });

    $("#open_packages").click(function (e) {
        e.preventDefault();
        $("#package_listing").slideDown();
        $(this).hide();
    });


    $(".product_box").click(function () {

        $("#packages_stock_checked").val(0);

        var arr = [];
        var total = 0;

        var me = $(this);

        $(this).closest("div .blank_mark").find(".product_box").each(function () {
            if (!me.is($(this)) && $(this) && $(this).hasClass("selected")) {
                $(this).removeClass('selected');
            }
        });

        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            $(this).addClass("selected");
        }


        $(".product_box").each(function () {
            if ($(this).hasClass("selected")) {
                arr[arr.length] = $(this).attr("id").replace("packitem_", "");
                if ($(this).find(".add_on_price").length > 0) {
                    total += parseFloat($(this).find(".add_on_price").text());
                }
            }
        });
        total += $(this).parents(".package_items_listing").data("promo_price");
        $("#package_items").val(arr.join(","));
        $("#package_total").val(total.toFixed(2));
        $(".package_total_s").html(total.toFixed(2));

    });


    $("#fa_code").val($("#number").text().replace("WSC", "").trim());
    $("#funeral_arrangement_id").val($("#faid").val());


    ///////////////////////////////////////////////////////////////////
    //====In step2, add more others
    $('body').on('click', '#add_more_other_rows', function (e) {
        e.preventDefault();

        var rows = $("#other_rows").val();
        var new_row_id = parseInt(rows) + 1;
        var tr = '<tr id="other_row_' + new_row_id + '"><td></td>' +
            '<td><input type="text" class="form-control" id="others_' + new_row_id + '" name="others[]"></td>' +
            '<td class="price_col"><input type="number" min="0.01" step="0.01" class="form-control num" id="others_price_' + new_row_id + '" name="others_price[]"></td>' +
            '<td><textarea type="text" id="others_remarks_' + new_row_id + '" name="others_remarks[]" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;"></textarea></td>' +
            '</tr>';
        $('#other_row_' + rows).after(tr);

        $("#other_rows").val(new_row_id);
    });

    $('body').on('keyup mouseup', ".num", function () {
        calculateTableTotal();
    });

    // AUTOSAVE
    //   setInterval(autoSaveForm, 10000);
    calculateTableTotal();

});

function calculateTableTotal() {
    if ($(".price_col input").length > 0) {
        var sum = 0;
        $(".price_col input").each(function () {
            if ($(this).val() && $(this).attr("type") != "hidden") {
                sum += parseFloat($(this).val());
            }
            if ($(this).parent().prev().prev().prev().text().trim() == "Coffin catalog") {
                //$("input[name='coffin_price']").val(parseFloat($(this).val(0)).toFixed(2));
            }
        });
        $("#total").text(sum.toFixed(2));
        $("#total_input").val(sum.toFixed(2));
        if ($("#total_with_gst").length > 0) {
            $("#sub_total").val(sum.toFixed(2));
        }
    }
    if ($("#total_with_gst").length > 0) {

        var final_total = parseFloat($("#sub_total").val());
        if ($("#discount").length > 0 && parseFloat($("#discount").val()) > 0) {
            var coffin_price_value = parseFloat($("input[name='coffin_price_4']").val());
            if (parseFloat($("#discount").val()) == 5) {				//////////////////////////////////////////////////////////////

                final_total -= Math.round(parseFloat($("#discount").val()) * coffin_price_value * 100) / 10000;
            } else {
                final_total -= Math.round(parseFloat($("#discount").val()) * final_total * 100) / 10000;
            }
        }
        if ($("#special_discount").length > 0) {
            final_total -= parseFloat($("#special_discount").val());
        }
        final_total = Math.round(final_total * 100) / 100;
        $("#final_total").val(final_total.toFixed(2));
        var gst = final_total * 7 / 100;
        gst = Math.round(gst * 100) / 100;
        $("#gst_value").val(gst.toFixed(2));
        final_total += gst;
        $("#total_with_gst").val(final_total.toFixed(2));
    }
}

$.fn.activateParlourPopup = function () {
    $(".add_parlour").click(function (e) {
        var form_nr = $(this).attr("id").replace("add_parlour_", "");
        e.preventDefault();
        var nr = $(this).attr("parlour_order_id");
        $("#parlour_popup").modal("show");
        if (nr > 0) {
            $.ajax({
                method: "GET",
                url: "/fa/get_parlour_order/",
                data: {parlour_id: nr}
            }).done(function (data) {
                $(".selected_item").removeClass('selected_item');
                $("#item_" + data.order.parlour_id).addClass('selected_item');

                $("#order_id").val(data.order.id);
                $("#parlour_id").val(data.order.parlour_id);
                $("#capacity").val(data.order.capacity);
                $("#created_at").html(data.order.created_at);
                $("#parlour_selection_container").html(data.order.parlour_name);
                $("#parlour_name").val(data.order.parlour_name);
                //$("#fa_code").val(data.fa_code);
                var fa_code = $('#number').html().replace("WSC", "").trim();
                //alert(fa_id);
                //$("#fa_id").val(fa_id);
                $("#fa_code").val(fa_code);
                $("#unit_price_container").html(data.order.unit_price);
                $("#unit_price").val(data.order.unit_price);
                $("#order_nr").val(data.order.order_nr);

                var booked_from_day = dateFormat(data.order.booked_from_day);
                var booked_to_day = dateFormat(data.order.booked_to_day);

                $("#booked_from_day").val(booked_from_day);
                $("#booked_to_day").val(booked_to_day);

                $("#booked_from_time").val(data.order.booked_from_time.substring(0, 5));
                $("#booked_to_time").val(data.order.booked_to_time.substring(0, 5));
                $("#total_price_span").html('$' + data.order.total_price);
                $("#total_price").val(data.order.total_price);
                //$("#hours").val(data.order.unit_price);
                $("#parlour_deceased_name").val(data.order.deceased_name);
                $("#parlour_cp_name").val(data.order.cp_name);
                $("#parlour_cp_nric").val(data.order.cp_nric);
                $("#box1").html('<img src="' + data.order.signature + '" style="width:100px">');
                $("#date_signature_1").html(data.order.signature_date);
                $("#taken_by").html(data.taken_by);
                $("#taken_date").html(data.order.created_at);
                $("#form_nr").val(form_nr);
                $("#parlour_popup").modal("show");
            });
        } else {
            $(".selected_item").removeClass('selected_item');

            $("#order_id").val('');
            $("#parlour_id").val('');
            $("#capacity").val('');
            //$("#created_at").html('');
            $("#parlour_selection_container").html('');
            $("#parlour_name").val('');
            $("#fa_code").val('');
            var fa_code = $('#number').text().replace("WSC", "").trim();
            //$("#fa_id").val(fa_id);
            $("#fa_code").val(fa_code);
            $("#unit_price_container").html('');
            $("#unit_price").val('');
            $("#order_nr").val('');
            $("#booked_from_day").val('');
            $("#booked_to_day").val('');

            $("#booked_from_time").val('');
            $("#booked_to_time").val('');
            $("#total_price_span").html('');
            $("#total_price").val('');
            //$("#hours").val(data.order.unit_price);
            var deceased_name = $("#deceased_name").val();
            $("#parlour_deceased_name").val(deceased_name);

            var cp_name = $("#first_cp_name").val();
            $("#parlour_cp_name").val(cp_name);

            var nric = $("#first_cp_nric").val()
            $("#parlour_cp_nric").val(nric);

            $("#box1").html('');
            $("#date_signature_1").html('');
            //$("#taken_by").html('');
            //$("#taken_date").html('');
            $("#form_nr").val(form_nr);
            $("#parlour_popup").modal("show");
        }

    });
};

$.fn.activateHearsePopup = function () {
    $(this).find("#add_hearse_bttn").click(function (e) {
        e.preventDefault();

        $.ajax({
            method: "GET",
            url: "/hearse/popup",
            data: {hearse_id: $("#hearse_id").val()}
        })
            .done(function (data) {
                $("#add_hearse .modal-body").html(data);
                $("#add_hearse #fa_id").val($("#faid").val());
                $("#add_hearse #item_" + $("#hearse_id").val()).addClass("selected_item").click();

                $("#add_hearse #unit_price_container").text("$" + $("#hearse_unit_price").val());
                $("#add_hearse #unit_price").val($("#hearse_unit_price").val());

                $("#add_hearse").find("#total_price_span").text("$" + $("#hearse_price").val());
                $("#add_hearse").find("#total_price").val($("#hearse_price").val());

                $("#add_hearse").find("#hearse_selection_container").text($("#hearse_name").val());
                $("#add_hearse").find("#hearse_name").val($("#hearse_name").val());

                if ($("#hearse_from").val()) {
                    var arrFrom = $("#hearse_from").val().split(" ");
                    $("#add_hearse").find("#booked_from_day").val(arrFrom[0]);
                    $("#add_hearse").find("#booked_from_time").val(arrFrom[1]);
                }

                if ($("#hearse_to").val()) {
                    var arrTo = $("#hearse_to").val().split(" ");
                    $("#add_hearse").find("#booked_to_day").val(arrTo[0]);
                    $("#add_hearse").find("#booked_to_time").val(arrTo[1]);
                }

                $("#add_hearse").modal("show");

                $("#add_hearse").find("#add_info_bttn").click(function () {
                    $("#hearse_price_txt").text($("#add_hearse").find("#total_price").val());
                    $("#hearse_price").val($("#add_hearse").find("#total_price").val());
                    $("#hearse_price_save").val($("#add_hearse").find("#total_price").val());

                    $("#hearse_unit_price").val($("#add_hearse").find("#unit_price").val());
                    $("#hearse_name").val($("#add_hearse").find("#hearse_name").val());
                    $("#hearse_id").val($("#add_hearse").find("#hearse_id").val());
                    $("#hearse_from").val($("#add_hearse").find("#booked_from_day").val() + " " + $("#add_hearse").find("#booked_from_time").val());
                    $("#hearse_to").val($("#add_hearse").find("#booked_from_day").val() + " " + $("#add_hearse").find("#booked_to_time").val());
                    $("#hearse_remarks").val("from " + $("#hearse_from").val() + " to " + $("#hearse_to").val());
                    $("#add_hearse").modal("hide");

                    calculateTableTotal();
                });

                jQuery.getScript("/js/app/hearse.js");
            });


    });
};


function autoSaveChecklist() {
    if (pendingReq) {
        pendingReq.abort();
    }

    var path = ($("#checklist_frm").attr("action")) ? $("#checklist_frm").attr("action") : '/fa/autosave_checklist';

    pendingReq = $.ajax({
        url: path,
        method: 'post',
        data: $("#checklist_frm").serialize(),
        complete: function () {
            pendingReq = null;
        }
    });
}

function autoSaveForm() {

    if (userMadeChanges) {

        var form = ($("#info_frm").length > 0) ? $("#info_frm") : $("#signature_frm");

        if (pendingFormReq) {
            pendingFormReq.abort();
        }
        pendingFormReq = $.ajax({
            url: form.attr("action"),
            method: 'post',
            data: form.serialize(),
            complete: function () {
                pendingFormReq = null;
                userMadeChanges = false;
                if ($("#autosave_msg").length > 0) {
                    var parts = $(this).val().split("/");
                    var d = new Date(parts[2] + "-" + parts[1] + "-" + parts[0]);
                    var dObj = new Date();
                    var d = dObj.Date();
                    var m = dObj.Date();
                    var h = dObj.Date();
                    var min = dObj.Date();
                    var s = dObj.Date();
                    $("#autosave_msg").html(((d < 10) ? "0" : "") + d + "/" + ((m < 10) ? "0" : "") + m + "/" + dObj.getFullYear() + " " + ((h < 10) ? "0" : "") + h + " " + ((min < 10) ? "0" : "") + min + ":" + ((s < 10) ? "0" : "") + s);
                }
            }
        });
    }
}


var html = "";
arrangementForm();
function arrangementForm() {

    $("#fa_form .fa_section tr").each(function (i) {
        if ($(this).children().first().text().trim() == "Coffin catalog") {
            $(this).attr("class", "order-form_0");
        } else if ($(this).children().first().text().trim() == "Manpower") {
            $(this).attr("class", "order-form_1");
        } else if ($(this).children().first().text().trim() == "Embalming") {
            $(this).attr("class", "order-form_2");
        } else if ($(this).children().first().text().trim() == "Makeup") {
            $(this).attr("class", "order-form_3");
        } else if ($(this).children().first().text().trim() == "Parlour") {
            $(this).attr("class", "order-form_4");
        } else if ($(this).children().first().text().trim() == "Photo enlargement") {
            $(this).attr("class", "order-form_5");
        } else if ($(this).children().first().text().trim() == "Passport photo") {
            $(this).attr("class", "order-form_6");
        } else if ($(this).children().first().text().trim() == "Package Flower") {
            $(this).attr("class", "order-form_7");
        } else if ($(this).children().first().text().trim() == "Frame Size") {
            $(this).attr("class", "order-form_8");
        } else if ($(this).children().first().text().trim() == "Hearse Flower") {
            $(this).attr("class", "order-form_9");
        } else if ($(this).children().first().text().trim() == "Itemisation Flower") {
            $(this).attr("class", "order-form_10");
        } else if ($(this).children().first().text().trim() == "Backdrop") {
            $(this).attr("class", "order-form_11");
        } else if ($(this).children().first().text().trim() == "Hearse") {
            $(this).attr("class", "order-form_12");
        } else if ($(this).children().first().text().trim() == "Urns") {
            $(this).attr("class", "order-form_13");
        } else if ($(this).children().first().text().trim() == "Columbarium Order") {
            $(this).attr("class", "order-form_14");
        } else if ($(this).children().first().text().trim() == "Cremation Fee") {
            $(this).attr("class", "order-form_15");
        } else if ($(this).children().first().text().trim() == "Night Care service team ( services )") {
            $(this).attr("class", "order-form_16");
        } else if ($(this).children().first().text().trim() == "Disposal of coffin") {
            $(this).attr("class", "order-form_17");
        } else if ($(this).children().first().text().trim() == "Gem stone") {
            $(this).attr("class", "order-form_18");
        } else {
        }


    });
    $("#fa_form .fa_section tr").each(function (i) {
        $(".fa_section tr").each(function (k) {


            if ($(this).attr("class") == "order-form_" + i) {

                if ($(this).attr("id") == "parlour_row_0") {

                    html = html + "<tr id='parlour_row_0'>" + $(this).html() + "</tr>";
                } else {
                    html = html + "<tr>" + $(this).html() + "</tr>";
                }
            }
        });
    });

    $("#fa_form .fa_section tr[class^=order-form]").remove();
    $("#fa_form .fa_section table.table-striped tbody").prepend(html);
}

$(".input_container #birthdate").datepicker({
    startView: 2,

    singleDatePicker: true,
    timePicker: false,
    changeMonth: true,
    changeYear: true,
    format: 'dd/mm/yyyy',


}).on("changeDate", function (date) {

    var date2 = $(this).datepicker('getDate');
    date2.setDate(date2.getDate() + 1);
    $(".input_container #deathdate").datepicker('setStartDate', date2).focus();
    $(this).datepicker("hide");

});

$(".input_container #deathdate").datepicker({
    startView: 2,

    singleDatePicker: true,
    timePicker: false,
    changeMonth: true,
    changeYear: true,
    format: 'dd/mm/yyyy',
}).on("changeDate", function (date) {
    $(this).datepicker("hide");
});

$("#funeral_date").datepicker({

    singleDatePicker: true,
    timePicker: false,
    changeMonth: true,
    changeYear: true,
    format: 'dd/mm/yyyy',
    startDate: 'today'


});

$("#cortege_date").datepicker({

    singleDatePicker: true,
    timePicker: false,
    changeMonth: true,
    changeYear: true,
    format: 'dd/mm/yyyy',
    startDate: 'today'


});
///
$("#sent_to_parlour").click(function () {

    $("#parlour_popup").modal("show");
});

///


function close_all_popup() {

    $("#booking_save_msg").modal("hide");
    $("#parlour_popup").modal("hide");
}


$("#fa_form").find(".blank_mark").each(function () {

    if ($(this).find("div").length == 1) {
        $(this).prev().remove();
        $(this).remove();
    }
});

var whichModal = "";
var whichItem = ""
$("#Coffin , #Backdrop, #Urns , #Burial , #Gem ,#view_coffin_with_popup").click(function (e) {
    e.preventDefault();

    if ($(this).attr("id") == "Coffin") {
        $elementType = "add_coffin_catalog";
    } else if ($(this).attr("id") == "Backdrop") {
        $elementType = "add_backdrop";
    } else if ($(this).attr("id") == "Urns") {
        $elementType = "add_urns";
    } else if ($(this).attr("id") == "Burial") {
        $elementType = "add_burial_plot";
    } else if ($(this).attr("id") == "Gem") {
        $elementType = "add_gem_stones";
    } else {
        $elementType = "add_far_popup"
    }
    whichModal = $elementType;
    whichItem = $(this).attr("id");
    $.ajax({
        method: "GET",
        url: "/settings/get_images_for_popup",
        data: {elementType: $elementType}
    })
        .done(function (data) {
            $("#" + $elementType + " .modal-body").html(data);


            $("#" + $elementType).modal("show");


            // jQuery.getScript("/js/app/hearse.js");
        });


});


var preItemName = "";
var preItemPrice = "";
function selectImagesInsteadItem2select(e) {

    if (!$(e).hasClass("not_available")) {

        $("#" + whichModal).find(".item2select").removeClass("selected_item");
        $(e).addClass("selected_item");


        $item_id = $(e).attr("id").replace("ala_carte_item_", "");
        $item_price = $(e).find("span.unit_price").text();

//         $(e).off("click").on("click");
        $("#" + whichItem).parent().next().find("option").removeAttr("selected");
        $("#" + whichItem).parent().next().find("option[value=" + $item_id + "]").attr("selected", "selected");

        if (whichItem == "view_coffin_with_popup") {
            $("#" + whichItem).parent().next().next().next().find("input:first").val($item_price);
            $("#" + whichItem).parent().next().next().next().find("input:last").val($item_price);
        } else {
            $("#" + whichItem).parent().next().next().find("input:first").val($item_price);
            $("#" + whichItem).parent().next().next().find("input:last").val($item_price);
        }
        calculateTableTotal();
        ///////////////////// get all images//
        //	$id = $(e).attr("id");
        //	$changedId = $id.replace("ala_carte_item_","");

        $.ajax({
            url: "/settings/get_all_images",
            method: "GET",
            dataType: "json",
            data: {id: $item_id},

            statusCode: {
                401: function () {
                    alert("Login expired. Please sign in again.");
                }
            }
        }).done(function (data) {

            $htmls = "";
            if (data != "") {
                for ($i = 0; $i < data.length - 1; $i++) {
                    $htmls += "<img src='/uploads/" + data[$i] + "' width=300 style='margin:10px 10px 10px 10px'/>";
                }
            } else {
                $htmls = "No preview images";
            }
            $("#view_all_images_for_ala_carte .modal-body").html($htmls);
            $("#view_all_images_for_ala_carte").modal("show");
        })
    }
}

function selectPackageItemsImageView(e) {
    var item_id = $(e).attr("id").replace("product_item_", "");
    console.log(item_id);
    $.ajax({
        url: "/fa/get_full_image",
        method: "GET",
        data: {id: item_id},

        statusCode: {
            401: function () {
                alert("Login expired. Please sign in again.");
            }
        }
    }).done(function (data) {
        console.log(data);
        var htmls = "";
        if (data != "") {
            htmls += "<img src='/uploads/" + data + "' width=600 style='margin:10px 10px 10px 10px'/>";

        } else {
            htmls = "No preview images";
        }
        $("#view_all_images_for_ala_carte .modal-body").html(htmls);
        $("#view_all_images_for_ala_carte").modal("show");
    });
}

$("#all_image_view_close").click(function () {
    $("#view_all_images_for_ala_carte").modal("hide");
});

$(".selected-item-ok").click(function () {
    $("#" + whichModal).modal("hide");
});