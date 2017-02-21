/**
 * Created by sam on 21/02/2017.
 */

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
    // PROJECTS
    //
    Highcharts.chart('createdProjects', {
        chart  : {
            type: 'spline'
        },
        title  : {
            text: 'Projets créés par jour'
        },
        xAxis  : {
            type : 'datetime',
            title: {
                text: 'Date'
            }
        },
        yAxis  : {
            title: {
                text: 'Nombre'
            },
            min  : 0
        },
        tooltip: {
            headerFormat: '<b>{point.x:%d %B %Y}</b><br>',
            pointFormat : '{point.y}'
        },

        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        series: [
            {
                data        : createdProjectsData,
                showInLegend: false
            }
        ],

        colors : [Colors.primary]
    });
});