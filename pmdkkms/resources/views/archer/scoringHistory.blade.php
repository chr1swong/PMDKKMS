<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring History</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .scoring-history-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .scoring-history-header {
            text-align: left;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .membership-id {
            background-color: #E0E0E0;
            padding: 10px;
            border-radius: 8px;
            font-size: 18px;
            max-width: 150px;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .filter-container input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-left: 10px;
        }

        .filter-container button {
            background-color: #555;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-container button:hover {
            background-color: #333;
        }

        .table-container {
            width: 100%;
            margin: 20px auto;
            max-height: 505px; /* Adjust based on row height to fit 8 rows */
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            background-color: white;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #e1e1e1;
        }

        table th {
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        table td {
            background-color: #f9f9f9;
            vertical-align: middle;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            line-height: 1.5;
            text-align: center;
            cursor: pointer;
            width: 120px;
        }

        .btn-view {
            background-color: #5f4bb6;
            color: white;
        }

        .btn-view:hover {
            background-color: #3b1f8b;
        }

        .back-btn {
            background-color: #6f42c1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #5a32a3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .table-container {
                max-height: 300px; /* Adjust for smaller screens */
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.archerHeader') 
</header>

<div class="scoring-history-container">
    <h1 class="scoring-history-header">Scoring History</h1>

    <!-- Membership ID and Filter -->
    <div class="filter-container">
        <div>
            <label for="membership-id">Membership ID</label>
            <div class="membership-id">
                {{ $membership_id }}
            </div>
        </div>

        <div>
            <form action="{{ route('archer.scoringHistory') }}" method="GET">
                <input type="date" name="start-date" id="start-date" value="{{ request('start-date') }}">
                <input type="date" name="end-date" id="end-date" value="{{ request('end-date') }}">
                <button type="submit">Filter</button>
            </form>
        </div>
    </div>

    <!-- Scoring History Table -->
    <div class="table-container">
        <table id="scoringTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">No. <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(1)">Date <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">Category <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Set <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Distance <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(5)">Total Score <i class="fas fa-sort"></i></th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody id="scoring-table">
                @forelse($scoringData as $index => $score)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($score->date)->format('d F Y') }}</td>
                        <td>{{ $score->category }}</td>
                        <td>{{ $score->set }}</td>
                        <td>{{ $score->distance }}M</td>
                        <td>{{ $score->total }}/360</td>
                        <td>
                            <a href="{{ route('scoring.details', $score->id) }}" class="btn btn-view">View Scoring Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No scoring records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $scoringData->links() }}

    <!-- Back Button -->
    <a href="{{ route('archer.scoring') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<script>
    // Sorting function for the table
    function sortTable(n) {
        const table = document.getElementById("scoringTable");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc"; // Set the sorting direction to ascending by default

        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];

                // For dates, convert them to a comparable format
                if (n == 1) { // Column index 1 is for the Date
                    const xDate = new Date(x.innerHTML);
                    const yDate = new Date(y.innerHTML);
                    if (dir == "asc" && xDate > yDate) {
                        shouldSwitch = true;
                        break;
                    } else if (dir == "desc" && xDate < yDate) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    // For other columns, use string comparison
                    if (dir == "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    } else if (dir == "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

</body>
</html>
