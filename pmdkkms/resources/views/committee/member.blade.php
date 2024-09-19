<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
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

        /* Align filter-container and search bar side by side */
        .filter-search-container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-end; /* Align the dropdown and search bar to the bottom */
            gap: 20px; /* Add space between filter and search bar */
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

        /* Styling for the search input */
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
            color: #aaa;  /* Icon color */
        }

        .search-wrapper input {
            padding: 10px 10px 10px 35px; /* Add padding-left for space before the icon */
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

        /* Uniform Action Button Styling */
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

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-view:hover {
            background-color: #3b1f8b;
        }

        .btn-delete:hover {
            background-color: #e04a4a;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Adjust for mobile responsiveness */
        @media (max-width: 768px) {
            .filter-search-container {
                flex-direction: column;  /* Stack filter and search bar */
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
    
    <!-- Container -->
    <div class="container">
        <!-- Filter and Search Bar Container -->
        <div class="filter-search-container">
            <!-- Filter Dropdown -->
            <div class="filter-container">
                <label for="role-filter">Member</label>
                <select id="role-filter" name="role-filter" onchange="filterByRole()">
                    <option value="all">All Roles</option>
                    <option value="archer">Archer</option>
                    <option value="coach">Coach</option>
                    <option value="committee">Committee</option>
                </select>
            </div>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name..">
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th onclick="sortTable(0)">No. <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">MemberID <i class="fas fa-sort"></i></th>
                    <th>Role</th>
                    <th>Coach</th>
                    <th onclick="sortTable(5)">Membership Status <i class="fas fa-sort"></i></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="members-table">
                @foreach($members as $key => $member)
                <tr data-role="{{ strtolower($member->account_role == 1 ? 'archer' : ($member->account_role == 2 ? 'coach' : 'committee')) }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $member->account_full_name }}</td>
                    <td>{{ $member->membership_id }}</td>

                    <!-- Display account role as a human-readable label -->
                    <td>
                        @if($member->account_role == 1)
                            Archer
                        @elseif($member->account_role == 2)
                            Coach
                        @elseif($member->account_role == 3)
                            Committee
                        @else
                            Unknown Role
                        @endif
                    </td>

                    <td>{{ $member->coach_name ?? 'N/A' }}</td>

                    <td>
                        @if($member->membership_status == 1)
                            Active
                        @elseif($member->membership_status == 2)
                            Inactive
                        @else
                            Unknown Status
                        @endif
                    </td>

                    <td>
                        <div class="btn-container">
                            <a href="{{ route('view.profile', $member->membership_id) }}" class="btn btn-view">View Profile</a>
                            <form action="{{ route('delete.profile', $member->membership_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete Profile</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function filterByRole() {
            var selectedRole = document.getElementById('role-filter').value;
            var rows = document.querySelectorAll('#members-table tr');

            rows.forEach(function(row) {
                var role = row.getAttribute('data-role');
                
                if (selectedRole === 'all' || role === selectedRole) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function searchByName() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-input");
            filter = input.value.toLowerCase();
            table = document.getElementById("members-table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Get the Name column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector("table");
            switching = true;
            dir = "asc";  // Set the sorting direction to ascending by default
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
            updateSortIcons(n, dir);
        }

        function updateSortIcons(colIndex, direction) {
            var headers = document.querySelectorAll('th');
            headers.forEach((header, index) => {
                if (index === colIndex) {
                    if (direction === "asc") {
                        header.querySelector('i').className = "fas fa-sort-up";
                    } else {
                        header.querySelector('i').className = "fas fa-sort-down";
                    }
                } else {
                    header.querySelector('i').className = "fas fa-sort";
                }
            });
        }
    </script>
</body>
</html>
