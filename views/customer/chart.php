<main>
    <section class="dinet_chart">
        <header>
            <h2>Ma consommation mensuel</h2>
        </header>
        <canvas id="myChart" class="statChart"></canvas>
    </section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
<script>
    Date.prototype.getWeek = function(start)
    {
        //Calcing the starting point
        start = start+1 || 1;
        var today = new Date(this.setHours(0, 0, 0, 0));
        var day = today.getDay() - start;
        var date = today.getDate() - day;

        // Grabbing Start/End Dates
        var StartDate = new Date(today.setDate(date));
        var EndDate = new Date(today.setDate(date + 6));
        return [StartDate, EndDate];
    };

    let ctx = document.getElementById("myChart").getContext("2d");
    let dates = [new Date().getWeek(-21), new Date().getWeek(-14), new Date().getWeek(-7), new Date().getWeek()];
    let myChart = new Chart(ctx, {
        type   : 'line',
        data   : {
            labels  :  [
                "du " +[dates[0][0].getDate()+" au "+dates[0][1].getDate()],
                "du " +[dates[1][0].getDate()+" au "+dates[1][1].getDate()],
                "du " +[dates[2][0].getDate()+" au "+dates[2][1].getDate()],
                "du " +[dates[3][0].getDate()+" au "+dates[3][1].getDate()]
            ],
            datasets: <?= json_encode( ChartController::getDataset() ) ?>
        }
    });
</script>
