<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee - Archer Performance Analytics</title>
    
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Chart.js for Data Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
            background-color: #f0f2f5;
            color: #333;
        }

        .analytics-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 25px;
            background-color: #fff;
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
            flex-direction: column;
            gap: 25px;
            margin-top: 30px;
        }

        .card-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        h4 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: 600;
            color: #007bff;
            text-align: center;
        }

        .chart-container {
            margin-top: 30px;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
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
        @include('components.committeeHeader')
    </header>
    <div class="analytics-container">
        <h1 class="analytics-header">Archer Performance Analytics</h1>
        <div class="archer-details">
            <p>Viewing performance for: <strong>{{ $fullName }}</strong></p>
        </div>
        <div class="analytics-summary">
            <div class="card-container">
                <h4>Score Trend Over Time</h4>
                <canvas id="scoreTrendChart"></canvas>
            </div>
            <div class="card-container">
                <h4>Xs and 10s Count Over Time</h4>
                <canvas id="x10CountsChart"></canvas>
            </div>
            <div class="card-container">
                <h4>Average Score per Arrow</h4>
                <canvas id="averageScoreChart"></canvas>
            </div>
            <div class="card-container">
                <h4>Performance Consistency (Lower is better)</h4>
                <canvas id="performanceConsistencyChart"></canvas>
            </div>
            <div class="card-container">
                <h4>Performance per Set Comparison (Average Scores)</h4>
                <canvas id="setPerformanceComparisonChart"></canvas>
            </div>
            <div class="card-container">
                <h4>Hit Zone Distribution</h4>
                <div class="chart-wrapper" style="width: 70%; margin: 0 auto;">
                    <canvas id="hitZoneChart"></canvas>
                </div>
            </div>
            <div class="card-container">
                <h4 id="attendanceTitle">Attendance for Current Month</h4>
                <canvas id="dailyAttendanceChart"></canvas>
            </div>
        </div>
    </div>
    
    <script>
        var currentDate = new Date();
        var monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var currentMonth = monthNames[currentDate.getMonth()];
        document.getElementById('attendanceTitle').textContent = "Attendance for " + currentMonth;

        //Score Trend Over Time
        var ctxScoreTrend = document.getElementById('scoreTrendChart').getContext('2d');
        var scoreTrendChart = new Chart(ctxScoreTrend, {
            type: 'line',
            data: {
                labels: @json($scoreDates),
                datasets: [{
                    label: 'Total Score',
                    data: @json($totalScores),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Date', font: { weight: 'bold' } },
                        grid: { display: false }
                    },
                    y: {
                        title: { display: true, text: 'Score', font: { weight: 'bold' } },
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        beginAtZero: true // Automatically adjust scale
                    }
                }
            }
        });

        // Xs and 10s Count Over Time
        var ctxX10Counts = document.getElementById('x10CountsChart').getContext('2d');
        var x10CountsChart = new Chart(ctxX10Counts, {
            type: 'line',
            data: {
                labels: @json($scoreDates),
                datasets: [
                    {
                        label: 'X Count',
                        data: @json($xCounts),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: '10 Count',
                        data: @json($tenCounts),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Date', font: { weight: 'bold', font: { weight: 'bold' } } },
                        grid: { display: false }
                    },
                    y: {
                        title: { display: true, text: 'Count', font: { weight: 'bold', font: { weight: 'bold' } } },
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        beginAtZero: true
                    }
                }
            }
        });

        // Average Score per Arrow
        var ctxAverageScore = document.getElementById('averageScoreChart').getContext('2d');
        // Create labels for each set
        var setLabels = ["Set 1", "Set 2", "Set 3", "Set 4", "Set 5", "Set 6"];

        // Prepare the data for the chart
        var averageScoreChartData = @json($averageScores);

        // Slice to get only the latest 10 sets
        var latestSetsData = averageScoreChartData.slice(-10); // Get the last 10 records

        // Flatten the nested latestSetsData array and create corresponding labels
        var flattenedScores = [];
        var labels = [];

        latestSetsData.forEach((setAverages, recordIndex) => {
            setAverages.forEach((averageScore, setIndex) => {
                flattenedScores.push(averageScore);
                labels.push(`${setLabels[setIndex]}`); // Remove the (Record *) part
            });
        });

        // Create the chart
        var averageScoreChart = new Chart(ctxAverageScore, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average Score per Arrow',
                    data: flattenedScores,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Set', font: { weight: 'bold' } },
                        grid: { display: false },
                        ticks: {
                            autoSkip: false, // Show all labels
                            maxRotation: 90, // Rotate labels 90 degrees
                            minRotation: 90, // Minimum rotation is 90 degrees
                            padding: 5 // Adjust padding as needed
                        }
                    },
                    y: {
                        title: { display: true, text: 'Score', font: { weight: 'bold' } },
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        beginAtZero: true,
                        suggestedMax: 10 // Optional: Set a max value if needed
                    }
                }
            }
        });

         // Performance Consistency Chart
        var ctxPerformanceConsistency = document.getElementById('performanceConsistencyChart').getContext('2d');
        var performanceConsistencyChart = new Chart(ctxPerformanceConsistency, {
            type: 'bar',
            data: {
                labels: ["Set 1", "Set 2", "Set 3", "Set 4", "Set 5", "Set 6"],
                datasets: [{
                    label: 'Standard Deviation',
                    data: @json($performanceConsistency),
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Set', font: { weight: 'bold' } },
                        grid: { display: false }
                    },
                    y: {
                        title: { display: true, text: 'Standard Deviation', font: { weight: 'bold' } },
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        beginAtZero: true
                    }
                }
            }
        });

        // Set Performance Comparison Chart
        var ctxSetPerformanceComparison = document.getElementById('setPerformanceComparisonChart').getContext('2d');
        var setPerformanceComparisonChart = new Chart(ctxSetPerformanceComparison, {
            type: 'bar',
            data: {
                labels: ["Set 1", "Set 2", "Set 3", "Set 4", "Set 5", "Set 6"],
                datasets: [{
                    label: 'Average Score',
                    data: @json($setPerformanceComparison),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Set', font: { weight: 'bold' } },
                        grid: { display: false }
                    },
                    y: {
                        title: { display: true, text: 'Average Score', font: { weight: 'bold' } },
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        beginAtZero: true,
                        suggestedMax: 10 // Optional: Set a max value if needed
                    }
                }
            }
        });

        // Hit Zone Distribution Chart
        var ctxHitZone = document.getElementById('hitZoneChart').getContext('2d');
        var hitZoneChart = new Chart(ctxHitZone, {
            type: 'pie', // You can change this to 'pie' if you prefer
            data: {
                labels: @json($hitZoneLabels),
                datasets: [{
                    label: 'Hit Zone Distribution',
                    data: @json($hitZoneValues),
                    backgroundColor: [
                        'rgba(204, 153, 0, 0.6)',  // X - Darker Yellow
                        'rgba(255, 204, 0, 0.6)',  // 10 - Normal Yellow
                        'rgba(255, 229, 128, 0.6)', // 9 - Lighter Yellow
                        'rgba(153, 0, 0, 0.6)',    // 8 - Dark Red
                        'rgba(255, 102, 102, 0.6)', // 7 - Lighter Red
                        'rgba(0, 0, 153, 0.6)',    // 6 - Dark Blue
                        'rgba(102, 178, 255, 0.6)', // 5 - Lighter Blue
                        'rgba(0, 0, 0, 0.6)',      // 4 - Black
                        'rgba(128, 128, 128, 0.6)', // 3 - Dark Grey
                        'rgba(192, 192, 192, 0.6)', // 2 - Lighter Grey
                        'rgba(255, 255, 255, 0.6)', // 1 - White
                        'rgba(0, 128, 0, 0.6)'     // Miss - Green
                    ],
                    borderColor: [
                        'rgba(204, 153, 0, 1)',   // X - Darker Yellow
                        'rgba(255, 204, 0, 1)',   // 10 - Normal Yellow
                        'rgba(255, 229, 128, 1)', // 9 - Lighter Yellow
                        'rgba(153, 0, 0, 1)',     // 8 - Dark Red
                        'rgba(255, 102, 102, 1)', // 7 - Lighter Red
                        'rgba(0, 0, 153, 1)',     // 6 - Dark Blue
                        'rgba(102, 178, 255, 1)', // 5 - Lighter Blue
                        'rgba(0, 0, 0, 1)',       // 4 - Black
                        'rgba(128, 128, 128, 1)', // 3 - Dark Grey
                        'rgba(192, 192, 192, 1)', // 2 - Lighter Grey
                        'rgba(0, 0, 0, 1)',       // 1 - White with Black Border
                        'rgba(0, 128, 0, 1)'      // Miss - Green
                    ],
                    borderWidth: [
                        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1 // Increase border width for "1" to make it more visible
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                            }
                        }
                    }
                }
            }
        });

        // Attendance Rate (For current month)
        var ctxDailyAttendance = document.getElementById('dailyAttendanceChart').getContext('2d');
        var dailyAttendanceChart = new Chart(ctxDailyAttendance, {
            type: 'bar',
            data: {
                labels: @json($attendanceDates), // Use attendanceDates for X-axis
                datasets: [{
                    label: 'Present',
                    data: @json($attendanceValues), // Y-axis: 1 for present, 0 for absent
                    backgroundColor: 'rgba(0, 255, 0, 0.5)',
                    borderColor: 'rgba(0, 255, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Date', font: { weight: 'bold' } },
                        grid: { display: false },
                        ticks: {
                            autoSkip: false, // Show all dates
                            maxRotation: 90, // Rotate labels 90 degrees if needed
                            minRotation: 90  // Rotate labels 90 degrees if needed
                        }
                    },
                    y: {
                        title: { display: true, text: 'Attendance', font: { weight: 'bold' } },
                        grid: { color: 'rgba(200, 200, 200, 0.2)' },
                        beginAtZero: true,
                        ticks: {
                            display: false // Hide Y-axis values
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>