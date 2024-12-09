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
            overflow-x: hidden;
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
            max-height: 505px;
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

        /* Back Button Styling */
        .back-btn {
            background-color: #5f4bb6;  /* Purple background to match the theme */
            color: white;  /* White text */
            padding: 10px 20px;  /* Padding for a larger, clickable area */
            text-decoration: none;  /* Remove underline */
            border-radius: 5px;  /* Rounded corners */
            font-weight: 600;  /* Slightly bolder text */
            transition: background-color 0.3s ease;  /* Smooth hover transition */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Subtle shadow for depth */
        }

        /* Back Button Hover Effect */
        .back-btn:hover {
            background-color: #4831a6;  /* Darker shade on hover */
            text-decoration: none;  /* Keep text-decoration off during hover */
            color: white;  /* Ensure white text on hover */
        }

        /* Success message styling */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 30px;
            font-weight: bold;
            color: #155724;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #0c3d20;
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
                max-height: 300px;
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.coachHeader')
</header>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
        <button class="close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<div class="scoring-history-container">
    <h1 class="scoring-history-header">Scoring History of {{ $archerName }}</h1>

    <!-- Membership ID and Filter -->
    <div class="filter-container">
        <div>
            <label for="membership-id">Membership ID</label>
            <div class="membership-id">
                {{ $membership_id }}
            </div>
        </div>

        <div>
            <form action="{{ route('coach.scoringHistoryArcher', $membership_id) }}" method="GET">
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
                <th>No.</th>
                <th onclick="sortTable(1)" onkeydown="if(event.key === 'Enter' || event.key === ' ') sortTable(1);" tabindex="0">
                    Date <i class="fas fa-sort"></i>
                </th>
                <th onclick="sortTable(2)" onkeydown="if(event.key === 'Enter' || event.key === ' ') sortTable(2);" tabindex="0">
                    Distance <i class="fas fa-sort"></i>
                </th>
                <th onclick="sortTable(3)" onkeydown="if(event.key === 'Enter' || event.key === ' ') sortTable(3);" tabindex="0">
                    Total Score <i class="fas fa-sort"></i>
                </th>
                <th>Performance</th>
            </tr>
            </thead>
            <tbody id="scoring-table">
                @forelse($scoringData as $score)
                    <tr>
                        <td></td> <!-- Leave this empty; we'll populate it with JavaScript -->
                        <td>{{ \Carbon\Carbon::parse($score->date)->format('d F Y') }}</td>
                        <td>{{ $score->distance }}M</td>
                        <td>{{ $score->overall_total }}/360</td>
                        <td>
                            <a href="{{ route('coach.scoringDetails', ['id' => $score->id, 'referrer' => 'scoringHistory']) }}"
                            class="btn btn-view">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No scoring records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
    <a href="{{ route('coach.myArcher') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<script>
    function updateTableIndexes() {
        const table = document.getElementById('scoringTable');
        const rows = table.querySelectorAll('tbody tr'); // Only select rows inside the tbody

        // Initialize index counter for visible rows
        let visibleIndex = 1;
        rows.forEach((row) => {
            if (row.style.display !== 'none') { // Check if row is visible
                row.cells[0].textContent = visibleIndex++; // Update the first cell with the correct index
            }
        });
    }

    function sortTable(columnIndex) {
        const table = document.getElementById('scoringTable');
        const tbody = table.querySelector('tbody');
        const rowsArray = Array.from(tbody.rows); // Convert rows to an array
        let direction = table.dataset.sortDirection === 'asc' ? 'desc' : 'asc'; // Toggle sort direction
        table.dataset.sortDirection = direction; // Store the new sort direction

        // Sorting logic
        rowsArray.sort((rowA, rowB) => {
            let cellA = rowA.cells[columnIndex].textContent.trim();
            let cellB = rowB.cells[columnIndex].textContent.trim();

            // Handle date sorting
            if (columnIndex === 1) {
                cellA = new Date(cellA);
                cellB = new Date(cellB);
                return direction === 'asc' ? cellA - cellB : cellB - cellA;
            }
            
            // Handle numeric sorting
            if (columnIndex === 2 || columnIndex === 3) {
                cellA = parseInt(cellA.replace(/[^0-9]/g, ''), 10); // Remove non-numeric characters
                cellB = parseInt(cellB.replace(/[^0-9]/g, ''), 10); // Remove non-numeric characters
                return direction === 'asc' ? cellA - cellB : cellB - cellA;
            }

            // Handle string sorting (for performance or other columns)
            return direction === 'asc'
                ? cellA.localeCompare(cellB)
                : cellB.localeCompare(cellA);
        });

        // Rebuild the tbody with sorted rows
        rowsArray.forEach((row) => tbody.appendChild(row));

        // Recalculate indexes after sorting
        updateTableIndexes();
    }

    // Call updateTableIndexes on page load
    window.onload = updateTableIndexes;



</script>

</body>
</html>
