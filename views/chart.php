
<section class="dinet_chart">
    <header>
        <h2><?= $Chart->getTitle() ?></h2>
    </header>
    <canvas id="myChart" class="statChart"></canvas>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
<script>
    let ctx = document.getElementById("myChart").getContext("2d");
    let myChart = new Chart(ctx, {
        type   : 'line',
        data   : {
            labels : <?= json_encode( $Chart->getXLabels() ); ?>,
            datasets: <?= json_encode( $ChartController->getDataset( $Patient->get_user_id() ) ) ?>
        }
    });
</script>
