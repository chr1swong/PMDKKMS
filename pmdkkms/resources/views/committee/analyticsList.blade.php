<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics List</title>
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

        .analytics-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .analytics-header {
            font-size: 28px;
            font-weight: bold;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 10px;
            color: #aaa;
        }

        .search-wrapper input {
            padding: 8px 8px 8px 30px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
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
            cursor: pointer;
            width: 140px;
        }

        .btn-view-analytics {
            background-color: #5f4bb6;
            color: white;
        }

        .btn-view-analytics:hover {
            background-color: #3b1f8b;
        }

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            .analytics-container {
                padding: 15px;
            }

            .header-row {
                flex-direction: column; /* Stack elements vertically */
                align-items: flex-start;
                gap: 10px;
            }

            .analytics-header {
                font-size: 20px; /* Adjust font size for smaller screens */
            }

            .search-wrapper {
                max-width: 100%; /* Full width */
            }

            table {
                font-size: 12px; /* Further reduce font size */
            }

            table th, table td {
                padding: 8px; /* Adjust padding */
            }

            .btn {
                font-size: 11px; /* Further reduce font size */
                padding: 6px 8px; /* Adjust padding */
            }

            .hr-divider {
                margin: 15px 0; /* Adjust spacing for smaller screens */
            }
        }

        @media (max-width: 480px) {
            .analytics-container {
                margin: 20px auto;
                padding: 10px;
            }

            .analytics-header {
                font-size: 18px; /* Further reduce font size */
            }

            .search-wrapper input {
                font-size: 12px; /* Adjust font size */
                padding: 6px 6px 6px 25px; /* Adjust padding */
            }

            table {
                font-size: 11px; /* Smallest font size for readability */
            }

            table th, table td {
                padding: 5px; /* Minimal padding for smaller screens */
            }

            .btn {
                font-size: 10px; /* Small font size */
                padding: 5px 7px; /* Minimal padding */
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.committeeHeader')
</header>

<div class="analytics-container">
    <div class="header-row">
        <h1 class="analytics-header">Analytics List</h1>
        <!-- Search Input -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name..">
        </div>
    </div>
    <hr class="hr-divider">

    <!-- Analytics List Table -->
    <div class="table-container">
        <table id="analyticsTable">
            <thead>
            <tr>
                <th>No.</th>
                <th onclick="sortTable(1)" onkeydown="if(event.key === 'Enter' || event.key === ' ') sortTable(1);" tabindex="0">
                    Name <i class="fas fa-sort"></i>
                </th>
                <th onclick="sortTable(2)" onkeydown="if(event.key === 'Enter' || event.key === ' ') sortTable(2);" tabindex="0">
                    Coach <i class="fas fa-sort"></i>
                </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="analytics-table">
                @foreach($members as $key => $member)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $member->account_full_name }}</td>
                    <td>{{ $member->coach_name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('committee.analytics', ['archerId' => $member->membership_id]) }}" class="btn btn-view-analytics">
                            View Analytics
                        </a>
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
        const rows = document.querySelectorAll('#analytics-table tr');
        let index = 1; // Start the index from 1

        rows.forEach(function (row) {
            const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            if (name.includes(input)) {
                row.style.display = '';
                row.cells[0].innerText = index++; // Update the index and increment
            } else {
                row.style.display = 'none';
            }
        });
    }

    function sortTable(n) {
        let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("analyticsTable");
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
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
        updateIndex(); // Recalculate index numbers after sorting
    }

    // Function to recalculate index numbers
    function updateIndex() {
        const rows = document.querySelectorAll('#analytics-table tr');
        let index = 1; // Start the index from 1
        rows.forEach((row) => {
            row.cells[0].innerHTML = index++;
        });
    }
</script>

</body>
</html>
