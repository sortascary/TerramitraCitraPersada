import Chart from 'chart.js/auto';
import 'chartjs-adapter-moment';

const ctx = document.getElementById('Chart');

if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: window.chartLabels,
            datasets: [{
                label: window.chartLabelName,
                data: window.chartValues,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display:false
                }
            },
            scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    stepSize: 1
                }
            },
            y: {
                beginAtZero: true,
                suggestedMax: 10   
            }
        }
        }
    });
}
