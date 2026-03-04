import Chart from 'chart.js/auto';
import 'chartjs-adapter-moment';
import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';

const ctx = document.getElementById('Chart');

document.querySelector('.get-pdf').addEventListener('click', async () => {
    const btn = document.querySelector('.get-pdf');
    btn.textContent = 'Generating...';
    btn.disabled = true;

    const element = document.querySelector('.dashboard-content');

    const canvas = await html2canvas(element, { scale: 2 });
    const imgData = canvas.toDataURL('image/png', 1.0);

    const pdf = new jsPDF('landscape');

    const pageWidth = pdf.internal.pageSize.getWidth();

    // ===== Title =====
    pdf.setFontSize(18);
    pdf.text("Analytics Report", pageWidth / 2, 15, { align: "center" });

    // ===== Generated Date =====
    pdf.setFontSize(10);
    pdf.text(
        "Generated: " + new Date().toLocaleString(),
        pageWidth - 14,
        10,
        { align: "right" }
    );

    // ===== Summary Section =====
    const total = window.chartValues.reduce((a, b) => a + b, 0);
    const avg = (total / window.chartValues.length).toFixed(2);
    const max = Math.max(...window.chartValues);
    const min = Math.min(...window.chartValues);

    pdf.setFontSize(12);
    pdf.text("Summary", 14, 30);

    pdf.setFontSize(11);
    pdf.text(`Total: ${total}`, 14, 38);
    pdf.text(`Average: ${avg}`, 14, 45);
    pdf.text(`Highest: ${max}`, 14, 52);
    pdf.text(`Lowest: ${min}`, 14, 59);

    // ===== Chart =====
    pdf.addImage(imgData, 'PNG', 80, 35, 190, 100);

    // ===== Footer =====
    pdf.setFontSize(9);
    pdf.text(
        "Confidential Report",
        pageWidth / 2,
        200,
        { align: "center" }
    );

    pdf.save("analytics-report.pdf");
});

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
