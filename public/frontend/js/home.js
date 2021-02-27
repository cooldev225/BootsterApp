// Shared Colors Definition
const colors = new Array('#d83d32','#f2a543','#309ad0','#7f4618','#ece3e3','#6ba36a','#0a4409');
var document_table=null;
var documentColumns=[
    {
        field: 'group_name',
        title: lang.group,
        sortable: 'asc',
    },
    {
        field: 'process',
        title: lang.process,
    },
    {
        field: 'due_date',
        title: lang.datetofinish,
        width:120,
        sortable: 'asc',
        template: function(row){
            return getJustDate(row.due_date);
        }
    },
    {
        field: 'business_name',
        title: lang.business,
        autoHide: false,
        sortable: 'asc',
        template: function(row){
            //return '<a data-toggle="modal" data-target="#viewBusinessModal" href="javascript:;" onclick="viewBusinessModal('+row.business_id+');">\
            //'+row.business_first_name+' '+row.business_last_name+'\
            //</a>';
            return row.business_first_name+' '+row.business_last_name;
        }
    },
    {
        field: 'project_name',
        title: lang.project,
    },
];
function datatableInit(){
    document_table=$('#kt_datatable_document').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/document/getDocumentDataTable',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    params:{
                        'is_noticed':1,
                    }
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: false,
            serverSorting: true
        },
        layout: {
            scroll: false,
            footer: false,
            header:true
        },
        sortable: true,
        pagination: true,
        search: {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        },
        columns:documentColumns,
        translate: trans_pagination,
    });
}
var options = {
    series: [44, 55, 13, 43, 22, 43, 22],
    chart: {
        width: 600,
        type: 'pie',
    },
    labels: kinds_of_document,
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 400
            },
            legend: {
                position: 'bottom'
            }
        }
    }],
    colors: colors,
    dataLabels: {
        formatter: function (val, opts) {
            return opts.w.config.series[opts.seriesIndex];
        },
      },
};
jQuery(document).ready(function() {
    var form_data = new FormData();
    //form_data.append('id',id);
    $.ajax({
        url: '/home/getDocumentChartData',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            options.series=new Array(response.length);
            for(var i=0;i<response.length;i++)options.series[i]=response[i];
            var chart = new ApexCharts(document.querySelector('#document_chart'), options);
            chart.render();
        },
        error: function (response) {

        }
    });
    datatableInit();
});
