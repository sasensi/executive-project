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
            contextButtonTitle    : "Menu contextuel",
            decimalPoint          : ",",
            downloadJPEG          : "Télécharger une image JPEG",
            downloadPDF           : "Télécharger un document PDF",
            downloadPNG           : "Télécharger une image PNG",
            downloadSVG           : "Télécharger une image vectorielle SVG",
            drillUpText           : "Revenir à {series.name}",
            invalidDate           : 'Date invalide',
            loading               : "Chargement...",
            months                : [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre" ],
            noData                : "Aucune données",
            numericSymbolMagnitude: 1000,
            numericSymbols        : [ "k", "M", "G", "T", "P", "E" ],
            printChart            : "Imprimer",
            resetZoom             : "Réinitialiser le zoom",
            resetZoomTitle        : "Réinitialiser le zoom niveau 1:1",
            shortMonths           : [ "Jan", "Fév", "Mar", "Avr", "Mai", "Ju", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc" ],
            shortWeekdays         : [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
            thousandsSep          : " ",
            weekdays              : [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ]
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
            type: 'column'
        },
        title  : {
            text: 'nombre de projets et financements par jour'
        },
        tooltip: {
            headerFormat: '<strong>{point.x:%d %B %Y}</strong>',
            pointFormat : '<div><strong style="color:{series.color};">{point.y}</strong> {series.name}</div>',
            shared      : true,
            useHTML     : true
        },
        xAxis  : {
            type : 'datetime',
            title: {
                text: 'Date'
            },
            max  : Date.now()
        },
        yAxis  : {
            min  : 0,
            title: {
                text: 'Nombre'
            }
        },
        series : [
            {
                name: 'projets',
                data: createdProjectsData
            },
            {
                name: 'financements',
                data: transactionsData
            }
        ],
        colors : [ Colors.primary, Colors.secondary ]
    });


    //
    // TRANSACTIONS AMOUNT
    //
    Highcharts.chart('transactionsAmount', {
        title  : {
            text: 'cumul des financements'
        },
        xAxis  : {
            type : 'datetime',
            title: {
                text: 'Date'
            },
            max  : Date.now()
        },
        yAxis  : {
            min  : 0,
            title: {
                text: 'Montant'
            }
        },
        tooltip: {
            headerFormat: '<strong>{point.x:%d %B %Y}</strong><br/>',
            pointFormat : '{point.y} €'
        },
        series : [
            {
                data        : transactionsAmountData,
                showInLegend: false
            }
        ],
        colors : [ Colors.secondary ]
    });


    //
    // STATUS PIE
    //

    Highcharts.chart('status', {
        chart      : {
            type: 'pie'
        },
        title      : {
            text: 'statut des projets'
        },
        tooltip    : {
            headerFormat: '',
            pointFormat : '{point.percentage:.1f}%'
        },
        series     : [
            {
                colorByPoint: true,
                data        : statusData
            }
        ],
        colors     : [ Colors.primary, Colors.secondary, '#333333' ]
    });
});