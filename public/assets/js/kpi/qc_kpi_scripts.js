function counts_modal(name, description, list_id){
    let modal_html="";
    modal_html='<div class="modal fade" id="'+name+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
        '                        <div class="modal-dialog" role="document">\n' +
        '                            <div class="modal-content">\n' +
        '                                <div class="modal-header">\n' +
        '                                    <h4 class="modal-title text-center" id="exampleModalLabel">'+description+'</h4>\n' +
        '                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -30px;">\n' +
        '                                        <span aria-hidden="true">&times;</span>\n' +
        '                                    </button>\n' +
        '                                </div>\n' +
        '                                <div class="modal-body text-center">\n' +
        '                                    <ol id="'+list_id+'"></ol>\n' +
        '                                </div>\n' +
        '                                <div class="modal-footer">\n' +
        '                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                    </div>';
    return modal_html;
}
function createBarChart(container_name, data_array, divider) {
    Highcharts.chart(container_name, {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Average time (in hours)'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: ~ <b>{point.y:.1f}</b> hours<br/>'
        },

        series: [{
            name: 'Type of product',
            colorByPoint: true,
            data: [{
                name: 'RDD',
                y: data_array[1]/divider
            }, {
                name: 'B2B',
                y: data_array[2]/divider
            }, {
                name: 'B2C',
                y: data_array[3]/divider
            }, {
                name: 'COUNTS',
                y: data_array[4]/divider
            }, {
                name: 'DATA SERVICES',
                y: data_array[5]/divider
            }]
        }]
    });
}
function createCharts(product_kpi, averages){
    createBarChart('container2', [null, product_kpi[1]['avg_time'],product_kpi[2]['avg_time'],product_kpi[3]['avg_time'],product_kpi[4]['avg_time'],product_kpi[5]['avg_time']], 3600);
    createBarChart('container4', [null, averages[1]['dt']/averages[1]['count'], averages[2]['dt']/averages[2]['count'], averages[3]['dt']/averages[3]['count'], averages[4]['dt']/averages[4]['count'], averages[5]['dt']/averages[5]['count']], 3600);
    createBarChart('container5', [null, averages[1]['th']/averages[1]['count'], averages[2]['th']/averages[2]['count'], averages[3]['th']/averages[3]['count'], averages[4]['th']/averages[4]['count'], averages[5]['th']/averages[5]['count']], 1);

    Highcharts.chart('container3', {
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['RDD', 'B2B', 'B2C', 'COUNTS', 'DATA SERVICES']
        },
        tooltip: {
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}</b><br/>'
        },

        series: [{
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y', 'selected', 'sliced'],
            data: [
                ['RDD', product_kpi[1]['count'], false],
                ['B2B', product_kpi[2]['count'], false],
                ['B2C', product_kpi[3]['count'], false],
                ['COUNTS', product_kpi[4]['count'], false],
                ['DATA SERVICES', product_kpi[5]['count'], false]
            ],
            showInLegend: true
        }]
    });
    $("#chartsPanel").show();
}
function fillTable(name, list) {
    $('#'+name).html("");
    let html_string="<table class=\"table\">";
    html_string+="<thead>\n" +
        "      <tr>\n" +
        "        <th>ID and project name</th>\n" +
        "        <th>Total hours</th>\n" +
        "      </tr>\n" +
        "    </thead><tbody>";

    for(let key in list){
        //console.log(key+" "+list[key]);
        html_string+="<tr>\n" +
            "        <td style='text-align: left'>"+key+"</td>\n" +
            "        <td style='text-align: right'>"+list[key]+"</td>\n" +
            "      </tr>"
    }
    html_string+="</tbody>\n" +
        "  </table>";
    $('#'+name).html(html_string);
}
function open_modal(data) {
    $("#modal_title").html("Projects");
    $("#modal_text").html("");
    for(var i=0; i<data.length; i++){
        $("#modal_text").append("<b>Project Name: </b>"+data[i]['title']+"<br>");
        $("#modal_text").append("<b>Product Type: </b>"+data[i]['type']+"<br>");
        $("#modal_text").append("<b>Project Users: </b>");
        var users = [];
        users = data[i]['users'];
        for(var key in users) {
            $("#modal_text").append(users[key]['first_name']+" ");
        }
        $("#modal_text").append("<br><b>QC1:</b> "+data[i]['qc1']+"s");
        if(data[i]['type']!="COUNTS"){
            $("#modal_text").append("<br><b>QC2:</b> "+data[i]['qc2']+"s");
            $("#modal_text").append("<br><b>QC3:</b> "+data[i]['qc3']+"s");
        }

        //$("#modal_text").append(users[users.length-1]['first_name']+"<br>");
        $("#modal_text").append("<hr>");
    }
}
function counts_modal_data() {
    $("#modalsGroup").html("");
    let qc1_modal_string = counts_modal("closedModal1", "Projects in QC1:", "qc1_list");
    let qc2_modal_string = counts_modal("closedModal2", "Projects in QC2:", "qc2_list");
    let qc3_modal_string = counts_modal("closedModal3", "Projects in QC3:", "qc3_list");
    let closed_modal_string = counts_modal("closedModalClosed", "Closed:", "closed_list");
    $("#modalsGroup").html(qc1_modal_string+qc2_modal_string+qc3_modal_string+closed_modal_string);
}

function display_data(data, id) {
    var table_row1="";
    var table_row2="";
    var table_row3="";
    if(data['qc1_projects']>0){
        table_row1+="<tr><td>QC1</td><td>"+data['qc1_projects']+"</td><td>"+data['qc1_avg']+"</td></tr>";
    }else if(data['qc1_projects']==0){
        table_row1+="<tr><td>QC1</td><td>0</td><td>/</td></tr>";
    }
    if(data['qc2_projects']>0){
        table_row2+="<tr><td>QC2</td><td>"+data['qc2_projects']+"</td><td>"+data['qc2_avg']+"</td></tr>";
    }else if(data['qc2_projects']==0){
        table_row2+="<tr><td>QC2</td><td>0</td><td>/</td></tr>";
    }
    if(data['qc3_projects']>0){
        table_row3+="<tr><td>QC3</td><td>"+data['qc3_projects']+"</td><td>"+data['qc3_avg']+"</td></tr>";
    }else if(data['qc3_projects']==0){
        table_row3+="<tr><td>QC3</td><td>0</td><td>/</td></tr>";
    }
    var table_string="<table class='table'><thead>\n" +
        "<tr>\n" +
        "<th>QC</th>\n" +
        "<th>no. of Projects</th>\n" +
        "<th>Average time</th>\n" +
        "</tr>\n" +
        "</thead><tbody>"+table_row1+table_row2+table_row3+"</tbody></table>";
    $("#"+id).append(table_string);
}