$(document).on('click', '.gridSecondaryButton', function () {
    //$(".gridSecondaryButton").click(function() {
    $('.gridContent').fadeOut();
    $('.gridContent').empty();

    $('#example1_wrapper').fadeIn();
    $('#dataTabe_wrapper').fadeIn();
    $('.addButton').fadeIn();
    $('#addElements').fadeIn();
    $('.btn-group').fadeIn();
    $('#listHeading').fadeIn();
    $('.box').fadeIn();


});
//$(".gridDeleteButton").click(function() {


//$(".gridResetPasswordButton").click(function() {
$(document).on('click', '.gridResetPasswordButton', function () {
    var cell = $(this).closest('tr').attr('title'); //The Primary key for the row
    var page = $('#nextpage').val(); //The Id representing the inner page
    $('#ajaxcontent' + cell).hide();
    $('#loading' + cell).show();
    var form = $(this).closest("form");
    var formname = form.attr("name");

    var msg = "Are you sure you want to reset User's password?";
    /*
     if(formname=="user"){
     msg = "Are you sure you want to "+$(this).val()+"?";
     }*/

    var resetItem = confirm(msg);
    if (resetItem) {

        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: 'post',
            url: '../../church-ims-test/Shared/php/process_form.php?f=' + formname + '&action=resetpassword',

            data: $("[name='" + formname + "']").serialize(),
            success: function (result) {
                //alert(result);
            },
            complete: function () {
                location.reload();
            }
        });

    }
    return false;
});


$(document).on('click', '.gridEditButton1', function () {

    var pageIdentity = $('#this_page_id').val();

    //alert(pageIdentity);
    var editConfigItem = true;
    if (pageIdentity == '19') {
        editConfigItem = confirm("Changing Approval Configuration may cause the system to malfuction. Ensure that all records under this category are approved before editing. Click Ok to proceed or Cancel to Exit");
    }
    if (editConfigItem) {

        var table = $('#example1').DataTable();
        var tr = $(this).closest('tr').prev();
        var row = table.row(tr);


        if (row.child.isShown()) {


            $('div.slider', row.child()).slideUp(function () {
                // alert("yes");
                row.child.hide();
                tr.removeClass('shown');
            });
        }
        editEvent();


    }

    return false;

});

//alert("kuku");
$(document).on('click', '.resolveBizCustomer', function () {
    //$(".gridSecondaryButton").click(function() {

    var data = $(this).attr('id').split("|");
    var c_id = data[0];
    var action = data[1];


    var id = 86;
    if (action == 'directors') {
        id = 86;
    } else if (action == 'nominees') {
        id = 87;
    } else if (action == 'programs') {
        id = 89;
    } else if (action == 'accs') {
        id = 90;
    }


    var cell = $("#formRecordId").val();

    $('#example1_wrapper').fadeOut();
    // $('#loadingAdd').show();
    $('.addButton').fadeOut();
    $('#addElements').fadeOut();
    $('.btn-group').fadeOut();
    $('#listHeading').fadeOut();
    $('.box').fadeOut();


    // url: '../../church-ims-test/Shared/php/resolve.php',


    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'sid=1&id=' + id + '&c_id=' + c_id,
        success: function (result) {
            //$('#gridform').show();
            //  $('#gridform').html(result);
            // console.log("EditResults: "+result);
            $('.gridContent').show();
            $('.gridContent').html(result);

        },
        complete: function () {
            $('#loadingAdd').hide();
        }
    });
    return false;
});

$(document).on('click', '.gridEditCustomerdetails', function () {


    var data = $(this).attr('id').split("|");
    var cell_id = data[0];
    var action = data[1];
    var c_id = data[2];


    var id = 86;
    if (action == 'directors') {
        id = 86;
    } else if (action == 'nominees') {
        id = 87;
    } else if (action == 'programs') {
        id = 89;
    } else if (action == 'accs') {
        id = 90;
    }


    var cell = $("#formRecordId").val();

    $('#example1_wrapper').fadeOut();
    // $('#loadingAdd').show();
    $('.addButton').fadeOut();
    $('#addElements').fadeOut();
    $('.btn-group').fadeOut();
    $('#listHeading').fadeOut();
    $('.box').fadeOut();


    // url: '../../church-ims-test/Shared/php/resolve.php',


    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'sid=1&id=' + id + '&c_id=' + c_id + '&cell_id=' + cell_id,
        success: function (result) {
            //$('#gridform').show();
            //  $('#gridform').html(result);
            // console.log("EditResults: "+result);
            $('.gridContent').show();
            $('.gridContent').html(result);

        },
        complete: function () {
            $('#loadingAdd').hide();
        }
    });
    return false;
});

function editEvent() {


    var cell = $("#formRecordId").val();

    $('#example1_wrapper').fadeOut();
    // $('#loadingAdd').show();
    $('.addButton').fadeOut();
    $('#addElements').fadeOut();
    $('.btn-group').fadeOut();
    $('#listHeading').fadeOut();
    $('.box').fadeOut();

    $.blockUI({
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });


    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'sid=1&id=' + $('#this_page_id').val() + '&cell=' + cell,
        success: function (result) {
            //$('#gridform').show();
            //  $('#gridform').html(result);
            // console.log("EditResults: "+result);
            $('.gridContent').show();
            $('.gridContent').html(result);

        },
        complete: function () {
            $('.blockUI').remove();
            $('#loadingAdd').hide();
        }
    });
    return false;
}

$(document).on('click', '.gridDeleteButton', function () {

    var deleteItem = confirm("Are you sure you want to delete?");
    if (deleteItem) {
        var cell = $(this).closest('tr').attr('title'); //The Primary key for the row
        var page = $('#nextpage').val(); //The Id representing the inner page
        $('#ajaxcontent' + cell).hide();
        $('#loading' + cell).show();
        var form = $(this).closest("form");
        var formname = form.attr("name");
        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: 'post',
            url: '../../church-ims-test/Shared/php/process_form.php?f=' + formname + '&action=delete',
            data: $("[name='" + formname + "']").serialize(),
            success: function (result) {
                // alert('done');
            },
            complete: function () {
                $('.blockUI').hide();
                loadData($('#this_page_id').val());
            }
        });

    }
    return false;
});


$(document).on('click', '.gridCustomDelete', function () {

    var data = $(this).attr('id').split("|");
    var cell_id = data[0];
    var table_name = data[1];
    var column = data[2];

    console.log("Cell " + cell_id);
    console.log("Table " + table_name);
    console.log("Column " + column);

    console.log('../../church-ims-test/Shared/php/process_form.php?f=custom_delete&table_name=' + table_name + '&cell=' + cell_id + '&column=' + column);

    var deleteItem = confirm("Are you sure you want to delete?");
    if (deleteItem) {
        var cell = $(this).closest('tr').attr('title'); //The Primary key for the row
        var page = $('#nextpage').val(); //The Id representing the inner page
        $('#ajaxcontent' + cell).hide();
        $('#loading' + cell).show();
        var form = $(this).closest("form");
        var formname = form.attr("name");
        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: 'post',
            url: '../../church-ims-test/Shared/php/process_form.php?f=custom_delete&table_name=' + table_name + '&cell=' + cell_id + '&column=' + column,
            // data: $("[name='" + formname + "']").serialize(),
            success: function (result) {
                console.log("Checki: " + result);
                // alert('done');
            },
            complete: function () {
                ///console.log(result);
                $('.blockUI').hide();
                loadData($('#this_page_id').val());
            }
        });

    }
    return false;
});


$(document).on('click', '.gridResendButton', function () {

    var deleteItem = confirm("Are you sure you want to resend message?");
    if (deleteItem) {
        var cell = $(this).closest('tr').attr('title'); //The Primary key for the row
        var page = $('#nextpage').val(); //The Id representing the inner page
        $('#ajaxcontent' + cell).hide();
        $('#loading' + cell).show();
        var form = $(this).closest("form");
        var formname = form.attr("name");
        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: 'post',
            url: '../../church-ims-test/Shared/php/process_form.php?f=' + formname + '&action=resend',
            data: $("[name='" + formname + "']").serialize(),
            success: function (result) {
                // alert('done');
            },
            complete: function () {
                $('.blockUI').hide();
                loadData($('#this_page_id').val());
            }
        });

    }
    return false;
});


//$(".gridPinResetButton").click(function () {
//$(document).on("click",".gridPinResetButton")function () {
$(document).on('click', ".gridPinResetButton", function () {
    console.log("HETETRE");
    var cell_id = $(this).attr('id');

    var page_id = $('#this_page_id').val();
    var resetItem = confirm("Are you sure you want to reset Pin?");
    if (resetItem) {
        var cell = $(this).closest('tr').attr('title'); //The Primary key for the row
        var page = $('#nextpage').val(); //The Id representing the inner page
        $('#ajaxcontent' + cell).hide();
        $('#loading' + cell).show();
        var form = $(this).closest("form");
        var formname = form.attr("name");
        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: 'post',
            url: '../../church-ims-test/Shared/php/process_form.php?f=' + formname + '&action=resetpin&cell_id=' + cell_id,
            data: $("[name='" + formname + "']").serialize(),
            success: function (result) {
                //alert(result);
            },
            complete: function () {
                $('.blockUI').hide();
                loadData(page_id);
            }
        });

    }
    return false;
});

//$(".gridChangePasswordButton").click(function () {
$(document).on('click', ".gridChangePasswordButton", function () {
    var cell_id = $(this).attr('id');
    var deleteItem = confirm("Are you sure you want to Reset password?");
    if (deleteItem) {
        var page_id = $('#this_page_id').val();
        var cell = $(this).closest('tr').attr('title'); //The Primary key for the row
        var page = $('#nextpage').val(); //The Id representing the inner page
        $('#ajaxcontent' + cell).hide();
        $('#loading' + cell).show();
        var form = $(this).closest("form");
        var formname = form.attr("name");
        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: 'post',
            url: '../../church-ims-test/Shared/php/process_form.php?f=' + formname + '&action=resetpassword&cell_id=' + cell_id,
            data: $("[name='" + formname + "']").serialize(),
            success: function (result) {

                console.log(result);
                //alert(result);
            },
            complete: function () {
                $('.blockUI').hide();
                loadData(page_id);
            }
        });

    }
    return false;
});

//$("#action,[name='action']").click(function(e) {


$(document).on('click', "#action,[name='action']", function (e) {

    //alert('action');

    var form = $(this).closest("form");
    var formName = form.attr("name");

    if (formName == 'datasource') {


        var dataType = $('#dataSourceType').val();
        var filel = document.getElementById("excelfileuploadRequire");
        // alert("Length: "+filel.files.length);
        if (dataType == 'Excel') {
            if (filel.files.length === 0) {
                alert("Excel Attachment Required");
                $('#excelfileuploadRequire').attr("style", "border: 1px inset rgb(251, 58, 58);");
                filel.focus();

                return false;

            }
        }
    }

    var ret = true;
    var allVals = [];
    if (formName == 'user' || formName == 'role') {
        $('[name="permission[]"]:checked').each(function () {
            allVals.push($(this).attr("value"));
        });
    }

    $('[name="' + formName + '"] .required').each(function (i, obj) {
        if ($(this).is(":visible")) {
            if ($(this).val() == "") {
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please complete");
                ret = false;
                return false;

            } else if ($(this).hasClass("email") && !($(this).val().match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/))) {
                //  $(this).attr("value", "");
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please provide a valid email address");
                ret = false;
                return false;
            } else if ($(this).hasClass("decimal") && !$.isNumeric($(this).val())) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please provide a decimal number");
                ret = false;
                return false;
            } else if ($(this).hasClass("positive") && $(this).val() < 0) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please provide a positive value");
                ret = false;
                return false;
            }
            /*else if($(this).hasClass("sufficient"))//validate_amount();
             {
             validate_amount();
             alert($("#amount_check_result").text()+" Text>>");
             if($("#amount_check_result").text()!=""){
             $(this).attr("value", "");
             $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
             $(this).attr("placeholder", "Please provide a positive value");
             ret = false;
             return false;
             } else {
             ret = true;
             return true;
             }
             }*/
            else if ($(this).hasClass("msisdn") && !($(this).val().match(/^(2547)/) && $(this).val().length == 12 && $.isNumeric($(this).val()))) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please enter phone number in the format 25472XXXXXXXX");
                ret = false;
                return false;
            } else if ($(this).hasClass("password") && !($(this).val().length >= 6 && $(this).val().length <= 32)) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Password must be at least 6 characters and no more than 32 characters long");
                ret = false;
                return false;
            } else if ($(this).hasClass("shortcode") && !($(this).val().length >= 5 && $(this).val().length <= 20)) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Shortcode must be at least 5 characters and no more than 20 characters long");
                ret = false;
                return false;
            } else if ($(this).hasClass("datefilterfuture") && (!/^\d{4}-\d{2}-\d{2}$/.test($(this).val()))) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Invalid date format. Correct format: YYYY-MM-DD");
                ret = false;
                return false;
            } else if ($(this).hasClass("id_number") && !($(this).val().length >= 6 && $(this).val().length <= 10)) {
                $(this).val("");
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please provide a decimal number");
                ret = false;
                return false;
            } else {
                $(this).attr("style", "border: 1px inset rgb(89, 189, 69);");
                $(this).attr("placeholder", "Please complete");
                ret = true;
            }
        }
    });


    if (formName == 'payment_request' && ret) {
        var ret = confirm("Are you sure you want to submit this request?");
    }

    if (ret == false) //Hault script execution if check above returns false
        return ret;


    if (ret == false) //Hault script execution if check above returns false
        return ret;

    var form = $(this).closest("form");
    var formname = form.attr("name");
    $.blockUI({
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });

    if (
        formName != 'donor_upload' &&
        formName != 'program_upload' &&
        formName != 'beneficiary_upload' &&
        formName != 'sp_upload' &&
        formName != 'business_upload' &&
        formName != 'business_upload1' &&
        formName != 'organisation_upload' &&
        formName != 'payment_request' &&
        formName != 'disbursement_upload' &&
        formName != 'beneficiaryallocation_upload' &&
        formName != 'user_upload' &&
        formName != 'datasource' &&
        formName != 'contractUpdate'
    ) {
        e.preventDefault();
        var page_id = $('#this_page_id').val();
        var cell = '';

        //  var link = 'Shared/php/process_form.php?f=' + formname +'&'+ $("[name='" + formname + "']").serialize() + "&permission=" + allVals;
        $.ajax({
            type: 'post',
            url: 'Shared/php/process_form.php?f=' + formname + '&',
            data: $("[name='" + formname + "']").serialize() + "&permission=" + allVals,
            success: function (result) {
                //   alert('Shared/php/process_form.php?f=' + formname +  $("[name='" + formname + "']").serialize() + "&permission=" + allVals);
                // console.log('Link: '+link);
                //console.log('Result: '+result);
                cell = result;
                console.log('cell: ' + cell);
            },
            complete: function () {
                $('.blockUI').hide();
                console.log("Reload this id: " + page_id);
                $('#reloadedContent').val('NO');
                if (formName != 'product')
                    loadData(page_id);
                else {
                    $("#formRecordId").val(cell);
                    console.log('EditVal: ' + $("#formRecordId").val());
                    $('#productStatus').modal('show');
                    $('.modal-backdrop').removeClass('modal-backdrop');

                    $.ajax({
                        type: 'GET',
                        url: '/church-ims-test/onboarding/form/productTabs/reviewProductConfig.php',
                        success: function (response) {
                            console.log("loading");

                            $('#productStatusModalBody').html(response);

                        },
                        complete: function () {
                            $('.blockUI').remove();
                        }
                    });

                    //   editEvent();

                    //    var activeTab = $("ul#prodtabs li.active").attr('id');
                    // $(".modal-body #currentOpenTab").val(activeTab);
                    // $(".modal-body #ajaxResults").val('Submitted Data: '+ result );

                }


            }
        });
        return false;
    } else {
        /*  $.blockUI({ css: {
         border: 'none',
         padding: '15px',
         backgroundColor: '#000',
         '-webkit-border-radius': '10px',
         '-moz-border-radius': '10px',
         opacity: .5,
         color: '#fff'
         } }); */
        //setTimeout($.unblockUI);
        return true;
    }


});


/* Formatting function for row details - modify as you need */


/*row.child( format(row.data()) ).show();
 tr.addClass('shown');

 $('div.slider', row.child()).slideDown(); */
