$("#btn_delete_entire_order").on('click', function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Delete order",
        text: "Are you sure you want to delete this order ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        }
    );
});

$("#btn_delete_dedupe_list").on('click', function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Delete dedupe list",
        text: "Are you sure you want to delete the dedupe list?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        }
    );
});

$("#btn_save_dedupe_list").on('click', function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Save dedupe list",
        text: "Are you sure you want to save the dedupe list?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "Yes, save it!",
        closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        }
    );
});

$("#btn_submit_cart").on('click', function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Submit orders",
        text: "Are you sure you want to submit your orders for processing?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "Yes, submit it!",
        closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        }
    );
});

$(".btn_delete_order").on('click', function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Delete order",
        text: "Are you sure you want to delete this order ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        }
    );
});
