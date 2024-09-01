$(".header-notification-section").on("click", function () {
    fetch(baseUrl + '/notification/seen', {
        method: 'get'
    })
        .then(function (res) {
            $('.header-notification-section span.count').hide();
            return res.json();
        })
        .then(function (res) {
            console.log(res)
        })
        .catch(function (err) {
            console.log(err)
        });
});

function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function alertifyConfirm(event, message, redirectUrl) {
    event.preventDefault();
    alertify.confirm(message,
        function (evt, value) {
            window.location = redirectUrl;
        },
        function () {

        }
    );
}

function onlyNumberAndDecimal(event, element) {
    if ((event.which == 46 && $(element).val().indexOf('.') == -1)) {
        return true;
    } else if (event.which == 48) {
        return true;
    } else if (event.which == 49) {
        return true;
    } else if (event.which == 50) {
        return true;
    } else if (event.which == 51) {
        return true;
    } else if (event.which == 52) {
        return true;
    } else if (event.which == 53) {
        return true;
    } else if (event.which == 54) {
        return true;
    } else if (event.which == 55) {
        return true;
    } else if (event.which == 56) {
        return true;
    } else if (event.which == 57) {
        return true;
    } else if (event.which == 08) {
        return true;
    } else {
        return false;
    }
}

$('div.filter-form form').on('submit', function (e) {
    var submit = false;
    $('div.filter-form form input').each(function () {
        if ($(this).val() !== "") {
            submit = true;
        }
    });

    $('div.filter-form form select').each(function () {
        if ($(this).val() !== "") {
            submit = true;
        }
    });

    if (!submit)
        e.preventDefault();
});

function notificationRedirection(event, notificationId, redirectTo) {
    event.preventDefault();

    fetch(baseUrl + '/notification/' + notificationId + '/read', {
        method: 'get'
    })
        .then(function (res) {
            return res.json();
        })
        .then(function (res) {
            window.location = redirectTo;
            console.log(res)
        })
        .catch(function (err) {
            console.log(err)
        });
}

function sendWebPush(event) {
    event.preventDefault();
    fetch(baseUrl + '/web-push/push', {
        method: 'get'
    }).then(function (res) {
        return res.json();
    }).then(function (res) {
        console.log(res)
    }).catch(function (err) {
        console.log(err)
    });
}

function assignRider(event, orderId) {
    event.preventDefault();

    if (orderId) {
        $('div.assignRiderOrderDiv').html('<input type="hidden" class="assignRiderOrder" value="' + orderId + '">');
    }

    callAjaxForSearchingRider("");
}

function respondOrderAssignRequest(event, orderId) {
    event.preventDefault();

    if (orderId) {
        $('div.riderResponseOrderIdDiv').html('<input type="hidden" class="riderResponseOrderId" value="' + orderId + '">');
    }

    $('#rider-response-modal').modal('show');
}

function showRiderJobFinishModal(event, orderId) {
    event.preventDefault();

    if (orderId)
        $('div.riderResponseOrderIdDiv').html('<input type="hidden" class="riderResponseOrderId" value="' + orderId + '">');

    $('#rider-job-finish-modal').modal('show');
}

function callAjaxForSearchingRider(search) {
    $.ajax({
        url: baseUrl + '/riders/search-rider?search=' + search,
        method: 'get',
        success: function (data) {
            $('table tbody.searchRiderBody').html(data);
            $('#assign-rider-modal').modal('show');
        }, error: function (err) {
            console.log("This is error", err);
        }
    });
}


var awaitingSearch = null;
$('.sr-input').on('keyup', function (event) {
    if (awaitingSearch) {
        clearTimeout(awaitingSearch);
        awaitingSearch = null;
    }

    var value = $(this).val();

    awaitingSearch = setTimeout(function () {
        callAjaxForSearchingRider(value);
    }, 500);
});

$('#assign-rider-form').on('click', function (e) {
    var rider = $('tbody.searchRiderBody input[name=rider]:checked').val();
    if (rider) {
        var orderId = $('input.assignRiderOrder').val();
        var element = $(this);
        element.attr('disabled', true).css('cursor', 'not-allowed').children('i').show();

        var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
        fetch(baseUrl + '/orders/assign-rider', {
            method: 'POST',
            body: JSON.stringify({rider_id: rider, order_id: orderId}),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
            }
        }).then(function (res) {
            return res.json();
        }).then(function (res) {
            element.attr('disabled', false).css('cursor', 'pointer').children('i').hide();
            window.location.reload();
        }).catch(function (err) {
            console.log("Error response is ::", err);
            element.attr('disabled', false).css('cursor', 'pointer').children('i').hide();
            window.location.reload();
        });
    }
});

function riderResponse(event, element, status, orderId) {
    event.preventDefault();
    $(element).attr('disabled', true).css('cursor', 'not-allowed').children('i').show();

    if (!orderId)
        orderId = $('input.riderResponseOrderId').val();


    var postData = {};

    if (status === 'rejected') {
        $(element).next('button').attr('disabled', true).css('cursor', 'not-allowed');
        var reason = $('input#reject-reason').val();

        if (!reason) {
            $('small.rejection-reason-required').show();
            $(element).attr('disabled', false).css('cursor', 'pointer').children('i').hide();
            $(element).next('button').attr('disabled', false).css('cursor', 'pointer');
        } else {
            postData = {
                status: status,
                reason: reason,
                order_id: orderId
            };

            callAjaxForRiderResponse(postData);
        }
    } else if (status === 'accepted') {
        $(element).prev('button').attr('disabled', true).css('cursor', 'not-allowed');
        postData = {
            status: status,
            order_id: orderId
        };

        callAjaxForRiderResponse(postData);
    } else if (status === 'job started' || status === 'order picked' || status === 'delivered' || status === 'returned') {
        postData = {
            status: status,
            order_id: orderId
        };

        callAjaxForRiderResponse(postData);
    } else if(status === 'reschedule'){
        var rescheduleReason = $("input.reschedule-reason").val();
        if(!rescheduleReason || rescheduleReason === ''){
            $('small.reschedule-rejection-reason-required').show();
            $(element).attr('disabled', false).css('cursor', 'pointer').children('i').hide();
            $(element).next('button').attr('disabled', false).css('cursor', 'pointer');
        } else {
            postData = {
                status: status,
                reschedule_reason: rescheduleReason,
                order_id: orderId
            };
            console.log(postData);
            callAjaxForRiderResponse(postData);
        }
    }
}

function callAjaxForRiderResponse(postData) {
    var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    fetch(baseUrl + '/orders/rider-response', {
        method: 'POST',
        body: JSON.stringify(postData),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    }).then(function (res) {
        return res.json();
    }).then(function (res) {
        if (postData.status === 'accepted' || postData.status === 'job started' || postData.status === 'order picked' || postData.status === 'delivered' || postData.status === 'returned') {
            if (res.success && res.success === 'alertify') {
                $('#rider-job-finish-modal').modal('hide');
                alertify.alert()
                    .setting({
                        'label': 'Done',
                        'message': 'Please do not forget to collect payment from customer.',
                        'onok': function () {
                            window.location.reload();
                        }
                    }).show();
            } else {
                window.location.reload();
            }
        }
        else
            console.log("test");
            window.location = baseUrl + '/orders';
    }).catch(function (err) {
        console.log("Error response is ::", err);
        window.location.reload();
    });
}

function adminResponse(event, element, status, orderId) {
    event.preventDefault();

    $(element).attr('disabled', true).css('cursor', 'not-allowed').children('i').show();

    if (!orderId)
        orderId = $('input.riderResponseOrderId').val();

    var postData = {
        status: status,
        order_id: orderId
    };

    callAjaxForAdminResponse(postData);
}


function callAjaxForAdminResponse(postData) {
    var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    fetch(baseUrl + '/orders/admin-response', {
        method: 'POST',
        body: JSON.stringify(postData),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    }).then(function (res) {
        return res.json();
    }).then(function (res) {
        window.location.reload();
    }).catch(function (err) {
        console.log("Error response is ::", err);
        window.location.reload();
    });
}

$("#web-push-prompt-dismiss").on('click', function () {
    $(this).parent('div#web-push-prompt').hide();
    document.cookie = "allowNotification=not-allowed";
});

function showRescheduleForm(event, orderId) {
    event.preventDefault();
    $("input.orderRescheduleOrderId").val(orderId);
    $('#reschedule-form').modal('show');
    $("#reschedule-date-time-picker").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });
}

function rescheduleOrder(event, element) {
    $(element).attr('disabled', true).css('cursor', 'pointer').children('i').show();
    var rescheduleDateTime = $(".reschedule-date-time").val();
    if(!rescheduleDateTime || rescheduleDateTime === ''){
        $('small.reschedule-date-time-required').show();
        $(element).attr('disabled', false).css('cursor', 'pointer').children('i').hide();
        $(element).next('button').attr('disabled', false).css('cursor', 'pointer');
    } else {
        var orderId = $("input.orderRescheduleOrderId").val();
        var postData = {
            reschedule_date_time: rescheduleDateTime,
            order_id: orderId
        };
        callAjaxForOrderReschedule(postData);
    }
}

function callAjaxForOrderReschedule(postData) {
    var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    fetch(baseUrl + '/orders/reschedule-delivery', {
        method: 'POST',
        body: JSON.stringify(postData),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    }).then(function (res) {
        return res.json();
    }).then(function (res) {
        window.location = baseUrl + '/orders/'+postData.order_id+'/detail';
    }).catch(function (err) {
        console.log("Error response is ::", err);
        window.location.reload();
    });
}


