$(document).ready(function() {


    /**
     * Setting the csrf token once so that we dont have to send it
     * every time.
     * @type {Setting}
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    /**
     * Main js class for B2C order form
     * All the functions should be listed inside separated with commas.
     * Init function is called on view render.
     * @type {Object}
     */
    var Order = {
        /**
         * Initializing the fields in the order form
         * @return {void}
         */
        init : function() {

            /**
             * Function that binds html elements to events or libraries.
             */
            this.bindUI();

        },


        /**
         * Bind the html elements with their manipulators.
         * @return {void}
         */
        bindUI : function() {
            var that = this;

            $("[id='my_company_sample']").bootstrapSwitch({
                onText : 'My company\'s sample',
                offText : 'Sample solutions\'s sample',
                labelWidth : '500'
            });

            $("#secondaryFilterForm").hide();

            /**
             * Country field initialize
             * @type {autocomplete, tags, cannot create new tags}
             */
            var country = $('#country').selectize({
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                options: [],
                persist: false,
                loadThrottle: 600,
                create: false,
                allowEmptyOption: true,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: 'b2c/getAllCountries',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            name: query
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            // you can apply any modification to data before passing it to selectize
                            callback(res);
                            // res is json response from server
                            // it contains array of objects. Each object has two properties. In this case 'id' and 'Name'
                            // if array is inside some other property of res like 'response' or something. than use this
                            //callback(res.response);
                        }
                    });
                }
            })[0].selectize;

            /**
             * Postcode field initialize
             * @type {autocomplete, tags, can create new tags}
             */
            var postcode = $('#postcode').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            })[0].selectize;

            $(".mainFilterGroupBy").click(function(){
                if($("#mainFilterForm :radio:checked").length){
                    var mainFilter = that.getMainFilter();
                    var params = that.getParams();

                    that.toggleSecondaryFilters(params, mainFilter);

                }
            });

            /**
             * Hide mainFilter form
             */
             $("#mainFilterForm").show();
             $("#counts_spinner").hide();
             $("#counts").hide();
            /**
             * Register click event on the 'Refresh Counts' button
             * @type {event} [sends params to refreshCounts()]
             */
            $("#refresh_counts").click(function(){
                var params = that.getParams();
                var mainFilter = that.getMainFilter();
                var secondaryFilter = that.getSecondaryFilter();
                that.refreshCounts(params, mainFilter, secondaryFilter);
            });

            $(".form").change(function(){
                var params = that.getParams();
                var mainFilter = that.getMainFilter();

                that.toggleSecondaryFilters(params, mainFilter);
                that.toggleMainFilterForm(params);
            });

            $(document).on('click', '#btn_submit_order', function(){
                //var params = that.getParams();
                //var mainFilter = that.getMainFilter();
                //var secondaryFilter = that.getSecondaryFilter();
                that.submitOrder();
            });

        },

        toggleSecondaryFilters : function(params, mainFilter){

            $("#secondaryFilterForm label").each(function(){ $(this).show(); });

            var that = this;
            that.count = 0;

            $.each(params, function(key, value){
                if(typeof value === "string"){
                    if(value.length != 0) that.count++;
                } else if(value instanceof Array){
                    if(value.length != 0) that.count++;
                }
            });

            $("#country_secondary_filter_input").prop('checked', false);
            $("#gender_secondary_filter_input").prop('checked', false);
            $("#agerange_secondary_filter_input").prop('checked', false);
            $("#type_secondary_filter_input").prop('checked', false);
            if(that.count >= 2){
                $("#secondaryFilterForm").show();

                if(params.countries == "") $("#country_secondary_filter").hide();
                if(params.genders.length == 0) $("#gender_secondary_filter").hide();
                if(params.ageRanges == "") $("#agerange_secondary_filter").hide();
                if(params.type.length == 0) $("#type_secondary_filter").hide();

                if(mainFilter == 'country_id') $("#country_secondary_filter").hide();
                if(mainFilter == 'gender_id') $("#gender_secondary_filter").hide();
                if(mainFilter == 'birth_year') $("#agerange_secondary_filter").hide();
                if(mainFilter == 'type') $("#type_secondary_filter").hide();
            } else {

                $("#secondaryFilterForm").hide();
            }
        },

        /**
         * On every form click we see if two or more
         * form inputs are filled and then we show them.
         * @param  {object} params form params
         * @return {void}   show or hide form
         */
        toggleMainFilterForm : function(params) {

            if(params.countries == ""){
                $("#country_main_filter").hide();
                $("#country_main_filter_input").prop('checked', false);
            } else $("#country_main_filter").show();

            if(params.genders.length == 0){
                $("#gender_main_filter").hide();
                $("#gender_main_filter_input").prop('checked', false);
            }  else $("#gender_main_filter").show();

            if(params.ageRanges.length == 0){
                $("#agerange_main_filter").hide();
                $("#agerange_main_filter_input").prop('checked', false);
            }  else $("#agerange_main_filter").show();

            if(params.type.length == 0){
                $("#type_main_filter").hide();
                $("#type_main_filter_input").prop('checked', false);
            } else $("#type_main_filter").show();

            if(params.countries == "" && params.genders.length == 0 && params.ageRanges.length == 0 && params.type.length == 0){
                $("#country_main_filter").show();
                $("#gender_main_filter").show();
                $("#agerange_main_filter").show();
                $("#type_main_filter").show();
            }
        },

        /**
         * Get all values from the order form
         * @return {object} params with their values
         */
        getParams : function() {
            return {
                countries : $("#country").val(),
                genders : checked = $('input.gender[type=checkbox]:checked').map(function(){ return this.value }).get(),
                ageRanges : checked = $('input.ageRange[type=checkbox]:checked').map(function(){ return this.value }).get(),
                postcodes : $("#postcode").val(),
                type : $('input.type[type=checkbox]:checked').map(function(){ return this.value }).get(),
                my_company_sample : $('#my_company_sample').bootstrapSwitch('state')
            }
        },

        /**
         * Get main filter values
         * @return {[type]} [description]
         */
        getMainFilter : function() {
            var checked = $("input[name='main_filter']:checked").val();
            return (checked == undefined ? -1 : checked);
        },

        getSecondaryFilter : function() {
            var checked = $("input[name='secondary_filter']:checked").val();
            return (checked == undefined ? -1 : checked);
        },

        /**
         * Send all form values to server.
         * @param  {object} params form params
         * @return {void}   fill view with data
         */
        refreshCounts : function(params, mainFilter, secondaryFilter) {
            var that = this;

            if(that.validFilters(params, mainFilter)){
                $("#counts_spinner").show();
                $("#counts").hide();
                $.ajax({
                    url: 'b2c/postFilterData',
                    type: 'POST',
                    dataType : 'json',
                    data: {
                        countries : params.countries,
                        genders : params.genders,
                        ageRanges : params.ageRanges,
                        postcodes : params.postcodes,
                        type: params.type,
                        my_company_sample: params.my_company_sample,
                        mainFilter : mainFilter,
                        secondaryFilter : secondaryFilter
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#counts_spinner").hide();
                        if(data.length == 0){
                            $("#counts").empty();
                            $("#counts").html('<h3 class="text-center"> There are no results with the selected filters. </h3>');
                            $("#counts").show();
                        } else {
                            that.displayOrderForm(data);
                        }

                    },
                    error: function (error) {
                        $("#counts_spinner").hide();
                        $("#counts").html('<h3>Error ... try again </h3>');
                        $("#counts").show();
                    }
                });
            } else {
                alert('You need one GROUP BY filter and at least one FILTER');
            }

        },
        /**
         * Generate order form html
         * @param  {string} mainFilter
         * @param  {array} data       array of result objects
         * @return {void}             set html.
         */
        displayOrderForm : function(data) {

            var html = "<table class='table table-bordered form-table'>";

            for (var key in data) {
                // skip loop if the property is from prototype
                if (!data.hasOwnProperty(key) || key == "") continue;

                // Main filter name
                var group = data[key];

                html += "<tr><td>"+key+"</td><td></td><td></td><td></td></tr>";

                for(var grouped_key in group){
                    // skip loop if the property is from prototype
                    if (!group.hasOwnProperty(grouped_key)) continue;
                    var grouped_item = group[grouped_key];

                    if(grouped_key != ""){
                        if(grouped_key != "total" && grouped_key != "id")
                            html += "<tr><td></td> <td>" + grouped_key + "</td><td>" + grouped_item['count'] + "</td><td>" +
                                    "<input type='text' data-mainfilter_name='"+ key +"' data-mainfilter_id='"+ group['id'] +"' data-secondaryfilter_name='"+ grouped_key +"' data-secondaryfilter='"+ grouped_item['id'] +"' class='form-control order-input' placeholder='Order from "+grouped_key+"' /> </td></tr>";
                    }
                }

                html += "<tr> <td></td> <th align='right'>Total</th> <th>"+ group['total'] + "</th><th>" +
                        "<input type='text' data-mainfilter_name='"+ key +"' data-mainfilter='"+ group['id'] +"' class='form-control order-input' placeholder='Order from total' /> </th></tr>";
            }
            html += "</table>";

            html += "<hr> <div class='row'><div class='col-md-12'> <button id='btn_submit_order' class='btn btn-primary pull-right'>Add this order to cart</button> </div></div>";
            $("#counts").html(html);
            $("#counts").show();
        },


        /**
         * Validate if the filters are selected okay
         * @param  {array} params      form parameters
         * @param  {string} mainFilter main filter
         * @return {boolean}           if the filter selection is okay
         */
        validFilters : function(params, mainFilter) {
            if(mainFilter == -1 && params.countries == "" && params.genders.length == 0 && params.ageRanges.length == 0 && params.postcodes == "" && params.type.length == 0) return false;
            if(mainFilter != -1 && params.countries == "" && params.genders.length == 0 && params.ageRanges.length == 0 && params.postcodes == "" && params.type.length == 0) return false;
            if(mainFilter == -1 && (params.countries != "" || params.genders.length != 0 || params.ageRanges.length != 0 || params.postcodes != "" || params.type.length != 0)) return false;

            if(mainFilter == 1 && params.countries == "") return false; else return true;
            if(mainFilter == 2 && params.genders.length == 0) return false; else return true;
            if(mainFilter == 3 && params.ageRanges.length == 0) return false; else return true;
            if(mainFilter == 4 && params.type.length == 0) return false; else return true;
        },

        /**
         * Submit order to cart
         * @param  {array} params     [form params]
         * @param  {string} mainFilter [main filter]
         * @return {void}            [void]
         */
        submitOrder : function() {
            var params = Order.getParams();
            var mainFilter = Order.getMainFilter();
            var secondaryFilter = Order.getSecondaryFilter();

            var main_amounts = new Array();
            var secondary_amounts = new Array();
            var amounts = new Array();
            $('.order-input').each(function(){
                var input = $(this);
                var amount = input.val();

                if(input.data('mainfilter') !== undefined && amount != ""){
                    main_amounts.push({ 'id' : input.data('mainfilter'), 'amount' : amount });
                    amounts.push({ 'id' : input.data('mainfilter'),
                                    'amount' : amount,
                                    'filter' : input.data('mainfilter_name'),
                                    'mainFilter_id' : input.data('mainfilter')
                    });
                } else if(input.data('secondaryfilter') !== undefined && amount != "") {
                    secondary_amounts.push({ 'id' : input.data('secondaryfilter'), 'amount' : amount });
                    amounts.push({ 'id' : input.data('secondaryfilter'),
                                    'amount' : amount,
                                    'filter' : input.data('secondaryfilter_name'),
                                    'mainFilter_id' : input.data('mainfilter_id'),
                                    'mainFilter' : input.data('mainfilter_name')
                    });
                }
            });


            if((main_amounts.length != 0 && secondary_amounts.length == 0) || (main_amounts.length == 0 && secondary_amounts.length != 0)){
                $.ajax({
                    url: 'b2c/addOrderToCart',
                    type: 'POST',
                    dataType : 'json',
                    data: {
                        params : params,
                        mainFilter : mainFilter,
                        secondaryFilter : (secondary_amounts.length != 0) ? secondaryFilter : -1,
                        amounts : amounts
                    },
                    success: function (data) {
                        window.location.href = '/cart/overview';
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            } else {
                alert("You can order from total or sub-category, but not from both");
            }
        }
    };


    /**
     * Initialize the order form
     */
    Order.init();
});
