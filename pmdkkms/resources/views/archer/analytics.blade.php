<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Performance Analytics</title>
    
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Chart.js for Data Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        .analytics-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 25px;
            background-color: grey;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .analytics-header {
            background-color: #e8f4fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            color: #000; 
            letter-spacing: 1px;
        }

        .analytics-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            text-align: center;
            margin-top: 30px;
        }

        .analytics-summary div {
            background-color: #f0f2f5;
            padding: 20px;
            border-radius: 10px;
            font-size: 20px;
            font-weight: 500;
            color: #4a4a4a;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .analytics-summary div:hover {
            background-color: #e9ecef;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            margin-top: 30px;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .chart-container h2 {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #007bff;
            text-align: center;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .analytics-summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        @include('components.archerHeader')
    </header>

    <div class="analytics-container">
        <div class="analytics-header">
            {{ $archerName }}'s Performance Analytics
        </div>

        <!-- Analytics Summary Section -->
        <div class="analytics-summary">
            <div>
                <strong>Total Attendance Days:</strong> <br> {{ $totalAttendanceDays }}
            </div>
            <div>
                <strong>Present Days:</strong> <br> {{ $presentDays }}
            </div>
            <div>
                <strong>Attendance Percentage:</strong> <br> {{ round($attendancePercentage, 2) }}%
            </div>
        </div>

        <div class="analytics-summary">
            <div>
                <strong>Average Score:</strong> <br> {{ round($averageScore, 2) }}
            </div>
            <div>
                <strong>Total Events:</strong> <br> {{ $scoreData->count() }}
            </div>
        </div>

        <!-- Scoring Chart Section -->
        <div class="chart-container">
            <h2>Score Trend Over Time</h2>
            <canvas id="scoreChart" width="400" height="200"></canvas>
        </div>

        <!-- Attendance vs Score Correlation -->
        <div class="chart-container">
            <h2>Attendance vs Score Correlation</h2>
            <canvas id="attendanceScoreChart" width="400" height="200"></canvas>
        </div>

        <!-- Attendance Summary -->
        <div class="chart-container">
            <h2>Attendance Summary</h2>
            <canvas id="attendanceSummaryChart" width="400" height="200"></canvas>
        </div>

        <!-- Score Distribution -->
        <div class="chart-container">
            <h2>Score Distribution</h2>
            <canvas id="scoreDistributionChart" width="400" height="200"></canvas>
        </div>

    </div>

    <script>
        // Scoring data passed from the controller
        var scoreData = @json($scoreData);
        var attendanceData = @json($attendanceData);

        // Chart 1: Score Trend Over Time
        document.addEventListener('DOMContentLoaded', function () {
            var ctx1 = document.getElementById('scoreChart').getContext('2d');
            var scoreChart = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: scoreData.map(data => data.date), // Using raw dates directly
                    datasets: [{
                        label: 'Scores Over Time',
                        data: scoreData.map(data => data.total), // Total scores
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Score'
                            }
                        }
                    }
                }
            });
        });

        // Chart 2: Attendance vs Score Correlation (Scatter Plot)
        document.addEventListener('DOMContentLoaded', function () {
            var ctx2 = document.getElementById('attendanceScoreChart').getContext('2d');
            var attendanceScoreChart = new Chart(ctx2, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Attendance vs Score',
                        data: scoreData.map((score, index) => ({
                            x: index + 1, // Simulating days present, assuming order corresponds with scoreData
                            y: score.total // Scores
                        })),
                        backgroundColor: 'rgba(255, 99, 132, 1)'
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Days Present'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Score'
                            }
                        }
                    }
                }
            });
        });

        // Chart 3: Attendance Summary (Bar Chart)
        document.addEventListener('DOMContentLoaded', function () {
            var ctx3 = document.getElementById('attendanceSummaryChart').getContext('2d');
            var attendanceSummaryChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['Total Days', 'Present', 'Absent'],
                    datasets: [{
                        label: 'Attendance Summary',
                        data: [{{ $totalAttendanceDays }}, {{ $presentDays }}, {{ $totalAttendanceDays - $presentDays }}],
                        backgroundColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ]
                    }]
                }
            });
        });

        // Chart 4: Score Distribution (Histogram)
        document.addEventListener('DOMContentLoaded', function () {
            var ctx4 = document.getElementById('scoreDistributionChart').getContext('2d');
            var scoreDistributionChart = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: ['0-60', '61-120', '121-180', '181-240', '241-300', '301-360'],
                    datasets: [{
                        label: 'Score Distribution',
                        data: [
                            scoreData.filter(score => score.total <= 60).length,
                            scoreData.filter(score => score.total > 60 && score.total <= 120).length,
                            scoreData.filter(score => score.total > 120 && score.total <= 180).length,
                            scoreData.filter(score => score.total > 180 && score.total <= 240).length,
                            scoreData.filter(score => score.total > 240 && score.total <= 300).length,
                            scoreData.filter(score => score.total > 300 && score.total <= 360).length
                        ],
                        backgroundColor: 'rgba(153, 102, 255, 1)'
                    }]
                }
            });
        });
    </script>
</body>
</html>
