/**
 * Created by sam on 20/02/2017.
 */

"use strict";

$(document).ready(function ()
{
    var Colors = {
        primary  : '#0000ff',
        secondary: '#f08080'
    };

    // global options
    Highcharts.setOptions({
        lang   : {
            decimalPoint: ','
        },
        credits: {
            enabled: false
        }
    });

    //
    // SEX PIE
    //
    Highcharts.chart('sexPie', {
        chart      : {
            plotBackgroundColor: null,
            plotBorderWidth    : null,
            plotShadow         : false,
            type               : 'pie'
        },
        title      : {
            text: 'sexe des financeurs'
        },
        tooltip    : {
            headerFormat  : '<strong>{point.y}</strong><br/>',
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
        colors     : [ Colors.primary, Colors.secondary ]
    });


    //
    // AGE COLUMNS
    //

    // get total
    var totalCount = 0;
    for (var i = 0, l = ageData.length; i < l; i++)
    {
        var item = ageData[ i ];
        totalCount += item[ 1 ];
    }

    Highcharts.chart('ageChart', {
        chart  : {
            type: 'column'
        },
        title  : {
            text: 'âge des financeurs'
        },
        tooltip: {
            headerFormat  : '<strong>{point.x} ans</strong><br/>',
            pointFormatter: function ()
            {
                var percentage = (this.y / totalCount) * 100;
                return Highcharts.numberFormat(percentage, 1) + '%';
            }
        },
        xAxis  : {
            type : 'category',
            title: {
                text: 'Âge'
            }
        },
        yAxis  : {
            min  : 0,
            title: {
                text: 'Nombre'
            }
        },
        series : [
            {
                data        : ageData,
                showInLegend: false
            }
        ],
        colors : [ Colors.primary ]
    });


    //
    // DEPARTMENTS MAP
    //
    $('#departmentsMap').highcharts('Map', {

        title: {
            text: 'provenance des financeurs'
        },

        mapNavigation: {
            enabled      : true,
            buttonOptions: {
                verticalAlign: 'middle',
                align        : 'right'
            }
        },

        colorAxis: {
            min         : 0,
            minColor    : '#ffffff',
            maxColor    : Colors.primary,
            tickInterval: 1
        },

        tooltip: {
            headerFormat  : '<strong>{point.key}</strong><br/>',
            pointFormatter: function ()
            {
                var percentage = (this.value / totalCount) * 100;
                return Highcharts.numberFormat(percentage, 1) + '%';
            }
        },

        series: [
            {
                data       : departmentData,
                mapData    : Highcharts.maps[ 'countries/fr/fr-all-all' ],
                joinBy     : 'name',
                states     : {
                    hover: {
                        color: Colors.secondary
                    }
                },
                borderColor: '#888888'
            }, {
                name               : 'Separators',
                type               : 'mapline',
                data               : Highcharts.geojson(Highcharts.maps[ 'countries/fr/fr-all-all' ], 'mapline'),
                color              : '#666666',
                showInLegend       : false,
                enableMouseTracking: false
            }
        ]
    });
});
