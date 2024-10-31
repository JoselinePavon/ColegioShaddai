@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title> Dashboard </title>
                <style>
                    /* General styling */
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        background-color: #f7f8fc;
                        color: #333;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                        padding: 40px;
                    }

                    .header {
                        font-size: 32px;
                        font-weight: bold;
                        margin-bottom: 30px;
                        color: #333;
                    }

                    /* Dashboard card styling */
                    .dashboard {
                        display: flex;
                        gap: 20px;
                        margin-bottom: 30px;
                        width: 100%;
                        justify-content: center;
                    }

                    .card {
                        flex: 1;
                        max-width: 300px;
                        padding: 20px;
                        border-radius: 8px;
                        background-color: #fff;
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }

                    .card img {
                        width: 50px;
                        height: 50px;
                        margin-bottom: 15px;
                    }

                    .card h2 {
                        font-size: 20px;
                        margin: 0;
                        color: #333;
                    }

                    .card p {
                        font-size: 24px;
                        font-weight: bold;
                        margin: 10px 0;
                    }

                    .card small {
                        font-size: 14px;
                        color: #666;
                    }

                    /* Specific colors for cards */
                    .card.blue { background-color: #fcae11; }
                    .card.yellow { background-color: #2b34c6; }
                    .card.green { background-color: #97e8ff; }

                    /* Graph container styling */
                    .graph-container {
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                        padding: 20px;
                        width: 100%;
                        max-width: 900px;
                    }

                    .graph-header {
                        font-size: 20px;
                        font-weight: bold;
                        color: #333;
                        margin-bottom: 15px;
                        text-align: center;
                    }
                </style>
            </head>
            <body>



            <!-- Dashboard cards -->
            <div class="dashboard">
                <div class="card blue">
                    <i class="fas fa-users" style="font-size: 50px; color: #333; margin-bottom: 15px;"></i>
                    <h2>Total Alumnos Inscritos</h2>
                    <p></p>
                </div>


                <div class="card yellow">
                    <i class="fas fa-exclamation-circle" style="font-size: 50px; color: #333; margin-bottom: 15px;"></i>
                    <h2>Alumnos Insolventes</h2>
                    <p>150</p>

                </div>
                <div class="card green">
                    <i class="fas fa-dollar-sign" style="font-size: 50px; color: #333; margin-bottom: 15px;"></i>
                    <h2>Total Ingresos</h2>
                    <p>$43,000</p>

                </div>
            </div>

            <!-- Graph section -->
            <div class="graph-container" style="width: 100%; margin: auto; padding: 20px;">
                <div class="graph-header" style="text-align: center; font-size: 24px; font-weight: bold; color: #333;">Ingresos Mensuales</div>
                <canvas id="incomeChart"></canvas>
            </div>

            <!-- Chart.js Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('incomeChart').getContext('2d');
                const incomeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                            'Octubre', 'Noviembre', 'Diciembre'],
                        datasets: [{
                            label: 'Ingresos ($)',
                            data: [5000, 7000, 8000, 5500, 9000, 10000, 5000, 4000, 3000, 5888, 1000, 2000],
                            backgroundColor: 'rgb(48, 196, 201,0.5)', // Color azul con 50% de transparencia
                            borderColor: 'rgba(7, 4, 214, 1)', // Color de borde (opaco)
                            borderWidth: 1,
                            // Para eliminar las líneas entre las barras, se desactiva el borde de las barras
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Meses',
                                    color: '#333',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                },
                                ticks: {
                                    color: '#333',
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Ingresos en $',
                                    color: '#333',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                },
                                ticks: {
                                    color: '#333',
                                }
                            }
                        }
                    }
                });
            </script>

            <style>
                /* Estilos generales para la gráfica */
                .graph-container {
                    background-color: #f8f9fa;
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                canvas {
                    max-height: 400px; /* Ajusta la altura máxima de la gráfica */
                }
            </style>


            </body>
            </html>
        </div>
    </div>
    </div>
@endsection

