/**
 * Created by sam on 20/02/2017.
 */

"use strict";

$(document).ready(function ()
{
    var Colors = {
        primary: '#0000ff',
        secondary: '#f08080'
    };

    //
    // SEX PIE
    //
    var pie = Highcharts.chart('sexPie', {
        chart      : {
            plotBackgroundColor: null,
            plotBorderWidth    : null,
            plotShadow         : false,
            type               : 'pie',
            events             : {
                load: function (event)
                {
                    $(window).trigger('resize');
                }
            }
        },
        title      : {
            text: 'Sexe des financeurs'
        },
        tooltip    : {
            pointFormat: '{point.percentage:.1f}%'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor          : 'pointer'
            }
        },
        series     : [
            {
                name        : 'Financeurs',
                colorByPoint: true,
                data        : sexPieData
            }
        ],
        credits    : {
            enabled: false
        },
        exporting  : {
            enabled: false
        },
        colors: [Colors.primary, Colors.secondary]
    });
});
