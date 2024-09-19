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

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }

        .modal input {
            width: 80%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal button {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .confirm-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .cancel-delete {
            background-color: #ccc;
            color: black;
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
        <div class="filter-search-container">
            <div class="filter-container">
                <label for="role-filter">Member</label>
                <select id="role-filter" name="role-filter" onchange="filterByRole()">
                    <option value="all">All Roles</option>
                    <option value="archer">Archer</option>
                    <option value="coach">Coach</option>
                    <option value="committee">Committee</option>
                </select>
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
                <tr data-name="{{ $member->account_full_name }}" data-role="{{ strtolower($member->account_role == 1 ? 'archer' : ($member->account_role == 2 ? 'coach' : 'committee')) }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $member->account_full_name }}</td>
                    <td>{{ $member->membership_id }}</td>
                    <td>{{ $member->account_role == 1 ? 'Archer' : ($member->account_role == 2 ? 'Coach' : 'Committee') }}</td>
                    <td>{{ $member->coach_name ?? 'N/A' }}</td>
                    <td>{{ $member->membership_status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <div class="btn-container">
                            <a href="{{ route('view.profile', $member->membership_id) }}" class="btn btn-view">View Profile</a>
                            <button type="button" class="btn btn-delete" onclick="showDeleteModal('{{ $member->account_full_name }}', '{{ route('delete.profile', $member->account_id) }}')">Delete Profile</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Deletion</h3>
            <p>Type the member's name to confirm deletion:</p>
            <input type="text" id="delete-confirmation-input" placeholder="Type the name...">
            <button class="confirm-delete" id="confirmDeleteButton">Confirm</button>
            <button class="cancel-delete" onclick="closeDeleteModal()">Cancel</button>
        </div>
    </div>

    <script>
        let memberToDelete = '';
        let deleteUrl = '';

        function showDeleteModal(memberName, url) {
            memberToDelete = memberName;
            deleteUrl = url;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            memberToDelete = '';
            deleteUrl = '';
            document.getElementById('delete-confirmation-input').value = ''; 
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            const confirmationInput = document.getElementById('delete-confirmation-input').value;
            if (confirmationInput === memberToDelete) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(tokenInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            } else {
                alert('The name you entered does not match.');
            }
        });

        function filterByRole() {
            const selectedRole = document.getElementById('role-filter').value;
            const rows = document.querySelectorAll('#members-table tr');

            rows.forEach(function (row) {
                const role = row.getAttribute('data-role');
                if (selectedRole === 'all' || role === selectedRole) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function searchByName() {
            const input = document.getElementById("search-input").value.toLowerCase();
            const rows = document.querySelectorAll('#members-table tr');

            rows.forEach(function (row) {
                const name = row.getAttribute('data-name').toLowerCase();
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
        }
    </script>
</body>
</html>
