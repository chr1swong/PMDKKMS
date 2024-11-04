<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Transaction History</title>
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
            width: 180px; 
        }

        .status-search-container {
            display: flex;
            gap: 10px; 
            align-items: center;
        }

        .table-container {
            width: 100%;
            margin: 20px auto;
            max-height: 600px;
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

        .status-completed {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-pending {
            background-color: #ffc107;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-failed {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
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

        .date-filters button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .date-filters button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

<header>
    @include('components.archerHeader') 
</header>

@if (session('success'))
    <div class="alert alert-success" id="success-message">
        {{ session('success') }}
        <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
    </div>
@endif

<div class="payment-history-container">
    <div class="header-row">
        <h1 class="payment-history-header">Transaction History</h1>
        <button id="generate-pdf" class="btn-download">Download PDF</button>
    </div>
    <hr class="hr-divider">

    <!-- Filter and Search Section -->
    <div class="filter-container">
        <div class="status-search-container">
            <select id="status-filter" name="status-filter" onchange="filterByStatus()">
                <option value="all">All Statuses</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <div class="date-filters">
            <form action="{{ route('archer.paymentHistory') }}" method="GET">
                <input type="date" name="start-date" id="start-date" value="{{ request('start-date') }}">
                <input type="date" name="end-date" id="end-date" value="{{ request('end-date') }}">
                <button type="submit" class="btn">Filter</button>
            </form>
        </div>
    </div>

    <!-- Payment List Table -->
    <div class="table-container">
        <table id="paymentTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">MemberID <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Amount (RM) <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Extend Duration <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(5)">Status <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(6)">Transaction Date <i class="fas fa-sort"></i></th>
                </tr>
            </thead>
            <tbody id="payments-table">
                @if($payments->isEmpty())
                    <tr>
                        <td colspan="7" style="text-align: center; font-weight: bold; color: #555;">
                            No records found!
                        </td>
                    </tr>
                @else
                    @foreach($payments as $key => $payment)
                        <tr data-name="{{ strtolower($payment->account->account_full_name) }}" data-status="{{ strtolower($payment->payment_status) }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $payment->account->account_full_name }}</td>
                            <td>{{ $payment->membership_id }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->duration }} months</td>
                            <td class="{{ 'status-' . strtolower($payment->payment_status) }}">
                                {{ ucfirst($payment->payment_status) }}
                            </td>
                            <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $payments->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<script>
    function filterByStatus() {
        const selectedStatus = document.getElementById('status-filter').value;
        const rows = document.querySelectorAll('#payments-table tr');

        let visibleIndex = 1;

        rows.forEach(function (row) {
            const status = row.getAttribute('data-status');
            if (selectedStatus === 'all' || status === selectedStatus) {
                row.style.display = '';
                row.cells[0].innerHTML = visibleIndex++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#payments-table tr');

        rows.forEach(function (row) {
            const name = row.getAttribute('data-name').toLowerCase();
            if (name.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateIndex();
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
        const rows = document.querySelectorAll('#payments-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1;
        });
    }

    // Generate PDF
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        const headers = [['No.', 'Name', 'MemberID', 'Amount (RM)', 'Duration (Months)', 'Status', 'Transaction Date']];

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
                cells[5].innerText,
                cells[6].innerText
            ];
            tableRows.push(rowData);
        });

        pdf.setFontSize(18);
        pdf.text("Transaction History", 14, 20);

        pdf.autoTable({
            head: headers,
            body: tableRows,
            startY: 30,
            styles: {
                fontSize: 10,
                cellPadding: 3,
                halign: 'center',
                valign: 'middle',
                lineColor: [44, 62, 80],
                lineWidth: 0.5
            },
            headStyles: {
                fillColor: [33, 150, 243],
                textColor: [255, 255, 255]
            }
        });

        const date = new Date();
        const formattedDate = date.toISOString().split('T')[0];
        pdf.save(`transaction_history_${formattedDate}.pdf`);
    });

    function closeSuccessMessage() {
        document.getElementById('success-message').style.display = 'none';
    }
</script>

</body>
</html>