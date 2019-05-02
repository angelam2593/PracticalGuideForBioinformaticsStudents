/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('../bootstrap');

import VueStrap from 'vue-strap';
import Multiselect from 'vue-multiselect';
import VeeValidate from 'vee-validate';
import 'vue-multiselect/dist/vue-multiselect.min.css';

import swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.component(Multiselect);
Vue.use(VeeValidate);

/**
 * Extending the validator to validate the amounts inserted,
 * Checks if the inserted amount is <= of the counts.
 * @type {boolean}
 */
VeeValidate.Validator.extend('amount_validate', {
    getMessage: field => 'You cannot order more than the counts',
    validate(value, obj) {
        return parseInt(value) <= parseInt(obj[0]);
    }
});

const app = new Vue({
    el: '#app',

    components: {
        'button-group': VueStrap.buttonGroup,
        'radio': VueStrap.radio,
        'multiselect': Multiselect,
        'spinner': VueStrap.spinner
    },

    data: {
        /**
         * Country select variables
         * @type {Array}
         */
        countriesModel: [],
        countries: [],
        countriesLoading: false,

        /**
         * Models
         * @type {Array}
         */
        genderModel: [],
        ageRangesModel: [],
        typeModel: [],

        /**
         * Model and option array which is empty
         * since we dont load any postcodes but the
         * directive requires it.
         * @type {Array}
         */
        postcodesModel: [],
        postcodesOptions: [],
        birthYearModel: [],
        birthYearOptions: [],

        /**
         * Main and secondary filters
         * models.
         * @type {String}
         */
        mainFilter: "",
        secondaryFilter: "",

        /**
         * Loading spinner
         * @type {Boolean}
         */
        resultsSpinner: false,

        /**
         * Results (counts) object
         * @type {object}
         */
        results: null,

        /**
         * Model for the input form.
         * On refresh counts this is binded with the counts
         * and the form.
         * @type {Array}
         */
        amounts: []
    },

    watch: {

        mainFilter(newValue, oldValue) {
            if (newValue != "" && oldValue != "")
                this.secondaryFilter = "";
        },
        secondaryFilter(newValue, oldValue) {
            if (newValue != "" && oldValue != "")
                this.mainFilter = "";
        },

    },

    computed: {

        showSubmitOrderButton() {
            let objectExist = Object.keys(this.results).length > 0;
            let isEmpty = true;
            _.forIn(this.amounts, function(value, key) {
                if (value.amount > 0) {
                    isEmpty = false;
                    return objectExist && !isEmpty;
                }
            });

            return objectExist && !isEmpty;
        },

        disableAddToCart() {
            return this.errors.any();
        },

        /**
         * Computed properties for showing/hiding
         * features on the form.
         * @return {Boolean}
         */

        showMainFilters() {
            if (this.atLeastOneFilter()) {
                return true;
            } else {
                this.mainFilter = "";
                return false;
            }
        },

        showSecondaryFilter() {
            if (this.mainFilter != "" && this.exactlyOneFilter() >= 2) return true;
            else {
                this.secondaryFilter = "";
                return false;
            }
        },

        showRefreshButton() {
            return this.mainFilter != "";
        },

        showResults() {
            return this.results && this.atLeastOneFilter();
        },

        computedFiltersWhatchable() {
            this.countriesModel;
            this.genderModel;
            this.typeModel;
            this.ageRangesModel;
            this.postcodesModel;
            this.birthYearModel;

            return Date.now();
        }

    },

    watch: {

        computedFiltersWhatchable(newValue) {
            if (!(this.countriesModel.length || this.genderModel.length ||
                    this.ageRangesModel.length || this.typeModel.length || this.postcodesModel.length ||
                    this.birthYearModel.length)) {
                this.results = null;
            }
        }

    },

    methods: {

        /**
         * Helper function for the computed properties
         */
        atLeastOneFilter() {
            return this.countriesModel.length || this.genderModel.length ||
                this.ageRangesModel.length || this.typeModel.length || this.postcodesModel.length || this.birthYearModel;
        },
        exactlyOneFilter() {
            let filters = [this.countriesModel, this.genderModel, this.ageRangesModel, this.typeModel];
            let count = 0;
            filters.forEach(function(filterArray) {
                if (filterArray.length) count++;
            });

            return count;
        },
        getSecondaryFilter() {
            if (this.secondaryFilter == "") {
                this.secondaryFilter = -1;
                return this.secondaryFilter;
            }
            return this.secondaryFilter;
        },
        /**
         * ------------------------------------------
         */

        /**
         * Methods for async countries search.
         * limitText - for limiting the results length.
         * asyncFind - the actual async function
         * @param  {String} query [The search query]
         * @return {void}
         */
        limitText(count) {
            return `and ${count} other countries`;
        },
        asyncFind(query) {
            this.countriesLoading = true;
            axios.get('/order/b2c/getAllCountries', {
                    params: {
                        name: query
                    }
                })
                .then(response => {
                    this.countries = response.data;
                    this.countriesLoading = false;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        /**
         * ------------------------------------------
         */


        /**
         * Add postcode to the postcodes model and search.
         * @param {String} newTag [Tag inserted]
         */
        addPostcode(newTag) {
            this.postcodesOptions.push(newTag);
            this.postcodesModel.push(newTag);
        },

        /**
         * Add birth years to the birthYearModel and search.
         * @param {String} newTag [Tag inserted]
         */
        addBirthYear(newTag) {
            this.birthYearOptions.push(newTag);
            this.birthYearModel.push(newTag);
        },

        /**
         * Function for seting up the amounts array
         * which is binded to the view
         * @param {array} groupData [Ajax data received from the DB]
         */
        setUpSubmitModels(groupData) {
            //console.log(groupData);
            var var_total = false;
            var array_total = [];
            for (var item1 in groupData) {
                //console.log("Item1: " + item1);
                if (groupData.hasOwnProperty(item1)) {
                    for (var item2 in groupData[item1]) {
                       if (item2 == 'total') {
                            var_total = true;
                            array_total.push(0);
                            //console.log("Niza za total gggg: " + array_total);
                        }
                        array_total.push(groupData[item1][item2].id);
                        //console.log("Item2: " + item2);
                        if (groupData[item1].hasOwnProperty(item2)) {
                            if (item1 != "" && item2 != "" && item2 != "id") {
                                //console.log("Group data item1 item2 id " + groupData[item1][item2].id);
                                this.amounts.push({
                                    'id': groupData[item1][item2].id ? groupData[item1][item2].id : null,
                                    'amount': 0,
                                    'filter': item2,
                                    'mainFilter': item1,
                                    'secondaryFilter': item2,
                                    'mainFilter_id': groupData[item1].id,
                                    'total': var_total,
                                    'array_total': array_total
                                });
                            }

                        }
                    }
                }
            }
        },

        /**
         * Click on the refresh counts button
         * Makes ajax call and receives the results.
         * @return {void}
         */
        resfreshCounts() {

            // alert(0);
            
            // axios.post('/order/b2c/postFilterData', {
            //     'my_company_sample': this.myCompanySample,
            //     'countries': this.countriesModel.map(country => country.id).join(','),
            //     'genders': this.genderModel,
            //     'ageRanges': this.ageRangesModel,
            //     'postcodes': this.postcodesModel.join(','),
            //     'type': this.typeModel,
            //     'mainFilter': this.mainFilter,
            //     'secondaryFilter': this.getSecondaryFilter()
            // }).then(response => {
            //     console.log(response);
            // }).catch(e => {
            //     console.log(response);
            // });
            this.resultsSpinner = true;
            //console.log("preku axios");
            axios.post('/order/b2c/postFilterData', {
                    'countries': this.countriesModel.map(country => country.id).join(','),
                    'genders': this.genderModel,
                    'ageRanges': this.ageRangesModel,
                    'postcodes': this.postcodesModel.join(','),
                    'birthYears': this.birthYearModel.join(','),
                    'type': this.typeModel,
                    'mainFilter': this.mainFilter,
                    'secondaryFilter': this.getSecondaryFilter()
                })
                .then(response => {
                    //console.log(response.data);
                    this.results = [];
                    this.amounts = [];
                    this.results = response.data;
                    this.setUpSubmitModels(response.data);
                    this.resultsSpinner = false;


                })
                .catch(e => {
                    console.log(e);
                    this.resultsSpinner = false;
                    swal({
                        title: 'Oops...',
                        text: "There was an error generating the counts",
                        type: 'warning',
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: "Close"
                    }).catch(swal.noop);
                });
        },

        /**
         * Helper function for transforming the Params
         * into object.
         * @return {Object} [All the params in one object]
         */
        getParams() {
            return {
                countries: this.countriesModel.map(country => country.id).join(','),
                genders: this.genderModel,
                ageRanges: this.ageRangesModel,
                postcodes: this.postcodesModel.join(','),
                birthYears: this.birthYearModel.join(','),
                type: this.typeModel
            };
        },

        /**
         * Submit the order and add it to the cart
         * @return {void}
         */
        submitOrder() {
            if (this.orderValidity()) {
                this.resultsSpinner = true;
                axios.post('/order/b2c/addOrderToCart', {
                        'params': this.getParams(),
                        'mainFilter': this.mainFilter,
                        'secondaryFilter': this.getSecondaryFilter(),
                        'amounts': this.amounts.filter(item => item.amount > 0)
                    })
                    .then(response => {
                        this.resultsSpinner = false;
                        window.location.href = '/cart/overview';
                    })
                    .catch(e => {
                        console.log(e);
                        this.resultsSpinner = false;
                    });
            } else {
                swal({
                    title: 'Oops...',
                    text: "You must select either total or specific values, but not both.",
                    type: 'warning',
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: "Close"
                }).catch(swal.noop);
            }
        },

        orderValidity() {
            let notTotal = this.amounts.filter(item => item.filter == 'total' && item.amount > 0).length;
            let total = this.amounts.filter(item => item.filter != 'total' && item.filter != '' && item.amount > 0).length;

            return (notTotal > 0 && total == 0) || (notTotal == 0 && total > 0);
        }
    }
});