<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
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

        .member-management-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .hr-divider {
            border: none;
            border-top: 2px solid #e0e0e0;
            margin: 10px 0;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .member-management-header {
            font-size: 28px;
            font-weight: bold;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            margin-bottom: 5px;
        }

        .filter-container select,
        .filter-container input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
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

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-delete:hover {
            background-color: #e04a4a;
        }

        .btn-download {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-download:hover {
            background-color: #218838;
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

        /* Success or Error Message */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Close Button Styling */
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
    </style>
</head>
<body>

<header>
    @include('components.committeeHeader') 
</header>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success" id="success-message">
        {{ session('success') }}
        <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
    </div>
@endif

<div class="member-management-container">
    <div class="header-row">
        <h1 class="member-management-header">Manage Members</h1>
        <button id="generate-pdf" class="btn-download">Download PDF</button>
    </div>
    <hr class="hr-divider">

    <!-- Filter and Search -->
    <div class="filter-container">
        <!-- Role filter -->
        <select id="role-filter" name="role-filter" onchange="filterByRole()">
            <option value="all">All Roles</option>
            <option value="archer">Archer</option>
            <option value="coach">Coach</option>
            <option value="committee">Committee</option>
        </select>

        <!-- Search bar for names -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name..">
        </div>
    </div>

    <!-- Member List Table -->
    <div class="table-container">
        <table id="memberTable">
            <thead>
                <tr>
                    <th>No.</th> <!-- Index column without sorter -->
                    <th onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">MemberID <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Role <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Coach <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(5)">Membership Status <i class="fas fa-sort"></i></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="members-table">
                @foreach($members as $key => $member)
                <tr data-name="{{ strtolower($member->account_full_name) }}" data-role="{{ strtolower($member->account_role == 1 ? 'archer' : ($member->account_role == 2 ? 'coach' : 'committee')) }}">
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

    <!-- Pagination -->
    {{ $members->links() }}
    
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

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

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
        updateIndex(); // Recalculate index numbers after filtering
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
        updateIndex(); // Recalculate index numbers after searching
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
        updateIndex(); // Recalculate index numbers after sorting
    }

    // Function to recalculate index numbers
    function updateIndex() {
        const rows = document.querySelectorAll('#members-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1; // Update index cell
        });
    }

    // Generate PDF
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Table headers
        const headers = [['No.', 'Name', 'MemberID', 'Role', 'Coach', 'Membership Status']];

        // Get table data
        const tableRows = [];
        const rows = document.querySelectorAll('#memberTable tbody tr');

        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            const rowData = [
                index + 1, // No.
                cells[1].innerText, // Name
                cells[2].innerText, // MemberID
                cells[3].innerText, // Role
                cells[4].innerText, // Coach
                cells[5].innerText  // Membership Status
            ];
            tableRows.push(rowData); // Push each row data into tableRows array
        });

        // Add title to PDF
        pdf.setFontSize(18);
        pdf.text("Member List", 14, 20);

        // Create table in the PDF
        pdf.autoTable({
            head: headers,
            body: tableRows,
            startY: 30, // Y position where the table starts
            styles: {
                fontSize: 10, // Font size for table
                cellPadding: 3, // Cell padding
                halign: 'center', // Text alignment inside cells
                valign: 'middle', // Vertical alignment
                lineColor: [44, 62, 80], // Line color for the table borders
                lineWidth: 0.5 // Line width for the table borders
            },
            headStyles: {
                fillColor: [33, 150, 243], // Header background color (blue)
                textColor: [255, 255, 255], // Header text color (white)
            }
        });

        // Get current date
        const date = new Date();
        const formattedDate = date.toISOString().split('T')[0]; // YYYY-MM-DD format

        // Save the generated PDF with the current date in the filename
        pdf.save(`member_list_${formattedDate}.pdf`);
    });

    function closeSuccessMessage() {
        document.getElementById('success-message').style.display = 'none';
    }
</script>

</body>
</html>
