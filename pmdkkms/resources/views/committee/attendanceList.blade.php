<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Archer Attendance</title>
    <!-- External CSS and Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 40px auto;
        }

        h1 {
            text-align: left;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .filter-search-container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;
            gap: 20px;
            margin-top: 10px;
        }

        .filter-container {
            display: inline-block;
            padding-left: 60px;
        }

        .filter-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .filter-container select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
        }

        .search-container input {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            color: #aaa;
        }

        .search-wrapper input {
            padding: 10px 10px 10px 35px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
        }

        .table-container {
            width: 90%;
            margin: 20px auto;
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

        .attendance-summary {
            color: #333;
            font-weight: bold;
        }

        .btn-container {
            display: flex;
            justify-content: center;
        }

        /* Adjust for mobile responsiveness */
        @media (max-width: 768px) {
            .filter-search-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        @include('components.committeeHeader')
    </header>
    
    <div class="container">
        <h1>Archer Attendance for {{ $filterMonth }}</h1>
        
        <div class="filter-search-container">
            <div class="filter-container">
                <label for="attendance-filter">Filter by Month</label>
                <form method="GET" action="{{ route('committee.attendanceList') }}">
                    <select id="attendance-filter" name="attendance-filter" onchange="this.form.submit()">
                        <option value="January" {{ request('attendance-filter') == 'January' ? 'selected' : '' }}>January</option>
                        <option value="February" {{ request('attendance-filter') == 'February' ? 'selected' : '' }}>February</option>
                        <option value="March" {{ request('attendance-filter') == 'March' ? 'selected' : '' }}>March</option>
                        <option value="April" {{ request('attendance-filter') == 'April' ? 'selected' : '' }}>April</option>
                        <option value="May" {{ request('attendance-filter') == 'May' ? 'selected' : '' }}>May</option>
                        <option value="June" {{ request('attendance-filter') == 'June' ? 'selected' : '' }}>June</option>
                        <option value="July" {{ request('attendance-filter') == 'July' ? 'selected' : '' }}>July</option>
                        <option value="August" {{ request('attendance-filter') == 'August' ? 'selected' : '' }}>August</option>
                        <option value="September" {{ request('attendance-filter') == 'September' ? 'selected' : '' }}>September</option>
                        <option value="October" {{ request('attendance-filter') == 'October' ? 'selected' : '' }}>October</option>
                        <option value="November" {{ request('attendance-filter') == 'November' ? 'selected' : '' }}>November</option>
                        <option value="December" {{ request('attendance-filter') == 'December' ? 'selected' : '' }}>December</option>
                    </select>
                </form>
            </div>

            <div class="search-container">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name..">
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th onclick="sortTable(0, 'num')">No. <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(1, 'alpha')">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2, 'num')">MemberID <i class="fas fa-sort"></i></th>
                    <th>Coach</th>
                    <th onclick="sortTable(4, 'attendance')">Attendance <i class="fas fa-sort"></i></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="attendance-table">
                @foreach($attendanceSummary as $key => $summary)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $summary['membership']->account->account_full_name }}</td>
                    <td>{{ $summary['membership']->membership_id }}</td>
                    <td>{{ $summary['membership']->coach_name ?? 'N/A' }}</td>
                    <td><span class="attendance-summary">{{ $summary['presentCount'] }}/{{ $summary['daysInMonth'] }}</span></td>
                    <td>
                        <div class="btn-container">
                            <a href="#" class="btn btn-view">View Attendance Details</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function searchByName() {
            const input = document.getElementById("search-input").value.toLowerCase();
            const rows = document.querySelectorAll('#attendance-table tr');

            rows.forEach(function (row) {
                const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                // Check if the name includes the input value
                if (name.indexOf(input) > -1) {
                    row.style.display = '';  // Show the row if it matches
                } else {
                    row.style.display = 'none';  // Hide the row if it doesn't match
                }
            });
        }

        // Function to sort the table
        function sortTable(n, type) {
            const table = document.querySelector("table");
            let rows = Array.from(table.rows).slice(1); // Get all rows except the header row
            let dir = table.getAttribute("data-sort-dir") || "asc"; // Get current sort direction, default to asc

            rows.sort((rowA, rowB) => {
                let x = rowA.getElementsByTagName("TD")[n].innerText.toLowerCase();
                let y = rowB.getElementsByTagName("TD")[n].innerText.toLowerCase();
                
                if (type === 'alpha') {
                    if (x < y) return dir === "asc" ? -1 : 1;
                    if (x > y) return dir === "asc" ? 1 : -1;
                } else if (type === 'num' || type === 'attendance') {
                    x = parseInt(x);
                    y = parseInt(y);
                    return dir === "asc" ? x - y : y - x;
                }
                return 0;
            });

            // Toggle sort direction
            table.setAttribute("data-sort-dir", dir === "asc" ? "desc" : "asc");

            // Append sorted rows back to the table
            rows.forEach(row => table.appendChild(row));
        }
    </script>
</body>
</html>
