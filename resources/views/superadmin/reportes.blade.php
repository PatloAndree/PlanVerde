@extends('template.template')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />
<link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('css/apex-charts.css') }}" />
@endsection
@section('content')
    <div class="card card-action" id="divReporteIngreso">
        <div class="card-header">
            <h5 class="card-action-title mb-0">Reporte de ingresos</h5>
            <div class="card-action-element">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <input type="text" class="form-control" id="rangeReporteIngreso" name="rangeReporteIngreso" required>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" id="loadReporteIngreso" class="btn btn-primary">Generar</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div id="chartIngreso"></div>
          </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('js/apexcharts.js') }}"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>
@endsection
@section('implemetenciones')
    <script>
        let chartIngreso = null;
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        /*RANGO INGRESOS INICIO */
        const rangeReporteIngreso = document.querySelector('#rangeReporteIngreso');
        rangeReporteIngreso.flatpickr({
            mode: 'range',
            dateFormat: 'd/m/Y',
            locale: 'es',
            defaultDate: [
                firstDay, // Pasar objetos Date directamente a defaultDate
                lastDay
            ]
        });
        /*RANGO INGRESOS FIN */
        /*CHART INGRESOS INICIO */
        /*CHART INGRESOS FIN */

        async function getDataChartIngreso(){
            const date = document.querySelector('#rangeReporteIngreso').value;
            if (chartIngreso) {
                console.log(chartIngreso);
                chartIngreso.destroy();
            }
            try{
                $("#divReporteIngreso").waitMe({
                    effect: "win8_linear",
                    bg: "rgba(255,255,255,0.9)",
                    color: "#000",
                    textPos: "vertical",
                    fontSize: "250px",
                });
                const response = await fetch('{{ route("reportes.dataIngreso") }}', {
                    method: 'POST',
                    body: JSON.stringify({ date }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                const responseData = await response.json();

                if (responseData.success) {
                    const { dates, pagados, pendientes } = responseData.data;
                    const pagadosData = pagados.map((item, index) => ({
                        x: dates[index],
                        y: item.monto,
                        cantidad: item.cantidad
                    }));

                    const pendientesData = pendientes.map((item, index) => ({
                        x: dates[index],
                        y: item.monto,
                        cantidad: item.cantidad
                    }));
                    const options = {
                        chart: {
                            type: 'area',
                            height: 400,
                            zoom: {
                                enabled: false
                            }
                        },
                        series: [
                            {
                                name: 'Pagados (Monto)',
                                data: pagadosData
                            },
                            {
                                name: 'Pendientes (Monto)',
                                data: pendientesData
                            }
                        ],
                        xaxis: {
                            categories: dates,
                            title: {
                                text: 'Fecha'
                            }
                        },
                        colors: ['#28a745', '#dc3545'],
                        title: {
                            text: 'Estado de Pagos',
                            align: 'center',
                            style: {
                                fontSize: '20px',
                                color: '#333'
                            }
                        },
                        legend: {
                            position: 'top'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        tooltip: {
                            shared: true,
                            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                                const data = w.config.series[seriesIndex].data[dataPointIndex];
                                return `
                                    <div style="padding: 8px; background: #fff; border: 1px solid #ccc;">
                                        <strong>${data.x}</strong><br>
                                        <span style="color: ${seriesIndex === 0 ? '#28a745' : '#dc3545'};">
                                            ${seriesIndex === 0 ? 'Pagados' : 'Pendientes'}:
                                        </span> S/. ${data.y}<br>
                                        Cantidad: ${data.cantidad}
                                    </div>
                                `;
                            }
                        }
                    };
                    chartIngreso = new ApexCharts(document.querySelector("#chartIngreso"), options);
                    chartIngreso.render();
                    $('#divReporteIngreso').waitMe("hide");
                }else{

                    document.querySelector("#chartIngreso").innerHTML = '<p>No hay datos disponibles para el rango seleccionado.</p>';
                    $('#divReporteIngreso').waitMe("hide");
                }
            } catch (error) {
                console.error('Error al obtener los datos:', error);
                $('#divReporteIngreso').waitMe("hide");
            }
        }

        document.getElementById('loadReporteIngreso').addEventListener('click', async function() {
            await getDataChartIngreso();
        })

    </script>
@endsection
