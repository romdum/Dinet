let makeToast = function(text, hexColor)
{
    let $toast = jQuery("#dinet_toast");
    $toast.text(text);
    $toast.css("background", hexColor);
    $toast.fadeIn(400).delay(2500).fadeOut(400);
};

let updateChart = function( datasets, labels = null, chartId = 'myChart')
{
    let ctx = document.getElementById(chartId).getContext("2d");
    if( labels === null )
        labels = this[chartId].config.data.labels;

    this[chartId] = new Chart(ctx, {
        type   : 'line',
        data   : {
            labels  : labels,
            datasets: datasets
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
};
