<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
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

        .payment-history-container {
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

        .payment-history-header {
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

<div class="payment-history-container">
    <div class="header-row">
        <h1 class="payment-history-header">Payment History</h1>
        <button id="generate-pdf" class="btn-download">Download PDF</button>
    </div>
    <hr class="hr-divider">

    <!-- Filter and Search -->
    <div class="filter-container">
        <!-- Date filter -->
        <select id="date-filter" name="date-filter" onchange="filterByDate()">
            <option value="all">All Dates</option>
            @foreach ($dates as $date)
                <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>{{ $date }}</option>
            @endforeach
        </select>

        <!-- Search bar for member names -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by member name..">
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="table-container">
        <table id="paymentTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th onclick="sortTable(1)">Member Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">MemberID <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Amount (RM) <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Date <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(5)">Status <i class="fas fa-sort"></i></th>
                </tr>
            </thead>
            <tbody id="payment-table">
                @foreach($payments as $key => $payment)
                <tr data-name="{{ strtolower($payment->account->account_full_name ?? 'N/A') }}" data-date="{{ $payment->date }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $payment->account->account_full_name ?? 'N/A' }}</td>
                    <td>{{ $payment->membership_id }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>{{ $payment->payment_status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $payments->links() }}
</div>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<script>
    function filterByDate() {
        const selectedDate = document.getElementById('date-filter').value;
        const rows = document.querySelectorAll('#payment-table tr');

        rows.forEach(function (row) {
            const date = row.getAttribute('data-date');
            if (selectedDate === 'all' || date === selectedDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateIndex(); // Recalculate index numbers after filtering
    }

    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#payment-table tr');

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
        updateIndex();
    }

    function updateIndex() {
        const rows = document.querySelectorAll('#payment-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1;
        });
    }

    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const headers = [['No.', 'Member Name', 'MemberID', 'Amount (RM)', 'Date', 'Status']];
        const tableRows = [];
        const rows = document.querySelectorAll('#paymentTable tbody tr');

        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            const rowData = [
                index + 1,
                cells[1].innerText,
                cells[2].innerText,
                cells[3].innerText,
                cells[4].innerText,
                cells[5].innerText
            ];
            tableRows.push(rowData);
        });

        pdf.setFontSize(18);
        pdf.text("Payment History", 14, 20);
        pdf.autoTable({
            head: headers,
            body: tableRows,
            startY: 30,
            styles: { fontSize: 10, cellPadding: 3, halign: 'center', valign: 'middle' },
            headStyles: { fillColor: [33, 150, 243], textColor: [255, 255, 255] }
        });

        pdf.save(`payment_history.pdf`);
    });

    function closeSuccessMessage() {
        document.getElementById('success-message').style.display = 'none';
    }
</script>

</body>
</html>
