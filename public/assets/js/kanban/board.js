$(document).ready(function() {

    // CSRF TOKEN
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        error: function(x, status, error) {
            if (x.status == 401) {
                swal({
                    title: "Session expired",
                    text: "Your session has expired. You need to login again.",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Okay",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    window.location.href = "/login";
                });
            } else {
                //alert("An error occurred: " + status + "nError: " + error);
                swal("Error!", "An error occured: " + status + "\n" + error, "warning")
            }
        }
    });

    var Board = {
        init: function(params) {
            this.params = params;
            this.bindUI();
            this.initCradDrag();
            //this.initEditableListName();
        },
        initCradDrag: function() {
            $(".card-con").each(function(index, el) {
                $(el).sortable({
                    scroll: true,
                    connectWith: ".card-con",
                    placeholder: "dashed-placeholder",
                    revert: 200,
                    receive: function(event, ui) {
                        var targetList = event.target;
                        var targetCard = ui.item[0];
                        var listId = $(targetList).data('listid');
                        var cardId = $(targetCard).data('cardid');

                        $.ajax({
                            url: 'changeCardList',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                listId: listId,
                                cardId: cardId
                            },
                            success: function(data) {
                                //console.log(data);
                            }
                        });

                    },
                }).disableSelection();
            });
        },
        //initEditableListName: function() {
        //   var that = this;
        //    $(".board-panel-title").each(function(index, el) {
        //        $.fn.editable.defaults.mode = 'popup';
        //        $(el).editable({
        //            validate: function(value) {
        //                if ($.trim(value) == '')
        //                    return 'Value is required.';
        //            },
        //            type: 'text',
        //            url: 'update-list-name',
        //            title: 'Edit List Name',
        //            placement: 'right',
        //            send: 'always',
        //            ajaxOptions: {
        //                dataType: 'json',
        //                success: function() {
        //                    var listId = $(el).attr("data-pk");
        //                    that.createActivity(listId, 'board_list', 'edit list name');
        //                }
        //            }
        //        });
        //    });
        //},

        bindUI: function() {
            var that = this;

            $(".create-board-form").on("submit", function(e) {
                e.preventDefault();
                that.saveBoard();
            });

            $(document).on('click', '#btn_assign_dp', function() {
                //var cardId = $(this).data('cardid');
                //that.putMainKanbanCardDetailInModal(cardId);
                $(".modal").event.stopPropagation();
            })


            this.params['saveBoardBtn'].on('click', function(event) {
                event.preventDefault();
                that.saveBoard();
            });

            $('#saveListName').on('click', function(event) {
                event.preventDefault();
                that.saveList($(this).closest('.panel-body').find('form').serialize(), this);
            });

            $('#savePublicListName').on('click', function(event) {
                event.preventDefault();
                that.savePublicList($(this).closest('.panel-body').find('form').serialize(), this);
            });

            $(document).on('click', '.show-input-field', function() {
                var currentList = $(this).hide();
                that.targetList = $(currentList).parent();
                $(this).closest('.panel-body').find('form').show();
            });

            $(document).on('click', '.close-input-field', function() {
                $(this).closest('.panel-body').find('.show-input-field').show();
                $(this).closest('.panel-body').find('form').hide();
            });

            $(document).on('click', '#saveCard', function(event) {
                event.preventDefault();
                that.saveCard($(this).closest('.panel-body').find('form').serialize(), this);
            });

            // MAIN KANBAN TASK DETAILS
            $(document).on('click', "#mainkanban-btn-details", function() {
                var potential_id = $(this).data('potentialid');
                window.location.href = "/admin/qc/qc_details/" + potential_id;
            });

            $(document).on('click', '.main-kanban-list-items', function() {
                var cardId = $(this).data('cardid');
                that.putMainKanbanCardDetailInModal(cardId);
            });

            $(document).on('click', '.board-list-items', function() {
                var cardId = $(this).data('cardid');
                $('.modal#card-detail').find('button#delete-card').data('cardid', cardId);
                that.putCardDetailInModal(cardId);
            });

            $(document).on('click', 'button#delete-card', function() {
                var cardId = $(this).data('cardid');
                var cardIdCon = $(".list-group-item").filter("[data-cardid=" + cardId + "]");
                that.deleteCard(cardId, cardIdCon);
            });

            $(document).on('click', 'a.delete-task', function(event) {
                event.preventDefault();
                var taskId = $(this).attr("data-taskId");
                that.deleteTask(taskId, this);
            });

            $(document).on('click', '#save-change', function(event) {
                event.preventDefault();
                var cardId = $(document).find('#card-detail').attr("data-cardid");
                that.saveChanges(cardId);
            });

            // Main kanban save task modal button
            $(document).on('click', '#mainkanban-save-change', function(event) {
                event.preventDefault();
                var cardId = $(document).find('#card-detail-main-kanban').attr("data-cardid");
                that.saveMainKanbanTaskChanges(cardId);
            });

            $(document).on('click', '#submit-comment', function() {
                var comment = $('#card-detail').find("#comment-input").val();
                var cardId = $(document).find('#card-detail').attr("data-cardid");
                if (comment.length > 0) {
                    event.preventDefault();
                    that.postComment(comment, cardId);
                };
            });

            $(document).on('click', '#submit-comment-main-kanban', function() {
                var comment = $('#card-detail-main-kanban').find("#comment-input").val();
                var cardId = $(document).find('#card-detail-main-kanban').attr("data-cardid");
                if (comment.length > 0) {
                    event.preventDefault();
                    that.postComment(comment, cardId);
                };
            });

            $(document).on('click', '#submit-task', function() {
                var taskTitle = $('#card-detail').find("#task-description-input").val();
                var cardId = $(document).find('#card-detail').attr("data-cardid");
                if (taskTitle.length > 0) {
                    event.preventDefault();
                    that.saveTask(taskTitle, cardId);
                };
            });

            $(document).on("click", ".sub-task-title-input", function() {
                var isCompleted;
                var isChecked = $(this).attr("data-checked"); //$(this).closest("div").find('input.sub-task-title-input').attr("data-checked");
                var taskId = $(this).attr("id"); //attr("data-taskid");

                if (isChecked == 0) {
                    isCompleted = 1;
                    //$(this).closest("div").find('input.sub-task-title-input').attr("data-checked", 1);
                    $(this).attr("data-checked", 1);
                    that.updateTaskCompleted(taskId, isCompleted);
                } else {
                    isCompleted = 0;
                    //$(this).closest("div").find('input.sub-task-title-input').attr('data-checked', 0);
                    $(this).attr("data-checked", 0);
                    that.updateTaskCompleted(taskId, isCompleted);
                }
            });

            //that.makeEditable('#select-board');

            $(document).on('click', '#make-fv-board', function(event) {
                event.preventDefault();
                event.stopPropagation();

                var starColor = $(this).css('color');
                var boardId = $(this).closest('.board-link').attr("data-boardid");
                var isFavourite;
                if (starColor == "rgb(255, 255, 255)") {
                    isFavourite = 1;

                    $(this).css('color', "#FFEB3B");
                    var boardCon = $(this).closest('.col-lg-3').clone();
                    var boardTitle = $(boardCon).find("h2").text().trim();
                    if ($(".my-fv-board").find('h1.board-starred-heading').length == 0) {
                        $(".my-fv-board").prepend('<h1 class="board-starred-heading" style="margin-top: 10px;margin-left: 15px;font-weight: 500;font-size: 25px;"><span class="glyphicon glyphicon-star-empty starred-boards" aria-hidden="true"></span> Starred Boards</h1>');
                    };

                    if ($(".my-fv-board").find(".boards-col .col-lg-3").length == 0) {
                        $(".my-fv-board").css('display', 'block');
                    }
                    $(boardCon).find(".col-lg-2").remove();
                    $(".my-fv-board").find(".boards-col").prepend(boardCon);
                    $("ul.stared-board-list-con").prepend(
                        '<li style="margin-bottom: 5px;" data-boardid="' + boardId + '">' +
                        '<a href="http://localhost:8000/board/' + boardId + '" style="color: #393333; padding-left: 0px; line-height: 20px; height: 20px; mar">' + boardTitle + '</a>' +
                        '</li>'
                    );
                    that.createActivity(boardId, 'board', 'fav a board');
                } else {
                    $(this).css('color', "#FFF");
                    isFavourite = 0;
                    $(".my-fv-board").find(".boards-col .col-lg-3").filter("[data-boardid=" + boardId + "]").remove();
                    if ($(".my-fv-board").find(".boards-col .col-lg-3").length == 0) {
                        $(".my-fv-board").css('display', 'none');
                    };
                    $("ul.stared-board-list-con").find("li").filter("[data-boardid=" + boardId + "]").remove();
                    that.createActivity(boardId, 'board', 'un-fav a board');
                }
                that.updateBoardFavourite(boardId, isFavourite);
            });

            $(".board-link").hover(function() {
                $(this).find("#make-fv-board").slideDown("fast");
            }, function() {
                $(this).find("#make-fv-board").slideUp("fast");
            });

            $(document).on('click', '.board-link', function() {
                var boardId = $(this).attr("data-boardid");
                window.location.replace("board/" + boardId);
            });

            $(document).on('submit', '#selet-board-form', function(event) {
                event.preventDefault();
                var boardId = $("#select-board").val();
                var location = window.location;

                if (location.pathname.substr(1, 5) === "board") {
                    location.replace(boardId);
                } else {
                    location.replace("board/" + boardId);
                }
            });

            $(document).on('click', '.delete-list', function() {
                var listId = $(this).data("listid");
                that.deleteList(listId, this);
            });

            $(document).on('click', '.timesheet_submit', function() {
                var params = {
                    'notes': $('#timesheet_notes').val().trim(),
                    'hours': $('#timesheet_hours').val().trim(),
                    'date': $('#timesheet_date').val().trim(),
                    'card_id': $(document).find('.card-detail').attr("data-cardid").trim()
                };

                if (params.date == "" || params.hours == "") {
                    swal("Oops", "Date and hours must be filled!", "error");
                } else {
                    $('#timesheet_notes').val("");
                    $('#timesheet_hours').val("");
                    $('#timesheet_date').val("");
                    that.submitNewTimesheet(params);
                }
            });

            $(document).on('click', '.delete-timesheet-item', function() {
                var timesheet_id = $(this).attr('data-delete-timesheet-id');
                that.deleteTimesheetEntry(timesheet_id);
            });

            $(document).on('click', '.btn-card-archive', function(event) {
                event.preventDefault();
                var cardId = $(document).find('#card-detail').attr("data-cardid");
                that.archiveTask(cardId);
            });
        },


        deleteList: function(listId, listTrash) {
            var that = this;
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this List with cards!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    url: '/admin/kanban/board/delete-list',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        listId: listId
                    },
                    success: function(data) {
                        $(listTrash).closest(".bcategory-list").remove();
                        swal("Deleted!", "Your file was successfully deleted!", "success");
                        that.createActivity(listId, 'board_list', 'deleted a list');
                    }
                });
            });
        },
        updateTaskCompleted: function(taskId, isCompleted) {
            var cardId = $(document).find('#card-detail').attr("data-cardid");
            $.ajax({
                url: '/admin/kanban/board/update-task-completed',
                type: 'POST',
                dataType: 'json',
                data: {
                    taskId: taskId,
                    isCompleted: isCompleted,
                    cardId: cardId
                },
                success: function(data) {
                    var perTaskCompleted = Math.floor(data.totalTasksCompleted / data.totalTasks * 100);
                    $(document).find(".per-tasks-completed").addClass('active');
                    $(document).find(".per-tasks-completed").attr("aria-valuenow", perTaskCompleted);
                    $(document).find(".per-tasks-completed").css('width', perTaskCompleted + "%");
                    $(document).find(".per-tasks-completed").find(".show").text(perTaskCompleted + "% Tasks Completed");
                    setTimeout(function() {
                        $(document).find(".per-tasks-completed").removeClass('active');
                    }, 2000);
                }
            });
        },
        archiveTask: function(cardId) {
            var that = this;
            swal({
                title: "Are you sure?",
                text: "Mark task as closed",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, close it!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    url: '/admin/kanban/board/archive-task',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        cardId: cardId
                    },
                    success: function(data) {
                        that.createActivity(cardId, 'card_task', 'task is archived');
                        swal("Deleted!", "Your file was successfully deleted!", "success");
                        location.reload();
                    }
                });
            });
        },
        saveTask: function(taskTitle, cardId) {
            var that = this;
            $.ajax({
                url: '/admin/kanban/board/save-task',
                type: 'POST',
                dataType: 'json',
                data: {
                    taskTitle: taskTitle,
                    cardId: cardId
                },
                success: function(data) {
                    var task = '<div class="form-group sub-task-con">' +
                        '<li class="list-group-item">' +
                        '<div class="row">' +
                        '<div class="col-lg-11">' +
                        '<span data-taskid="' + data.card["id"] + '"><pre class="pre-comment">' + data.card["task_title"] + '</pre></span>' +
                        '</div>' +
                        '<div class="col-lg-1">' +
                        '<input class="magic-checkbox sub-task-title-input" type="checkbox" name="layout" id="' + data.card["id"] + '" value="option" ' + ((data.card["is_completed"] == 1) ? ' checked="checked" data-checked="1"' : 'data-checked="0"') + '>' +
                        '<a href="" class="delete-task" data-taskId="' + data.card["id"] + '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>' +
                        '</div>' +
                        '</div>' +
                        '</li>' +
                        '</div>';
                    $("#card-detail").find(".task-list-con").prepend(task);
                    $('#card-detail').find("#task-description-input").val("");

                    var perTaskCompleted = Math.floor(data.totalTasksCompleted / data.totalTasks * 100);
                    if (isNaN(perTaskCompleted)) {
                        perTaskCompleted = 0;
                    };
                    $(document).find(".per-tasks-completed").addClass('active');
                    $(document).find(".per-tasks-completed").attr("aria-valuenow", perTaskCompleted);
                    $(document).find(".per-tasks-completed").css('width', perTaskCompleted + "%");
                    $(document).find(".per-tasks-completed").find(".show").text(perTaskCompleted + "% Tasks Completed");
                    setTimeout(function() {
                        $(document).find(".per-tasks-completed").removeClass('active');
                    }, 2000);

                    if ($(".list-group-item").filter("[data-cardid=" + cardId + "]").find('ul.card-description-intro #totalTasks').length == 0) {
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('ul.card-description-intro').append(
                            '<li id="totalTasks">' +
                            '<a href="#" data-placement="bottom" data-toggle="tooltip" title="" data-totaltask="1" data-original-title="This card have 1 tasks."><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a>' +
                            '</li>'
                        );
                    } else {
                        var totalTasks = $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks a').attr("data-totaltask");
                        totalTasks++;
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks a').attr("data-original-title", "This card have " + totalTasks + " tasks.");
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks a').attr("data-totaltask", totalTasks);
                    }
                    that.reInitializeToolTip();
                    that.createActivity(cardId, 'card_task', 'task is added');
                }
            });
        },
        postComment: function(comment, cardId) {
            var that = this;
            $.ajax({
                url: '/admin/kanban/board/save-comment',
                type: 'POST',
                dataType: 'json',
                data: {
                    comment: comment,
                    cardId: cardId
                },
                success: function(data) {
                    comment = '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div style="font-size : 15px">' +
                        '<p>' + data[0].name + '</p>' +
                        '</div>' +
                        '<div class="commentText">' +
                        '<pre class="pre-comment">' + data[0].comment_description + '</pre> <span class="date sub-text">' + that.time_ago(data[0].created_at) + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</li><hr>';
                    $("ul.commentList").prepend(comment);
                    $("#comment-input").val("");

                    if ($(".list-group-item").filter("[data-cardid=" + cardId + "]").find('ul.card-description-intro  #totalComments').length == 0) {
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('ul.card-description-intro').append(
                            '<li id="totalComments">' +
                            '<a href="#" data-placement="bottom" data-toggle="tooltip" title="" data-totalcomments="1" data-original-title="This card have 1 comments."><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></a>' +
                            '</li>'
                        );
                    } else {
                        var totalComments = $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalComments a').attr("data-totalcomments");
                        totalComments++;
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalComments a').attr("data-original-title", "This card have " + totalComments + " comments.");
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalComments a').attr("data-totalComments", totalComments);
                    }

                    that.createActivity(data[0].id, 'comment', 'posted a comment');
                    that.reInitializeToolTip();
                }
            });
        },
        saveMainKanbanTaskChanges: function(cardId) {
            var that = this;
            var cardColor = $(document).find("#mainkanban_card_color").val();
            var cardId = $(document).find('#card-detail-main-kanban').attr("data-cardid");

            $.ajax({
                url: '/admin/kanban/board/update-mainkanban-card-data',
                type: 'POST',
                dataType: 'json',
                data: {
                    cardColor: cardColor,
                    cardId: cardId
                },
                success: function(data) {
                    if (cardColor.length > 0) {
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").css('border-top', '5px solid #' + cardColor);
                    } else {
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").removeAttr("style");
                    }

                    that.reInitializeToolTip();
                    $('.modal#card-detail-main-kanban').modal("hide");
                    that.createActivity(data.cardId, 'board_card', 'card is edited');
                }
            });
        },
        saveChanges: function(cardId) {
            var that = this;
            var cardName = $(document).find("#card_title_editable").text();
            var cardDescription = $(document).find("#card_description_editable").text();
            var cardTags = $(document).find("#card-tags-input").val();
            var cardColor = $(document).find("#card_color").val();
            var cardDueDate = $(document).find("#due-date").val();
            var cardId = $(document).find('#card-detail').attr("data-cardid");

            $.ajax({
                url: '/admin/kanban/board/update-card-data',
                type: 'POST',
                dataType: 'json',
                data: {
                    cardName: cardName,
                    cardDescription: cardDescription,
                    cardTags: cardTags,
                    cardColor: cardColor,
                    cardDueDate: cardDueDate,
                    cardId: cardId
                },
                success: function(data) {
                    $(".list-group-item").filter("[data-cardid=" + data.cardId + "]").find("p").text(data.cardTitle);
                    if (cardColor.length > 0) {
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").css('border-top', '5px solid #' + cardColor);
                    } else {
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").removeAttr("style");
                    }
                    if (cardDescription != "Empty") {
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").find(".card-description-intro #card_description").remove();
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").find(".card-description-intro").prepend('<li id="card_description">' +
                            '<a href="#" data-placement="bottom" data-toggle="tooltip" title="" data-original-title="This card has a description."><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span></a>' +
                            '</li>');
                    } else {
                        $(document).find(".list-group-item").filter("[data-cardid=" + data.cardId + "]").find(".card-description-intro #card_description").remove();
                    }

                    that.reInitializeToolTip();
                    $('.modal#card-detail').modal("hide");
                    that.createActivity(data.cardId, 'board_card', 'card is edited');
                    location.reload();
                }
            });
        },
        reInitializeToolTip: function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
        deleteTask: function(taskId, deleteTaskBtn) {
            var that = this;
            var cardId = $(document).find('#card-detail').attr("data-cardid");
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Task!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    url: '/admin/kanban/board/delete-task',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        taskId: taskId,
                        cardId: cardId
                    },
                    success: function(data) {
                        $(deleteTaskBtn).closest('.form-group').remove();
                        var cardId = $('.modal#card-detail').attr('data-cardid');
                        var totalTasks = $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks a').attr("data-totaltask");
                        totalTasks--;
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks a').attr("data-original-title", "This card have " + totalTasks + " tasks.");
                        $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks a').attr("data-totaltask", totalTasks);

                        var perTaskCompleted;

                        if (data.totalTasks != 0) {
                            perTaskCompleted = Math.floor(data.totalTasksCompleted / data.totalTasks * 100);
                        } else {
                            perTaskCompleted = 0;
                            $(".list-group-item").filter("[data-cardid=" + cardId + "]").find('#totalTasks').remove();
                        }

                        $(document).find(".per-tasks-completed").addClass('active');
                        $(document).find(".per-tasks-completed").attr("aria-valuenow", perTaskCompleted);
                        $(document).find(".per-tasks-completed").css('width', perTaskCompleted + "%");
                        $(document).find(".per-tasks-completed").find(".show").text(perTaskCompleted + "% Tasks Completed");
                        setTimeout(function() {
                            $(document).find(".per-tasks-completed").removeClass('active');
                        }, 2000);
                        that.createActivity(cardId, 'card_task', 'task is deleted');
                        swal("Deleted!", "Your file was successfully deleted!", "success");
                    }
                });
            });
        },
        fillTimesheet: function(data) {
            $(".timesheet_list").empty();
            if (data.length == 0) {
                $(".timesheet_list").html("<li class='list-group-item'> No timesheets yet </li>");
            } else {
                data.forEach(function(item) {
                    var d = !item.notes;
                    notes = "";
                    if (item.notes != "" && !d) notes = item.notes;

                    $('<li/>', {
                        'data-timesheet-id': item.id,
                        'class': 'list-group-item',
                        'style': 'cursor:default; font-size : 13px',
                        'html': '<div class="row">' +
                            '<strong><span>' + item.date + '</span> </strong>' +
                            '<span class="pull-right">' +
                            '<i class="fa fa-times delete-timesheet-item pull-right" style="cursor:pointer" data-delete-timesheet-id="' + item.id + '"></i>' +
                            '</span> <br />'


                            +
                            '<strong> <span class="badge">' + item.timesheet_user.first_name + ' ' + item.timesheet_user.last_name + '</span>'

                            +
                            '<span class="badge"><strong>' + item.hours + ' hrs </strong></span> <br />'

                            +
                            '<span class="text-muted">' + notes + '</span>',
                    }).appendTo('.timesheet_list');

                });
            }
        },
        deleteTimesheetEntry: function(timesheet_id) {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this timesheet!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function() {
                    $.ajax({
                        url: '/admin/kanban/timesheet/postDeleteTimesheetEntry',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            timesheet_id: timesheet_id
                        },
                        success: function(data) {

                            $('.timesheet_list').find("[data-timesheet-id = '" + timesheet_id + "']").remove();
                            swal("Deleted!", "Your timesheet was successfully deleted!", "success");
                        }
                    });
                });
        },
        submitNewTimesheet: function(params) {
            var that = this;
            $.ajax({
                url: '/admin/kanban/timesheet/postSubmitNewTimesheetEntry',
                type: 'POST',
                dataType: 'json',
                data: {
                    params: params
                },
                success: function(data) {
                    //console.log(data);
                    that.fillTimesheet(data.timesheet_data);
                    swal("Added!", "Your timesheet was successfully added!", "success");
                }
            });
        },

        putMainKanbanCardDetailInModal: function(cardId) {
            var that = this;

            $("#mainkanban_card_processing").empty();
            $.ajax({
                url: '/admin/kanban/board/getMainKanbanCardDetail',
                type: 'POST',
                dataType: 'json',
                data: {
                    cardId: cardId
                },
                success: function(data) {
                    console.log(data);

                    // General details
                    $("#card-detail-main-kanban").attr("data-cardid", data.card.id);
                    $("#mainkanban-btn-details").attr('data-potentialid', data.qc_details.potential_id);
                    $("#mainkanban_card_title").text("[PN " + data.qc_details.potential_id + "] " + data.qc_details.title);
                    $("#mainkanban_card_description").html(data.qc_details.description);
                    $("#mainkanban_card_created_at").text("Created at : " + data.qc_details.created_at);
                    //$("mainkanban_card_created_at")
                    // if(data.qc_details.quality_check[0].qc1_admin == null){
                    //     $("#mainkanban_card_processing").text('Processing');
                    // } else {
                    //     $("#mainkanban_card_qc").text("QC " + data.qc_details.qc_state);
                    //     $("#mainkanban_card_part").text("Part" + data.qc_details.part);
                    //     $("#mainkanban_card_potential_id").text("PN " + data.qc_details.potential_id);
                    // }

                    $("#mainkanban_card_admin").text("Created by - " + data.qc_details.created_by.first_name + " " + data.qc_details.created_by.last_name);
                    if (data.qc_details.client != null)
                        $("#mainkanban_card_client").text("Client - " + data.qc_details.client.first_name + " " + data.qc_details.client.last_name);
                    else $("#mainkanban_card_client").hide();

                    var dpList = "";
                    for (i = 0; i < data.userdp.length; i++)
                        dpList += data.userdp[i][0].first_name + " ";

                    $("#mainkanban_card_dp").empty();
                    $("#mainkanban_card_dp").append(dpList);


                    //comments
                    var commentList = "";
                    $.each(data.comment, function(index, val) {
                        commentList += '<li>' +
                            '<div class="row">' +
                            '<div class="col-lg-12">' +
                            '<div style="font-size : 15px">' +
                            '<p>' + val.name + '</p>' +
                            '</div>' +
                            '<div class="commentText">' +
                            '<pre class="pre-comment">' + val.comment_description + '</pre> <span class="date sub-text">' + that.time_ago(val.created_at) + '</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</li>';
                    });
                    $("#card-detail-main-kanban").find("ul.commentList").empty();
                    $("#card-detail-main-kanban").find("ul.commentList").append(commentList);


                    // Timesheet
                    that.fillTimesheet(data.timesheet);
                    $('.timesheet_date').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });

                    var cardColor = data.card.card_color;
                    that.makeEditable("#mainkanban_card_color", cardColor);
                }
            });
        },
        putCardDetailInModal: function(cardId) {
            var that = this;
            $.ajax({
                url: '/admin/kanban/board/getCardDetail',
                type: 'POST',
                dataType: 'json',
                data: {
                    cardId: cardId
                },
                success: function(data) {
                    //console.log(data);
                    $(document).find("#card-detail").attr("data-cardid", data.card.id);

                    // Assign to
                    $.fn.editable.defaults.mode = 'inline';
                    var admins = data.admins;
                    admins[0] = { value: '', text: 'Not assigned' };
                    $("#assign_to_private_kanban").editable({
                        value: data.card.assign_to,
                        source: admins,
                        params: function(params) {
                            params.cardId = data.card.id;
                            return params;
                        }
                    });

                    // Timesheet
                    that.fillTimesheet(data.timesheet);
                    $('.timesheet_date').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                    if (data.card.archived == 1)
                        $(".closed-info").hide();
                    else
                        $(".closed-info").show();

                    $.fn.editable.defaults.mode = 'inline';
                    $("#card-detail").find("#card_title_editable").text(data.card.card_title);
                    that.makeEditable("#card_title_editable");

                    $("#card-detail").find("#card_description_editable").text(data.card.card_description);
                    that.makeEditable("#card_description_editable");

                    var labels = "";
                    $.each(data.label, function(index, val) {
                        labels += val.tag_title + ", ";
                    });
                    labels = labels.substr(0, labels.length - 2);
                    $("#card-tags-input").attr("value", labels);
                    that.makeEditable("#card-tags-input", labels);

                    var cardColor = data.card.card_color;
                    that.makeEditable("#card_color", cardColor);

                    var createdAt = data.card.created_at;
                    createdAt = that.formatDate(createdAt);
                    var createdAtInput = $('#created-at').datetimepicker();
                    createdAtInput.val(createdAt).change();

                    var dueDate = data.card.due_date;
                    dueDate = that.formatDate(dueDate);
                    var dueDateInput = $('#due-date').datetimepicker();
                    dueDateInput.val(dueDate).change();


                    var taskList = "",
                        countCompletedTasks = 0,
                        countTotalTasks = 0;
                    $.each(data.task, function(index, val) {
                        countTotalTasks++;
                        if (val.is_completed) {
                            countCompletedTasks++;
                        }
                        taskList += '<div class="form-group sub-task-con">' +
                            '<li class="list-group-item">' +
                            '<div class="row">' +
                            '<div class="col-lg-11">' +
                            '<span data-taskid="' + val.id + '"><pre class="pre-comment">' + val.task_title + '</pre></span>' +
                            '</div>' +
                            '<div class="col-lg-1">' +
                            '<input class="magic-checkbox sub-task-title-input" type="checkbox" name="layout" id="' + val.id + '" value="option" ' + ((val.is_completed == 1) ? 'checked="checked" data-checked="1"' : 'data-checked="0"') + '>' +
                            '<a href="" class="delete-task" data-taskId="' + val.id + '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>' +
                            '</div>' +
                            '</div>' +
                            '</li>' +
                            '</div>';
                    });
                    var perTaskCompleted;
                    if (countTotalTasks != 0) {
                        perTaskCompleted = Math.floor(countCompletedTasks / countTotalTasks * 100);
                    } else {
                        perTaskCompleted = 0;
                    }

                    $(document).find(".per-tasks-completed").attr("aria-valuenow", perTaskCompleted);
                    $(document).find(".per-tasks-completed").css('width', perTaskCompleted + "%");
                    $(document).find(".per-tasks-completed").find(".show").text(perTaskCompleted + "% Tasks Completed");

                    $("#card-detail").find(".task-list-con").empty();
                    $("#card-detail").find(".task-list-con").append(taskList);

                    var commentList = "";
                    $.each(data.comment, function(index, val) {
                        commentList += '<li>' +
                            '<div class="row">' +
                            '<div class="col-lg-12">' +
                            '<div style="font-size : 15px">' +
                            '<p>' + val.name + '</p>' +
                            '</div>' +
                            '<div class="commentText">' +
                            '<pre class="pre-comment">' + val.comment_description + '</pre> <span class="date sub-text">' + that.time_ago(val.created_at) + '</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</li><hr>';
                    });
                    $("#card-detail").find("ul.commentList").empty();
                    $("#card-detail").find("ul.commentList").append(commentList);
                }
            });
        },
        time_ago: function(time) {
            switch (typeof time) {
                case 'number':
                    break;
                case 'string':
                    time = +new Date(time);
                    break;
                case 'object':
                    if (time.constructor === Date) time = time.getTime();
                    break;
                default:
                    time = +new Date();
            }
            var time_formats = [
                [60, 'seconds', 1], // 60
                [120, '1 minute ago', '1 minute from now'], // 60*2
                [3600, 'minutes', 60], // 60*60, 60
                [7200, '1 hour ago', '1 hour from now'], // 60*60*2
                [86400, 'hours', 3600], // 60*60*24, 60*60
                [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
                [604800, 'days', 86400], // 60*60*24*7, 60*60*24
                [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
                [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
                [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
                [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
                [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
                [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
                [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
                [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
            ];
            var seconds = (+new Date() - time) / 1000,
                token = 'ago',
                list_choice = 1;

            if (seconds == 0) {
                return 'Just now'
            }
            if (seconds < 0) {
                seconds = Math.abs(seconds);
                token = 'from now';
                list_choice = 2;
            }
            var i = 0,
                format;
            while (format = time_formats[i++])
                if (seconds < format[0]) {
                    if (typeof format[2] == 'string')
                        return format[list_choice];
                    else
                        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
                }
            return time;
        },
        formatDate: function(dueDate) {
            var d = new Date(dueDate),
                dformat = [d.getMonth() + 1,
                    d.getDate(),
                    d.getFullYear()
                ].join('/') + ' ' + [d.getHours(),
                    d.getMinutes(),
                    d.getSeconds()
                ].join(':');

            return dformat;
        },
        makeEditable: function(elementId, opt) {
            switch (elementId) {
                case "#card_title_editable":
                    var cardTitle = $(elementId).text();
                    $("#card-detail").find(elementId).editable({
                        validate: function(value) {
                            if ($.trim(value) == '')
                                return 'Value is required.';
                        },
                        inputclass: "x-editable-input",
                        type: 'text',
                        placement: 'right',
                    });
                    $("#card-detail").find(elementId).editable("setValue", cardTitle);
                    break;
                case "#card_description_editable":
                    var cardDescription = $(elementId).text();
                    $("#card-detail").find(elementId).editable({
                        inputclass: "x-editable-input",
                        type: 'text',
                        placement: 'right',
                    });
                    $("#card-detail").find(elementId).editable("setValue", cardDescription);
                    break;
                case "#card-tags-input":
                    if ($('#card-tags-input').hasClass('selectized') === false) {
                        if ($('#card-detail').hasClass('selectized') === false) {
                            $("#card-detail").find(elementId).selectize({
                                persist: false,
                                createOnBlur: true,
                                create: true
                            });
                        }
                    } else {
                        var opt = opt.split(',');
                        var selectize = $("#card-tags-input")[0].selectize;
                        selectize.clearOptions()
                        $(opt).each(function(index, lalbe) {
                            label = $.trim(lalbe);
                            selectize.addOption({ value: label, text: label });
                            selectize.addItem(label);
                        });
                    }
                    break;
                case "#card_color":
                    var $select = $("#card-detail").find(elementId).selectize();
                    $select[0].selectize.setValue(opt);
                    break;
                case "#mainkanban_card_color":
                    var $select = $("#card-detail-main-kanban").find(elementId).selectize();
                    $select[0].selectize.setValue(opt);
                    break;
                case "#select-board":
                    var my = $(elementId).selectize();
                    $(my).next(".selectize-control").find(".selectize-input").css('width', '218px');
                    $(my).next(".selectize-control").find(".selectize-dropdown").css('width', '210px');
                default:
                    break;
            }
        },
        deleteCard: function(cardId, cardIdCon) {
            var that = this;
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this List with cards!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    url: '/admin/kanban/board/deleteCard',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        cardId: cardId
                    },
                    success: function(data) {
                        $(cardIdCon).remove();
                        $('.modal#card-detail').modal("hide");
                        that.createActivity(data.id, 'board_card', 'deleted a card');
                        swal("Deleted!", "Your file was successfully deleted!", "success");
                    }
                });
            });
        },
        saveCard: function(data, curentBtnClicked) {
            var that = this;
            $.ajax({
                url: '/admin/kanban/board/postCard',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    $(that.targetList).find('.card-con').append(
                        '<li class="list-group-item board-list-items ui-sortable-handle" id="card_' + data.id + '" data-cardid="' + data.id + '" data-toggle="modal" href="#card-detail">' +
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<p style="margin-bottom: 0px;" class="pull-left">' + data.card_title + '</p>' +
                        '<ul class="card-description-intro list-inline pull-right"></ul>' +
                        '</div>' +
                        '</div>' +
                        '</li>'
                    );
                    $(that.targetList).find('form').hide();
                    $(that.targetList).find('form textarea').val('');
                    $(that.targetList).find('a.show-input-field').show();
                    that.createActivity(data.id, 'board_card', 'created a card');
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').find('.alert').remove();
                    $.each(response, function(index, val) {
                        $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').addClass('has-error');
                        $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').prepend('<div class="alert alert-danger"><li>' + val + '</li></div>');
                    });
                }
            });
        },
        saveBoard: function() {
            that = this;

            var boardUsers = {};
            that.params['boardUsers'].each(function() {
                if ($(this).is(':checked'))
                    boardUsers[$(this).attr('name')] = '1';
            });

            $.ajax({
                url: '/admin/kanban/postBoard',
                type: 'POST',
                dataType: 'json',
                data: {
                    boardTitle: that.params['boardTitle'].val(),
                    boardPrivacyType: that.params['boardPrivacyType'].val(),
                    boardUsers: boardUsers
                },
                success: function(data) {
                    $(that.params['createBoardLink']).closest(".col-lg-3").before(
                        '<div class="col-lg-3">' +
                        '<div class="board-link" style="cursor: pointer;" data-boardid="' + data.id + '">' +
                        '<div class="row">' +
                        '<div class="col-lg-10">' +
                        '<h2 style="margin-top: 5px;">' +
                        '<a href="http://localhost:8000/board?id=' + data.id + '" class="board-main-link-con" style="font-size: 20px; color: #FFF;">' +
                        data.boardTitle +
                        '</a>' +
                        '</h2>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                        '<p style="margin-top: 12px;">' +
                        '<a href="#" style="font-size: 20px; color: #FFF;" id="make-fv-board"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></a>' +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );
                    that.params['createNewBoardModal'].modal('hide')
                    that.params['boardTitle'].val('');
                    that.params['boardTitleCon'].removeClass('has-error');
                    that.params['boardTitleCon'].find('.help-block').remove();
                    that.createActivity(data.id, 'board', 'created a board');
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    that.params['boardTitleCon'].find('.help-block').remove();
                    $.each(response, function(index, val) {
                        that.params['boardTitleCon'].addClass('has-error');
                        that.params['boardTitleCon'].append('<span class="help-block"><strong>' + val + '</strong></span>');
                    });
                }
            });
        },
        createActivity: function(activity_in_id, changed_in, activity_description) {
            $.ajax({
                url: '/admin/kanban/create-user-activity',
                type: 'POST',
                dataType: 'json',
                data: {
                    activity_in_id: activity_in_id,
                    changed_in: changed_in,
                    activity_description: activity_description
                },
                success: function(data) {
                    //console.log("data")
                },
                error: function(error) {
                    //console.log(error);
                }
            });
        },
        savePublicList: function(data, curentBtnClicked) {
            that = this;
            $.ajax({
                url: '/admin/kanban/board/postListName',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    $(curentBtnClicked).closest(".bcategory-list").before(
                        '<div class="bcategory-list" data-list-id="' + data.id + '">' +
                        '<div class="panel panel-primary">' +
                        '<div class="panel-heading" style="border-bottom: 0px; ">' +
                        '<div class="row">' +
                        '<div class="col-lg-10">' +
                        '<h3 class="panel-title board-panel-title editable editable-click" data-pk="' + data.id + '">' + data.list_name + '</h3>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                        '<span data-listid="' + data.id + '" class="glyphicon glyphicon-trash delete-list" aria-hidden="true" style="cursor: pointer;"></span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="panel-body card-list-con frame">' +
                        '<ul class="list-group">' +
                        '<div class="card-con ui-sortable" data-listid="' + data.id + '">' +
                        '</div>' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );
                    that.initCradDrag();
                    //that.initEditableListName();
                    that.params['createNewBoardModal'].modal('hide');
                    $('.show-input-field').show();
                    $('.add-board-list-form').hide();
                    $('.add-board-list-form').find('input[type="text"]').val('');
                    that.params['boardTitle'].val('');
                    that.params['boardTitleCon'].removeClass('has-error');
                    that.params['boardTitleCon'].find('.alert').remove();
                    that.createActivity(data.id, 'board_list', 'created a list');
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').find('.alert').remove()
                    $.each(response, function(index, val) {
                        $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').addClass('has-error');
                        $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').prepend('<div class="alert alert-danger"><li>' + val + '</li></div>');
                    });
                }
            });
        },
        saveList: function(data, curentBtnClicked) {
            that = this;
            $.ajax({
                url: '/admin/kanban/board/postListName',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    $(curentBtnClicked).closest(".bcategory-list").before(
                        '<div class="bcategory-list" data-list-id="' + data.id + '">' +
                        '<div class="panel panel-primary">' +
                        '<div class="panel-heading" style="border-bottom: 0px; ">' +
                        '<div class="row">' +
                        '<div class="col-lg-10">' +
                        '<h3 class="panel-title board-panel-title editable editable-click" data-pk="' + data.id + '">' + data.list_name + '</h3>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                        '<span data-listid="' + data.id + '" class="glyphicon glyphicon-trash delete-list" aria-hidden="true" style="cursor: pointer;"></span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="panel-body card-list-con frame">' +
                        '<ul class="list-group">' +
                        '<div class="card-con ui-sortable" data-listid="' + data.id + '">' +
                        '</div>' +
                        '</ul>' +
                        '<a href="#" class="show-input-field">Add a card...</a>' +
                        '<form action="" method="POST" role="form" style="display: none;">' +
                        '<div class="form-group" id="dynamic-board-input-con" style="margin-bottom: 8px;">' +
                        '<textarea name="card-title" class="form-control" rows="3"></textarea>' +
                        '<input type="hidden" name="list_id" value="' + data.id + '">' +
                        '<input type="hidden" name="board_id" value="' + data.board_id + '">' +
                        '</div>' +
                        '<div class="form-group" style="margin-bottom: 0px;">' +
                        '<button type="submit" class="btn btn-primary" id="saveCard">Save</button> <span class="glyphicon glyphicon-remove close-input-field" aria-hidden="true"></span>' +
                        '</div>' +
                        '</form>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );
                    that.initCradDrag();
                    //that.initEditableListName();
                    that.params['createNewBoardModal'].modal('hide');
                    $('.show-input-field').show();
                    $('.add-board-list-form').hide();
                    $('.add-board-list-form').find('input[type="text"]').val('');
                    that.params['boardTitle'].val('');
                    that.params['boardTitleCon'].removeClass('has-error');
                    that.params['boardTitleCon'].find('.alert').remove();
                    that.createActivity(data.id, 'board_list', 'created a list');
                },
                error: function(error) {
                    var response = JSON.parse(error.responseText);
                    $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').find('.alert').remove()
                    $.each(response, function(index, val) {
                        $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').addClass('has-error');
                        $(curentBtnClicked).closest('form').find('#dynamic-board-input-con').prepend('<div class="alert alert-danger"><li>' + val + '</li></div>');
                    });
                }
            });
        }
    };
    Board.init({
        boardTitle: $('#boardTitle'),
        boardPrivacyType: $('#boardPrivacyType'),
        saveBoardBtn: $('#save-board'),
        createNewBoardModal: $('#create-new-board'),
        //boardTitleCon: $('#boardTitleCon'),
        createBoardLink: $('.board-create-link'),
        boardUsers: $('input.users[type=checkbox]')
    });
})