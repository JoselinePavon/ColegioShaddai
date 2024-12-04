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
                    .card.yellow { background-color: #1ea49d; }
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



            <div class="dashboard">
                <div class="card blue">
                    <i class="fas fa-users" style="font-size: 50px; color: #333; margin-bottom: 15px;"></i>
                    <h2>Total Alumnos Inscritos</h2>
                    <p>{{ $totalAlumnos }}</p> <!-- Mostrar el total de alumnos -->

                </div>


                <div class="card yellow">
                    <i class="fas fa-exclamation-circle" style="font-size: 50px; color: #333; margin-bottom: 15px;"></i>
                    <h2>Alumnos Insolventes</h2>
                    <p id="insolventes-count">Cargando...</p>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // Recuperar el valor de localStorage
                            const insolventesCount = localStorage.getItem('insolventesCount') || 0;

                            // Mostrar el valor en la tarjeta
                            document.getElementById('insolventes-count').textContent = insolventesCount;
                        });
                    </script>
                </div>

                <div class="card green">
                    <i class="fas fa-dollar-sign" style="font-size: 50px; color: #333; margin-bottom: 15px;"></i>
                    <h2>Total Ingresos</h2>
                    <p>Q. {{ number_format($totalIngresos, 2) }}</p> <!-- Mostrar el total de ingresos -->

                </div>
            </div>


            <!-- Graph section -->

                <div style="flex: 1;">
                    <img src="/imagenes/fondo.png" alt="Income visualization" style="max-width: 100%; height: auto;">
                    <canvas id="incomeChart"></canvas>
                </div>

            </div>



            </body>
            </html>
        </div>
    </div>
    </div>
@endsection

