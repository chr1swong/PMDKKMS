<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <!-- External CSS and Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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

        .filter-container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
            align-items: center;
        }

        .filter-container label {
            font-weight: bold;
            margin-right: 10px;
            display: block;
        }

        .filter-container select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
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
            text-align: center; /* Align text center as per the image */
            border: 1px solid #e1e1e1;
        }

        table th {
            background-color: #333;
            color: white;
        }

        table td {
            background-color: #f9f9f9;
        }

        /* Action Button Styling */
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
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
    </style>
</head>
<body>
    <header>
        @include('components.committeeHeader')
    </header>
    
    <div class="container">
        <h1>Manage Members</h1>
        
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

        <!-- Members Table -->
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>MemberID</th>
                    <th>Role</th>
                    <th>Coach</th> <!-- Coach Column -->
                    <th>Membership Status</th>
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

                    <!-- Placeholder for Coach name (adjust with actual data if needed) -->
                    <td>{{ $member->coach_name ?? 'N/A' }}</td>

                    <!-- Convert membership status to human-readable format -->
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
                        <a href="{{ route('view.profile', $member->membership_id) }}" class="btn btn-view">View Profile</a>
                        <form action="{{ route('delete.profile', $member->membership_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete Profile</button>
                        </form>
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
    </script>
</body>
</html>
