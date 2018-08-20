$(document).ready(function () {



    $("#dashboard.content-wrapper").css({
        marginLeft: "0px"
    });

    var selectedTab = localStorage.getItem('selectedTab');
    var selectedPage = localStorage.getItem('selectedPage');

    var selectedDivandPage = localStorage.getItem('selectedDivandPage');
    var divWrapper = selectedDivandPage.split("$$")[0];
    var loadPage = selectedDivandPage.split("$$")[1];
    // console.log("The Warapper "+divWrapper);
    // console.log("The Page "+loadPage);

    $('#dynamicWrapperIdentifier').val(localStorage.getItem('dynamicWrapperDiv'));

    // console.log("Div and Page: " + selectedDivandPage);

    // console.log("Stored Values: ");
    // console.log("tab: " + selectedTab);
    // console.log(selectedPage);
    if (selectedTab) {

        if (selectedTab == "#dashboard" || selectedTab == "dashboard") {

            $("section#dashboardContent.content").fadeOut('slow');

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
                type: 'GET',
                url: 'dashboard.php',
                success: function (msg) {
                    // console.log('dashbordContent');
                    $("div#dashboard.content-wrapper").append(msg);
                    $("section#dashboardContent.content").fadeIn('slow');
                    localStorage.setItem('selectedTab', 'dashboard');
                    // $("#dashboard.content-wrapper").css( { marginLeft : "0px" } );


                },

                complete: function () {

                    $('.blockUI').remove();
                }
            });



        } else {

            $('.nav-tabs a[href=' + selectedTab + ']').tab('show');

            if (selectedPage != "undefined" && selectedPage != "" && selectedPage != null) {

                $.ajax({
                    type: 'get',
                    url: 'Shared/php/resolve.php',
                    data: 'id=' + selectedPage,
                    success: function (result) {
                        // console.log("result: " + result);
                        getContents(result, selectedPage);

                    },
                    complete: function () {
                        // $('#loadingAdd').hide();


                    }
                });
            } else {
                var theUrl = selectedTab.substring(1);
                // console.log("removing content from: " + selectedTab);
                $(".content").remove();
                // $("div" + wrapperId + ".content-wrapper").remove($("section.content"));    



                // console.log('fetching: /church-ims-testtabs/' + theUrl + '.php');

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
                    url: '/church-ims-testtabs/' + theUrl + '.php',

                    success: function (result) {
                        // console.log("Appending: " + selectedTab);

                        $("div" + selectedTab + ".content-wrapper").append(result);
                        /* $(".content-wrapper").css({
                             marginLeft: "0px"
                         });*/
                        $("section#dynamicContent.content").fadeIn('slow');

                    },
                    complete: function () {
                        $('.blockUI').remove();
                    }
                });
                //$("div#dynamicWrapper.content-wrapper").show();
                //$(".content").fadeOut('slow');
                //$("div#dashboard.content-wrapper").show();


            }






        }

    } else {
        $("section#dashboardContent.content").fadeOut('slow');

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
            type: 'GET',
            url: 'dashboard.php',
            success: function (msg) {
                // console.log('dashbordContent');
                $("div#dashboard.content-wrapper").append(msg);
                $("section#dashboardContent.content").fadeIn('slow');
                localStorage.setItem('selectedTab', 'dashboard');
                // $("#dashboard.content-wrapper").css( { marginLeft : "0px" } );


            },
            complete: function () {
                $('.blockUI').remove();

            }
        });


    }




    $("div#dynamicWrapper.content-wrapper").hide();

    $(".dashboardtab").click(function () {

        //  $("section#dashboardContent.content").fadeOut();
        $("div#dynamicWrapper.content-wrapper").hide();

        $(".content").fadeOut('slow');
        // $("div#dashboard.content-wrapper").show();

        // console.log($("#main-sidebar.main-sidebar").width());
        /*if($("#main-sidebar.main-sidebar").width() != 50)
	{
	$("a.sidebar-toggle").click();
	}
*/




        // $("#dashboard.content-wrapper").css( { marginLeft : "0px" } );




        // alert("dash");


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
            type: 'GET',
            url: 'dashboard.php',
            success: function (msg) {
                // console.log('dashbordContent');

                //$("section#dashboardContent.content").html(msg).fadeIn('slow');  
                $("section#dashboardContent.content").remove();
                $("div#dashboard.content-wrapper").append(msg);
                $("section#dashboardContent.content").fadeIn('slow');
                localStorage.setItem('selectedTab', 'dashboard');

            },
            complete: function () {
                $('.blockUI').remove();

            }
        });


    });




    $(':checkbox[name="primarykey[]"],:checkbox[name="permission[]"]').change(function () {

        //alert('checked');


        if ($(this).attr("value") == "all") {

            var status = $(this).is(':checked');

            if (status) {
                $('#addElements').hide();
                $('#approval').fadeIn(500);

            } else {

                $('#approval').hide();
                $('#addElements').fadeIn(400);
            }
            $(':checkbox[name="primarykey[]"],:checkbox[name="permission[]"]').each(function () {
                if ($(this).attr('disabled') != "disabled") {

                    //$(this).attr('checked', status)
                    $(this).prop('checked', status);
                };
            });

        } else {
            /*var cb = $(':checkbox[name="primarykey[]"]');
            if(cb.attr("value")=="all" && cb.is(":checked")==true)
            {
            checked = ($(this).attr('checked') == 'checked') ? 'true' : false;
            if(!checked)							
            }
            checked = ($(this).attr('checked') == 'checked') ? 'true' : false;*/
            var checked = $('[name="primarykey[]"]:checked').length;
            if (checked > 0) {
                alert('checked');

                $('#addElements').hide();
                $('#approval').fadeIn(500);
            } else {
                alert('checked');
                $('#approval').hide();
                $('#addElements').fadeIn(400);
            }
            //$('[name="primarykey[]"]:checked').length;
        }
    });


    $(document).on('click', '.closeeditDetails', function () {

        $('#editDetails').css("display", "none");
        $('.recordUpdates').html('');
    });

    $(document).on('click', '.viewEditDetailsBtn', function () {

        $('#editDetails').css("display", "block");
        var recordId = $(this).closest('tr').attr("title");
        var table = $(this).attr("id");

        $.ajax({
            type: 'post',
            url: 'Shared/php/process_form.php?f=CHECK_RECORD_UPDATES',
            data: "record=" + recordId + "&table=" + table,
            success: function (result) {
                console.log("Updates: " + result);

                $('.recordUpdates').html(result);
                // $('#editDetails').css("display","block");


            },
            complete: function (result) {



            }
        });



    });


    $(document).on('click', '[name="approve"],[name="reject"]', function ()
        //$('[name="approve"],[name="reject"]').click(function ()


        {

            //Validate that required fields are nt left blank
            var ret = true;
            var Status = '';
            var form = $(this).closest("form");
            var formName = form.attr("name");
            //console.log("hereUntoCode"+ formName);
            $('[name="' + formName + '"] .required').each(function (i, obj) {
                if ($(this).val() == "") {
                    $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                    $(this).attr("placeholder", "Please enter comments here");
                    ret = false;
                    return ret;
                } else {
                    $(this).attr("style", "border: 1px inset rgb(89, 189, 69);");
                    $(this).attr("placeholder", "Please complete");
                    ret = true;
                    return ret;
                }
            });
            if (ret == false) {
                return false;
            }

            if ($(this).attr('name') == "approve") {
                Status = "APPROVED";
                var confirmItems = confirm("Are you sure you want to " + $(this).val() + "?");
                if (confirmItems) //Accept approval
                {
                    $('#action2').val('1');
                    ret = true;
                } else //Cancel Approval
                {
                    ret = false;
                }
            } else if ($(this).attr('name') == "reject") {
                Status = "REJECTED";
                var rejectItems = confirm("Are you sure you want to " + $(this).val() + "?");
                if (rejectItems) //Accept approval
                {
                    $('#action2').val('3');
                    ret = true;
                } else //Cancel Approval
                {
                    ret = false;
                }
            } else if ($(this).attr('name') == 'resubmit') {
                var confirmItems = confirm("Are you sure you want to resubmit the selected transactions?");
                if (confirmItems) //Accept approval
                {
                    ret = true;
                } else //Cancel Approval
                {
                    ret = false;
                }
            }
            if (ret == false) //Hault script execution if check above returns false
                return ret;


            var form = $(this).closest("form");
            var formname = form.attr("name");
            /* Get selected values for checkboxes */
            var allVals = [];
            $('[name="primarykey[]"]:checked').each(function () {
                allVals.push($(this).attr("value"));
            });
            $.ajax({
                type: 'get',
                url: 'Shared/php/resolve.php',
                data: 'id=' + $('#this_page_id').val(),
                success: function (result) {
                    // console.log("result: " + result);
                    getContents(result, $('#this_page_id').val());

                },
                complete: function () {
                    // $('#loadingAdd').hide();


                }
            });
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
                url: 'Shared/php/process_form.php?f=' + formname,
                data: "primarykey=" + allVals + "&action=confirm&status=" + Status + '&' + form.serialize(),
                success: function (result) {

                },
                complete: function (result) {

                    $('.blockUI').remove();
                    loadData($('#this_page_id').val());

                }
            });
            return false;
        });


    $(document).on('click', '[name="approveProduct"],[name="rejectProduct"]', function ()
        //$('[name="approve"],[name="reject"]').click(function ()


    {

        //Validate that required fields are nt left blank
        var ret = true;
        var Status = '';
        var form = $(this).closest("form");
        var formName = form.attr("name");
        var formId = form.attr("id");
        //console.log("hereUntoCode"+ formName);
        $('[id="' + formId + '"] .required').each(function (i, obj) {
            if ($(this).val() == "") {
                $(this).attr("style", "border: 1px inset rgb(251, 58, 58);");
                $(this).attr("placeholder", "Please enter comments here");
                ret = false;
                return ret;
            } else {
                $(this).attr("style", "border: 1px inset rgb(89, 189, 69);");
                $(this).attr("placeholder", "Please complete");
                ret = true;
                return ret;
            }
        });
        if (ret == false) {
            return false;
        }

        if ($(this).attr('name') == "approveProduct") {
            Status = "APPROVED";
            var confirmItems = confirm("Are you sure you want to " + $(this).val() + "?");
            if (confirmItems) //Accept approval
            {
                $('#action2').val('1');
                $('[name="action2"]').val('1');
                ret = true;
            } else //Cancel Approval
            {
                ret = false;
            }
        } else if ($(this).attr('name') == "rejectProduct") {
            Status = "REJECTED";
            var rejectItems = confirm("Are you sure you want to " + $(this).val() + "?");
            if (rejectItems) //Accept approval
            {
                $('#action2').val('3');
                $('[name="action2"]').val('3');
                ret = true;
            } else //Cancel Approval
            {
                ret = false;
            }
        }
        if (ret == false) //Hault script execution if check above returns false
            return ret;


        var form = $(this).closest("form");
        var formname = form.attr("name");
        /* Get selected values for checkboxes */
        var allVals = [];
        $('[name="primarykey[]"]:checked').each(function () {
            allVals.push($(this).attr("value"));
        });
        $.ajax({
            type: 'get',
            url: 'Shared/php/resolve.php',
            data: 'id=' + $('#this_page_id').val(),
            success: function (result) {
                // console.log("result: " + result);
                getContents(result, $('#this_page_id').val());

            },
            complete: function () {
                // $('#loadingAdd').hide();


            }
        });
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
            url: 'Shared/php/process_form.php?f=' + formname,
            data: "primarykey=" + allVals + "&action=confirm&status=" + Status + '&' + form.serialize(),
            success: function (result) {

            },
            complete: function (result) {

                $('.blockUI').remove();
                loadData($('#this_page_id').val());

            }
        });
        return false;
    });
});








function loadtabDefault(wrapperId) {

    var theUrl = wrapperId.substring(1);
    // console.log("removing content from: " + wrapperId);
    $("#dynamicContent").remove();

    // console.log('fetching: /church-ims-testtabs/' + theUrl + '.php');

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
        url: '/church-ims-testtabs/' + theUrl + '.php',

        success: function (result) {
            // console.log("Appending: " + wrapperId);

            $("div" + wrapperId + ".content-wrapper").append(result);
            $("section#dynamicContent.content").fadeIn('slow');

        },
        complete: function () {
            $('.blockUI').remove();
        }
    });



}



$(document).on("click", ".loadDashboardLink", function (e) {

    //$(this).preventDefault();
    e.preventDefault();
    var url = $(this).attr('href');
    console.log("Loading Dashboard Report Page: " + url);
    localStorage.setItem('selectedTab', '#reports');
    localStorage.setItem('selectedPage', url);
    $('#this_page_id').val(url);
    $('#dynamicWrapperIdentifier').val('#reports');
    localStorage.setItem('selectedDivandPage', $('#dynamicWrapperIdentifier').val() + '$$' + $('#this_page_id').val());


    var selectedTab = localStorage.getItem('selectedTab');
    var selectedPage = localStorage.getItem('selectedPage');

    var selectedDivandPage = localStorage.getItem('selectedDivandPage');
    var divWrapper = selectedDivandPage.split("$$")[0];
    var loadPage = selectedDivandPage.split("$$")[1];
    var loadPage = selectedDivandPage.split("$$")[1];
    console.log("The Warapper " + divWrapper);
    // console.log("The Page "+loadPage);

    $('#dynamicWrapperIdentifier').val(localStorage.getItem('dynamicWrapperDiv'));

    $('.nav-tabs a[href=' + selectedTab + ']').tab('show');

    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'id=' + url,
        success: function (result) {
            console.log("result: " + result);
            // getContents(result, linkref);
            getReportContents(result, url);

        },
        complete: function () {
            // $('#loadingAdd').hide();


        }
    });



    // var link = getLink(url);





    return false;
});

function getReportContents(resul, linkref) {

    $(".content-wrapper#reports section#dynamicContent.content").remove();

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


    // $(".content-wrapper#reports section#dynamicContent.content").fadeIn('slow');


    // // console.log("I need this url: "+theUrl+" linkef: "+linkref);
    $.ajax({
        type: 'get',
        url: resul,
        data: 'id=' + linkref,
        success: function (result) {

            //console.log("fetching: " + wrapperId);

            $("div#reports.content-wrapper").append(result);
            $(".content-wrapper#reports section#dynamicContent.content").fadeIn('slow');

        },
        complete: function () {
            $('a.buttons-excel').html('<span class="btn btn-info btn-sm"><i class="fa fa-file-excel-o"></i> Excel</span>');
            $('a.buttons-pdf').html('<span class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Pdf</span>');
            $('a.buttons-print').html('<span class="btn btn-info btn-sm"><span class="glyphicon glyphicon-print"></span> Print</span>');


            //   var count = $("div" + wrapperId + ".content-wrapper").length;


            var count2 = $("div#reports.content-wrapper").children().length;
            // console.log("dynamic wrapper: " + $('#dynamicWrapperIdentifier').val()); 
            // console.log("wrapper: " + wrapperId); 
            // console.log("lCount: "+count2);     

            if (count2 == 1) {
                // console.log("loading tab default");        
                loadtabDefault('#reports');
            }



            $('.blockUI').remove();
            localStorage.setItem('selectedPage', $('#this_page_id').val());
            localStorage.setItem('dynamicWrapperDiv', $('#dynamicWrapperIdentifier').val());
            localStorage.setItem('selectedDivandPage', $('#dynamicWrapperIdentifier').val() + '$$' + $('#this_page_id').val());
            // console.log("dynamic wrapper: " + $('#dynamicWrapperIdentifier').val());
            // console.log("Stored Page: " + $('#this_page_id').val());

            var notes = $('#thisnote').val();
            var reload = $('#reloadedContent').val();
            // console.log("Notes: " + notes);
            // console.log("RR: " + reload);

            // console.log("Notes11: " + notes + " Length: " + notes.length);
            if (notes != '' && reload != 'YES') {
                $.growlUI('NIC-SASA Notification', '' + notes);
                $('#thisnote').val('');
                $('#reloadedContent').val('NO');


            }



        }

    });


}
//   $(".mymenutabs").click(function () {

$(document).on('click', '.mymenutabs', function (e) {


    console.log("You clicked a tab1 ");

    // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

    var wrapperId = ($(e.target).attr('href'));
    var previousTab = (localStorage.getItem('selectedDivandPage')).split("$$")[0];
    if (wrapperId != previousTab) {


        localStorage.setItem('selectedPage', '');
    }


    localStorage.setItem('selectedTab', $(e.target).attr('href'));

    $('#dynamicWrapperIdentifier').val(wrapperId);

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

    if (wrapperId == '#dashboard') {

        $.ajax({
            type: 'GET',
            url: 'dashboard.php',
            success: function (msg) {
                // console.log('dashbordContent');
                //$("div#dashboardContent.content").remove($("section#dashboardContent.content"));
                $("div#dashboard.content-wrapper").remove($("section#dashboardContent.content"));
                //$("div#dashboard.content-wrapper").remove($("section#dashboardContent.content"));


                //$("section#dashboardContent.content").html(msg).fadeIn('slow');
                //content-wrapper


            },
            complete: function () {

                $('.blockUI').remove();
            }
        });

        //console.log("Loading tab2 ");
    } else {
        var theUrl = wrapperId.substring(1);


        //  $(".content").remove();
        /* $.blockUI({
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
         */
        console.log("Loading tab ");
        $("#dynamicContent").remove();
        loadtabDefault(wrapperId);
        /*   $.ajax({
               type: 'get',
               url: '/church-ims-testtabs/' + theUrl + '.php',

               success: function (result) {
                   $("div" + wrapperId + ".content-wrapper").append(result);
                   $("section#dynamicContent.content").fadeIn('slow');

               },
               complete: function () {
                   console.log("Loaded tab ");
                   $('.blockUI').remove();
               }
           });*/

    }


    //});

});

function loadData(linkref) {

    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'id=' + linkref,
        success: function (result) {
            //console.log("result: " + result);
            getContents(result, linkref);

        },
        complete: function () {
            // $('#loadingAdd').hide();


        }
    });
    return false;
}
$(document).on('click', '#dateFiltersBtn', function (e) {
    var endDate = $("#daterange-btn").data('daterangepicker').endDate.format('YYYY-MM-DD');
    var startDate = $("#daterange-btn").data('daterangepicker').startDate.format('YYYY-MM-DD');
    //var keywords = $('#keywords').val();
    //var page_size = $('#page_size').val();


    //   // console.log("fetching: " + theUrl);
    $(".content-header").remove();
    $(".content").fadeOut('slow');
    $(".content").remove();
    wrapperId = $('#dynamicWrapperIdentifier').val();
    // console.log("endDate: " + endDate + "startDate: " + startDate);

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
    //// console.log('url: reports/list/loanStats.php Data: id=74&datefrom=' + startDate + '&dateto=' + endDate );
    $.ajax({
        type: 'get',
        url: 'reports/list/loanStats.php',
        data: 'id=74&datefrom=' + startDate + '&dateto=' + endDate,
        success: function (result) {
            // console.log('finished');
            $("div" + wrapperId + ".content-wrapper").append(result);
            $("section#dynamicContent.content").fadeIn('slow');


        },
        complete: function () {
            // console.log('finished');
            $('.blockUI').remove();
        }
    });



    return false;

});


$(document).on('click', '#reloadData', function (e) {


    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'id=' + $('#this_page_id').val(),
        success: function (result) {
            // console.log("result: " + result);
            getContents(result, $('#this_page_id').val());

        },
        complete: function () {
            // $('#loadingAdd').hide();


        }
    });

    return false;
});




$(document).on('click', '#dataFiltersBtn', function (e) {
    var endDate = $("#daterange-btn").data('daterangepicker').endDate.format('YYYY-MM-DD');
    var startDate = $("#daterange-btn").data('daterangepicker').startDate.format('YYYY-MM-DD');
    var keywords = $('#keywords').val();
    var page_size = $('#page_size').val();
    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'id=' + $('#this_page_id').val(),
        success: function (result) {
            // console.log("result: " + result);
            reloadContents(result, $('#this_page_id').val(), startDate, endDate, keywords, page_size);

        },
        complete: function () {
            // $('#loadingAdd').hide();


        }
    });
    return false;
});

function reloadContents(theUrl, linkref, startDate, endDate, keywords, page_size) {
    // console.log("fetching: " + theUrl);
    $(".content-header").remove();
    $(".content").fadeOut('slow');
    $(".content").remove();
    wrapperId = $('#dynamicWrapperIdentifier').val();
    // console.log("endDate: " + endDate + "startDate: " + startDate + "keywords: " + keywords + "page_size: " + page_size);



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
        url: theUrl,
        data: 'id=' + linkref + '&datefrom=' + startDate + '&dateto=' + endDate + '&keywords=' + keywords + '&page_size=' + page_size,
        success: function (result) {

            $("div" + wrapperId + ".content-wrapper").append(result);
            $("section#dynamicContent.content").fadeIn('slow');

            var notes = $('#thisnote').val();
            // console.log("Notes: " + notes + " Length: " + notes.length);
            if (notes != '') {
                $.growlUI('NIC-SASA Notification', '' + notes);

            }


        },
        complete: function () {
            $('.blockUI').remove();
            $('#thisnote').val('');
            // console.log("Notes1: " + $('#thisnote').val());

        }
    });
    // $('#thisnote').val('');
    return false;
}

function getContents(theUrl, linkref) {
    console.log("fetching: " + theUrl);

    $(".content-header").remove();
    $(".content").fadeOut('slow');
    $(".content").remove();
    var wrapperId = $('#dynamicWrapperIdentifier').val();
    // console.log("Wrapper: "+wrapperId);
    $('#dynamicWrapperIdentifier').not(':first').remove();
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
    // // console.log("I need this url: "+theUrl+" linkef: "+linkref);
    $.ajax({
        type: 'get',
        url: theUrl,
        data: 'id=' + linkref,
        success: function (result) {

            // console.log("fetched: " + result);

            $("div" + wrapperId + ".content-wrapper").append(result);
            $(wrapperId + " section#dynamicContent.content").fadeIn('slow');
        },
        complete: function () {
            $('a.buttons-excel').html('<span class="btn btn-info btn-sm"><i class="fa fa-file-excel-o"></i> Excel</span>');
            $('a.buttons-pdf').html('<span class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Pdf</span>');
            $('a.buttons-print').html('<span class="btn btn-info btn-sm"><span class="glyphicon glyphicon-print"></span> Print</span>');


            //   var count = $("div" + wrapperId + ".content-wrapper").length;


            var count2 = $("div" + wrapperId + ".content-wrapper").children().length;
            // console.log("dynamic wrapper: " + $('#dynamicWrapperIdentifier').val()); 
            // console.log("wrapper: " + wrapperId); 
            // console.log("lCount: "+count2);     

            if (count2 == 1) {
                // console.log("loading tab default");        
                loadtabDefault(wrapperId);
            }



            $('.blockUI').remove();
            localStorage.setItem('selectedPage', $('#this_page_id').val());
            localStorage.setItem('dynamicWrapperDiv', $('#dynamicWrapperIdentifier').val());
            localStorage.setItem('selectedDivandPage', $('#dynamicWrapperIdentifier').val() + '$$' + $('#this_page_id').val());
            // console.log("dynamic wrapper: " + $('#dynamicWrapperIdentifier').val());
            // console.log("Stored Page: " + $('#this_page_id').val());

            var notes = $('#thisnote').val();
            var reload = $('#reloadedContent').val();
            // console.log("Notes: " + notes);
            // console.log("RR: " + reload);

            // console.log("Notes11: " + notes + " Length: " + notes.length);
            if (notes != '' && reload != 'YES') {
                $.growlUI('NIC-SASA Notification', '' + notes);
                $('#thisnote').val('');
                $('#reloadedContent').val('NO');


            }



        }
    });
    return false;
}


function addEvent(mode, modeType) {

    $('#example1_wrapper').fadeOut();
    // $('#loadingAdd').show();
    $('.addButton').fadeOut();
    $('#addElements').fadeOut();
    $('.btn-group').fadeOut();
    $('#listHeading').fadeOut();
    $('.box').fadeOut();
    //data: 'sid=' + $('#sub_page').val() + '&id=' + $('#page_id').val() + '&mode=' + mode,
    // data: 'sid=1&id=' + $('#page_id').val() + '&mode=' + mode,
    var page_id = $('#this_page_id').val();

    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'sid=1&id=' + page_id + '&mode=' + mode + '&modeType=' + modeType,
        success: function (result) {

            $('.gridContent').show();
            $('.gridContent').html(result);
        },
        complete: function () {
            $('#loadingAdd').hide();
        }
    });
}


function editEvent2(cell) {
    $('#dataTable_wrapper').fadeOut();
    // $('#loadingAdd').show();
    $('.addButton').fadeOut();
    $('#addElements').fadeOut();
    $('.btn-group').fadeOut();

    $('#listHeading').fadeOut();
    //$('#filterGrid').fadeOut();

    $.ajax({
        type: 'get',
        url: 'Shared/php/resolve.php',
        data: 'sid=' + $('#sub_page').val() + '&id=' + $('#page_id').val() + '&cell=' + cell,
        success: function (result) {
            $('#gridform').show();
            $('#gridform').html(result);
        },
        complete: function () {
            $('#loadingAdd').hide();
        }
    });

    return false;
}

function displayRowDetails(result, tr, row) {
    var returnVal = '<div id = "slider" class="slider">' + result + '</div>';
    //// console.log("returnval: "+returnVal);
    // alert(row.child().val());
    row.child(returnVal).show();
    //  // console.log('here');
    tr.addClass('shown');
    //// console.log('here2'); 

    $('div.slider', row.child()).slideDown();
    // // console.log('here3'); 


}




function exportXls(dtype) {
    window.open('Shared/php/excel_export.php?id=' + dtype + "&program_id=" + $("[name='program_id']").val(), 'Export');
}


$(document).on('click', '.addButton', function () {



    var btnValue = $(this).attr("value"),
        buttonMode = $(this).attr("mode");
    // alert(btnValue);
    var table = $('#example1').DataTable();
    var tr = $(this).closest('tr').prev();
    var row = table.row(tr);


    if (row.child.isShown()) {


        $('div.slider', row.child()).slideUp(function () {

            row.child.hide();
            tr.removeClass('shown');
        });
    }


    if (btnValue == 'Add New MSISDN' || btnValue == 'Add B2C Setting' || btnValue == 'Allocate Funds') {
        addEvent('1'); //Single payment upload
    } else if (
        btnValue == 'User Upload' || btnValue == 'Program Upload' || btnValue == 'Organisation Upload' || btnValue == 'Add Business Customer' || btnValue == 'Add Business Customer'

    ) {
        addEvent('2');
    } else if (btnValue == 'Upload Businesses') {
        addEvent('2', '2');
    } else {

        addEvent(0);

    }


});


$(document).on('click', '.loaddata', function (e) {

    e.preventDefault();

    var link = $(this).closest("a");
    var linkref = link.attr("href").substring(4);
    // console.log("ajax link: " + linkref);
    $('#reloadedContent').val('YES');
    loadData(linkref);
});





$(document).on('change', ':checkbox[name="primarykey[]"],:checkbox[name="permission[]"]', function () {


    // $(':checkbox[name="primarykey[]"],:checkbox[name="permission[]"]').change(function ()    {

    // alert('checked');


    if ($(this).attr("value") == "all") {

        var status = $(this).is(':checked');

        if (status) {
            $('#addElements').hide();
            $('#approval').fadeIn(500);

        } else {

            $('#approval').hide();
            $('#addElements').fadeIn(400);
        }
        $(':checkbox[name="primarykey[]"],:checkbox[name="permission[]"]').each(function () {
            if ($(this).attr('disabled') != "disabled") {

                //$(this).attr('checked', status)
                $(this).prop('checked', status);
            };
        });

    } else {
        /*var cb = $(':checkbox[name="primarykey[]"]');
        if(cb.attr("value")=="all" && cb.is(":checked")==true)
        {
        checked = ($(this).attr('checked') == 'checked') ? 'true' : false;
        if(!checked)							
        }
        checked = ($(this).attr('checked') == 'checked') ? 'true' : false;*/
        var checked = $('[name="primarykey[]"]:checked').length;
        if (checked > 0) {
            //alert('checked');

            $('#addElements').hide();
            $('#approval').fadeIn(500);
        } else {
            //alert('checked');
            $('#approval').hide();
            $('#addElements').fadeIn(400);
        }
        //$('[name="primarykey[]"]:checked').length;
    }
});

$(document).on('click', 'td.acct-details-control', function () {

    //var table = $('#example1').DataTable();
    var table = $(this).closest('table').DataTable();
    
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var d = tr.attr("title");
    var subid = "view";
    if (row.child.isShown()) {

        $('div.slider', row.child()).slideUp(function () {
            row.child.hide();
            tr.removeClass('shown');
        });
    } else {
        var page_id = $('#this_page_id').val();
         


        $.ajax({
            type: 'get',
            url: '../../church-ims-testShared/php/resolve.php',
            data: 'key=' + d + '&sid=' + subid + '&id=' + page_id,
            success: function (result) {
                console.log('key=' + d + '&sid=' + subid + '&id=' + page_id);

                displayRowDetails(result, tr, row);
            },
            complete: function () {

            }
        });
    }

});

$(document).on('click', 'td.details-control', function () {

    var table = $('#example1').DataTable();
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var d = tr.attr("title");
    var subid = "view";

    if (row.child.isShown()) {


        $('div.slider', row.child()).slideUp(function () {

            row.child.hide();
            tr.removeClass('shown');
        });
    } else {

        // data: 'key=' + d + '&sid=' + subid + '&id=' + $('#page_id').val(),

        var page_id = $('#this_page_id').val();

        $.ajax({
            type: 'get',
            url: '../../church-ims-testShared/php/resolve.php',
            data: 'key=' + d + '&sid=' + subid + '&id=' + page_id,
            success: function (result) {
                console.log('key=' + d + '&sid=' + subid + '&id=' + $('#page_id').val());

                displayRowDetails(result, tr, row);
            },
            complete: function () {

            }
        });
    }

});


$(document).on('click', 'button.details-control', function () {


    //var table = $('example1').DataTable();
    var table = $('#example1').DataTable();
    var tr = $(this).closest('tr');
    var checkbox = tr.find(':checkbox[name="primarykey[]"]');
    checkbox.prop('checked', true);
    var row = table.row(tr);
    var d = tr.attr("title");
    var subid = "view";
    // console.log('key=' + d + '&sid=' + subid + '&id=3');
    if (row.child.isShown()) {


        $('div.slider', row.child()).slideUp(function () {

            row.child.hide();
            tr.removeClass('shown');
        });
    } else {

        // data: 'key=' + d + '&sid=' + subid + '&id=' + $('#page_id').val(),

        var page_id = $('#this_page_id').val();

        $.ajax({
            type: 'get',
            url: '../../church-ims-testShared/php/resolve.php',
            data: 'key=' + d + '&sid=' + subid + '&id=' + page_id,
            success: function (result) {
                // console.log(result);

                displayRowDetails(result, tr, row);
            },
            complete: function () {

            }
        });
    }

});






/* $.fn.dataTableExt.afnFiltering.push(
function( oSettings, aData, iDataIndex ) {

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1;
var yyyy = today.getFullYear();

if (dd<10)
dd = '0'+dd;

if (mm<10)
mm = '0'+mm;

//  today = mm+'/'+dd+'/'+yyyy;
today = dd+'-'+mm+'-'+yyyy;

if ($('#min').val() != '' || $('#max').val() != '') {
var iMin_temp = $('#min').val();
if (iMin_temp == '') {
iMin_temp = '01-01-1980';
}

var iMax_temp = $('#max').val();
if (iMax_temp == '') {
iMax_temp = today;
}

var arr_min = iMin_temp.split("-");
var arr_max = iMax_temp.split("-");
var arr_date = aData[2].split("-");

var iMin = new Date(arr_min[2], arr_min[0], arr_min[1], 0, 0, 0, 0)
var iMax = new Date(arr_max[2], arr_max[0], arr_max[1], 0, 0, 0, 0)
var iDate = new Date(arr_date[2], arr_date[0], arr_date[1], 0, 0, 0, 0)

if ( iMin == "" && iMax == "" )
{
return true;
}
else if ( iMin == "" && iDate < iMax )
{
return true;
}
else if ( iMin <= iDate && "" == iMax )
{
return true;
}
else if ( iMin <= iDate && iDate <= iMax )
{
return true;
}
return false;
}
}
);
*/

function deleteRecord(t) {
    var row = t.parentNode.parentNode;
    document.getElementById("report").deleteRow(row.rowIndex);
    // console.log(row);
}
