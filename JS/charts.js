//MAKE TREND 
//function resizeIframe(obj){
//    obj.style.height = obj.contentWindow.document.body.offsetHeight + 'px';
//}

$(document).ready(function() {
    if(p1 === p2){
        string = 'P'+p1+'';
    }
    else{
        string = 'P'+p1+'- P'+p2+'';
    }
    
    $('#productPareto').DataTable( {
        scrollY: 500,
        scrollCollapse: true,
        paging: false,
        "bFilter":  false,
        "ordering": false,
        "bInfo": false,
        dom: 'Bfrtip',
        buttons: [
             'excelHtml5'
        ]
    });
    
    $('#example').DataTable( {
        scrollY:400,
        scrollCollapse: true,
        "order":[[ 3, "desc" ]],
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5'
        ]
    } );
} );

//CHART DPPM TREND BY PERIOD
$(function () {
        $('#container1').highcharts({
        chart: {
            Type: 'column'
        },
        credits:{
          enabled: false  
        },
        title: {
            text: 'Trend By Period'
        },
        subtitle:{
            text: string
        },
        xAxis: [{
            categories: period,
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            min: 0,
            title: {
                text: 'DPPM'
            },
            labels:{
                format: '{value} DPPM'
            }
        }, { // Secondary yAxis
           visible: false 
        }],
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:1f} DPPM</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column:{
                pointPadding: 0.2,
                borderWidth: 0 
            }
        },
        series: [{
            name: 'DPPM',
            type: 'column',
            data: dppm,
            dataLabels:{
                enabled: true,
                rotation: 0,
                color: '#000000',
                align: 'center',
                verticalAlign: 'top',
                format: '{y}', // one decimal
                y: 0 // 5 pixels down from the top
            }
        }, {
            name: 'Goal',
            color: '#32CD32',
            type: 'spline',
            data: goal,
        }],
        lang:{
            noData: "No data to display"
        },
        noData:{
            style:{
                fontWeight: 'bold',
                fontSize: '15px',
                color: '#303030'
            }
        },
        exporting: {
            filename: 'TREND'
        }
    });
});

//CHART DPPM PARETO BY CODES
$(function () {
        $('#container2').highcharts({
        chart: {
            Type: 'xy'
        },
        credits:{
          enabled: false  
        },
        title: {
            text: 'Pareto By Code'
        },
        subtitle:{
            text: string
        },
        xAxis: [{
            categories:code,
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            min: 0,
            title: {
                text: 'DPPM'
            },
            labels:{
                format: ' {value} DPPM'
            }
        }, { // Secondary yAxis
           min: 0,
           title:{
               text: '%'
           },
           labels:{
               format: ' {value} % '
           },
           max: 100,
           opposite: true
        }],
        tooltip: {
            shared: true
        },
        plotOptions: {
            colum:{
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'DPPM',
            type: 'column',
            data: dppm_pareto,
            dataLabels:{
                enabled: true,
                rotation: 0,
                color: '#000000',
                align: 'center',
                verticalAlign: 'top',
                format: '{y}', // one decimal
                y: 0 // 5 pixels down from the top
            }
        }, {
            name: 'Pareto',
            type: 'spline',
            data: pareto,
            color: '#FFA500',
            tooltip: {
                valueSuffix: ' %'
            },
            yAxis: 1
        }],
        lang:{
            noData: "No data to display"
        },
        noData:{
            style:{
                fontWeight: 'bold',
                fontSize: '15px',
                color: '#303030'
            }
        },
        exporting: {
            filename: 'PARETO'
        }
    });
});

//INDEX.PHP POPUP 
$('.iframe-link').magnificPopup({
    type: 'iframe',
    iframe: {
        markup: '<iframe width="853" height="480" src="http://amexccp.steelcase.net/AmexDashboard/index.php" frameborder="0" allowfullscreen></iframe>'
    }   
 });
