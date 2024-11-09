<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Archer</title>
    <!-- External CSS and Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            overflow-x: hidden; 
            padding: 20px;
        }

        .archer-container {
            max-width: 1500px;
            margin: 40px auto;
            background-color: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .archer-header {
            text-align: left;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hr-divider {
            border: none;
            border-top: 2px solid #e0e0e0; /* Customize the color and thickness */
            margin: 10px 0; /* Adjust spacing */
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
            margin-top: 40px;
            margin-bottom: 5px;
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
            position: relative; /* Allow relative positioning of the sort icons */
            background-color: #333;
            color: white;
            cursor: pointer;
            padding-right: 25px; /* Add space to accommodate the icon */
        }

        table th i {
            position: absolute;
            right: 10px; /* Adjust position as needed */
            top: 50%;
            transform: translateY(-50%);
            color: #ddd; /* Adjust color to make it subtle */
        }

        table td {
            background-color: #f9f9f9;
            vertical-align: middle;
        }

        .btn {
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            width: 120px; /* Ensure the width is consistent for all buttons */
            display: inline-block; /* This will help align the buttons */
            line-height: 1.5; /* Adjust line-height if needed for uniform height */
        }

        .btn {
            white-space: nowrap; /* Prevent text from wrapping */
        }

        .btn-view {
            background-color: #5f4bb6;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 5px;
        }

        .btn-unenroll {
            background-color: #ff4d4d;
            color: white;
        }

        .btn-enroll {
            background-color: #28a745;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
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

        /* Responsive adjustments for small screens */
        @media (max-width: 768px) {
            /* Adjust table layout */
            .table-container {
                overflow-x: auto;
            }

            table, thead, tbody, th, td, tr {
                display: block; /* Make table elements block to stack them */
            }

            thead tr {
                display: none; /* Hide table headers on small screens */
            }

            tbody tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 10px;
                background-color: #fff;
            }

            td {
                padding: 10px 5px;
                text-align: left;
                position: relative;
                border: none; /* Remove borders on small screens */
                word-wrap: break-word; /* Allow text to wrap */
            }

            /* Label styling */
            td::before {
                content: attr(data-label);
                font-weight: 600;
                text-transform: capitalize;
                color: #555;
                display: block;
                margin-bottom: 5px;
            }

            /* Adjust button layout */
            .btn-container {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .btn {
                width: 100%; /* Full-width buttons */
                box-sizing: border-box; /* Include padding and border in width calculation */
                margin: 0; /* Remove extra margins */
                padding: 8px 10px; /* Adjust padding to fit better */
            }
        }


        /* Medium screen adjustments */
        @media (max-width: 1024px) {
            .archer-container {
                padding: 30px;
            }

            .btn-container {
                gap: 5px; /* Reduce space between buttons */
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.coachHeader') 
</header>

@if(session('popupMessage'))
    <div class="alert-success">
        {{ session('popupMessage') }}
        <button class="close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<div class="archer-container">
    <h1 class="archer-header">My Archers</h1>
    <hr class="hr-divider">

    <!-- Search Bar -->
    <div class="filter-container">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name...">
        </div>
    </div>

    <!-- Archers Table -->
    <div class="table-container">
        <table id="archerTable">
            <thead>
                <tr>
                    <th>No.</th> <!-- Remove sorting functionality for index column -->
                    <th onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">MemberID <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Membership Status <i class="fas fa-sort"></i></th>
                    <th>Performance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="archers-table">
                <!-- Loop through enrolled archers -->
                @foreach($enrolledArchers as $key => $archer)
                <tr data-name="{{ strtolower($archer->account_full_name) }}">
                    <td data-label="No.">{{ $key + 1 }}</td>
                    <td data-label="Name">{{ $archer->account_full_name }}</td>
                    <td data-label="MemberID">{{ str_pad($archer->membership_id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td data-label="Membership Status">{{ $archer->membership_status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td data-label="Performance">
                        <div class="btn-container">
                            <a href="{{ route('coach.scoringHistoryArcher', $archer->membership_id) }}" class="btn btn-view">View Score</a>
                            <a href="{{ route('coach.attendanceView', ['membership_id' => $archer->membership_id, 'referrer' => 'myArcher']) }}" class="btn btn-view">View Attendance</a>
                            <a href="{{ route('coach.analytics', ['archerId' => $archer->membership_id]) }}" class="btn btn-view">View Analytics</a>
                        </div>
                    </td>
                    <td data-label="Action">
                        <div class="btn-container">
                            <form action="{{ route('coach.unenrollArcher', $archer->account_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-unenroll">Unenroll</button>
                            </form>
                            <a href="{{ route('coach.viewProfile', $archer->membership_id) }}" class="btn btn-view">View Profile</a>
                            <a href="{{ route('coach.archerQrCode', $archer->membership_id) }}" class="btn btn-view">Show QR</a>
                        </div>
                    </td>
                </tr>
                @endforeach

                <!-- Loop through unenrolled archers -->
                @php $unenrollStart = count($enrolledArchers) + 1; @endphp
                @foreach($unenrolledArchers as $key => $archer)
                <tr data-name="{{ strtolower($archer->account_full_name) }}">
                    <td data-label="No.">{{ $unenrollStart + $key }}</td>
                    <td data-label="Name">{{ $archer->account_full_name }}</td>
                    <td data-label="MemberID">{{ str_pad($archer->membership_id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td data-label="Membership Status">{{ $archer->membership_status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td data-label="Performance">
                        <div class="btn-container">
                            <a href="{{ route('coach.scoringHistoryArcher', $archer->membership_id) }}" class="btn btn-view">View Score</a>
                            <a href="{{ route('coach.attendanceView', ['membership_id' => $archer->membership_id, 'referrer' => 'myArcher']) }}" class="btn btn-view">View Attendance</a>
                            <a href="{{ route('coach.analytics', ['archerId' => $archer->membership_id]) }}" class="btn btn-view">View Analytics</a>
                        </div>
                    </td>
                    <td data-label="Action">
                        <div class="btn-container">
                            <form action="{{ route('coach.enrollArcher', $archer->account_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-enroll">Enroll</button>
                            </form>
                            <a href="{{ route('coach.viewProfile', $archer->membership_id) }}" class="btn btn-view">View Profile</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#archers-table tr');

        rows.forEach(function (row) {
            const name = row.getAttribute('data-name');
            if (name.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function sortTable(n) {
        let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector("table");
        switching = true;
        dir = "asc"; 
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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
        // Recalculate the index after sorting
        updateTableIndex();
    }

    // Update index numbers after sorting
    function updateTableIndex() {
        const rows = document.querySelectorAll('#archers-table tr');
        rows.forEach((row, index) => {
            row.getElementsByTagName('td')[0].innerHTML = index + 1; // Update index column to reflect correct order
        });
    }
</script>

</body>
</html>
