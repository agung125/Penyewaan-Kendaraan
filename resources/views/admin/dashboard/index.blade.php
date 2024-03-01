@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="card text-white">
            <div class="card-body">
                <canvas id="bar-chart" width="800" height="450"></canvas>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var kendaraan = @json($kendaraan);
    var datasets = [];

    kendaraan.forEach(k => {
        var label = k.komentar;
        var data = [k.selisih_hari];
        var backgroundColor = (k.selisih_hari <= 2) ? "#ff0000" : "#3e95cd";

        datasets.push({
            label: label,
            backgroundColor: backgroundColor,
            borderWidth: 1,
            data: data
        });
    });

    var chartData = {
        labels: ["Jadwal (Service)"],
        datasets: datasets
    };

    var options = {
        legend: { display: true },
        title: {
            display: true,
            text: 'Kondisi Kendaraan'
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: '#ffffff'
                },
                gridLines: {
                    color: '#ffffff'
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: '#ffffff'
                },
                gridLines: {
                    color: '#ffffff'
                }
            }]
        }
    };

    var ctx = document.getElementById("bar-chart").getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: options
    });
</script>



@endsection
