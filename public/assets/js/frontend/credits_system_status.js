function showPricing(payment_type) {
    $('#creditsModal').modal('show');
}

function system_status(){
    $.ajax({
        type: "POST",
        url: "/users/systemStatus",
        data: {
            _token : $('meta[name="_token"]').attr('content')
        },
        success: function(response) {
            toastr.info(response + " - orders procesing at the moment!", {timeOut: 1000}, {positionClass: "toast-top-right"});
        }
    });
}
