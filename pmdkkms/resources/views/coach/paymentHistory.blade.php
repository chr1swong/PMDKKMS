<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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

        /* Success Message Styling */
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

        .pagination {
            display: flex;
            justify-content: center;
            padding: 1rem 0;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
        }

        .pagination li a:hover {
            background-color: #f4f4f4;
        }

        .pagination .active span {
            background-color: #333;
            color: white;
            border-color: #333;
        }

        .status-completed {
            background-color: #28a745; /* Green */
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-pending {
            background-color: #ffc107; /* Yellow */
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-failed {
            background-color: #dc3545; /* Red */
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    @include('components.coachHeader') 
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
        <h1 class="payment-history-header">Transaction History</h1>
        <button id="generate-pdf" class="btn-download">Download PDF</button>
    </div>
    <hr class="hr-divider">

    <div class="filter-container">
    <!-- Status Filter and Search Bar Container -->
    <div class="status-search-container">
        <!-- Membership Status filter -->
        <select id="status-filter" name="status-filter" onchange="filterByStatus()">
            <option value="all">All Statuses</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
        </select>
    </div>

    <!-- Date filters -->
    <div class="date-filters">
        <form action="{{ route('coach.paymentHistory') }}" method="GET">
            <input type="date" name="start-date" id="start-date" value="{{ request('start-date') }}">
            <input type="date" name="end-date" id="end-date" value="{{ request('end-date') }}">
            <button type="submit" class="btn">Filter</button>
        </form>
    </div>
</div>

    <!-- Payment List Table -->
    <div class="table-container" style="height: 570px; overflow-y: auto;">
        <table id="paymentTable">
            <thead style="position: sticky; top: 0; background-color: #333; color: white; z-index: 1;">
                <tr>
                    <th>No.</th>
                    <th onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">MemberID <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Amount (RM) <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Extend Duration <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(5)">Status <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(6)">Bill Code <i class="fas fa-sort"></i></th> 
                    <th onclick="sortTable(7)">Transaction Date <i class="fas fa-sort"></i></th>
                </tr>
            </thead>
            <tbody id="payments-table">
                @php
                    $startIndex = 1;
                @endphp
                @foreach($payments as $key => $payment)
                <tr data-name="{{ strtolower($payment->account->account_full_name) }}" data-status="{{ strtolower($payment->payment_status) }}">
                    <td>{{ $startIndex + $loop->index }}</td> <!-- Updated index calculation -->
                    <td>{{ $payment->account->account_full_name }}</td>
                    <td>{{ $payment->membership_id }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->duration }} months</td>
                    <td class="
                        @if(strtolower($payment->payment_status) === 'completed') status-completed
                        @elseif(strtolower($payment->payment_status) === 'pending') status-pending
                        @else status-failed
                        @endif">
                        {{ ucfirst($payment->payment_status) }}
                    </td>
                    <td>{{ $payment->toyyibpay_billcode ?? 'N/A' }}</td> 
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

<script type="application/json" id="allPaymentsData">
    {!! json_encode($payments->map(function ($payment) {
        return [
            'account_full_name' => $payment->account->account_full_name ?? 'N/A',
            'membership_id' => $payment->membership_id,
            'amount' => number_format($payment->amount, 2),
            'duration' => "{$payment->duration} months",
            'payment_status' => ucfirst($payment->payment_status),
            'transaction_date' => $payment->created_at->format('Y-m-d') // Format without time
        ];
    })) !!}
</script>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<script>
    function filterByStatus() {
        const selectedStatus = document.getElementById('status-filter').value;
        const rows = document.querySelectorAll('#payments-table tr');

        let visibleIndex = 1; // Initialize index for visible rows

        rows.forEach(function (row) {
            const status = row.getAttribute('data-status');
            if (selectedStatus === 'all' || status === selectedStatus) {
                row.style.display = '';
                row.cells[0].innerHTML = visibleIndex++; // Update index cell for visible rows
            } else {
                row.style.display = 'none';
            }
        });
    }

    function sortTable(n) {
        const table = document.querySelector("table");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc"; 
        const isDurationColumn = (n === 4); // Adjust this index based on your table structure

        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];

                // Custom logic for sorting duration column numerically
                let xContent = x.innerHTML.toLowerCase();
                let yContent = y.innerHTML.toLowerCase();

                if (isDurationColumn) {
                    // Extract numeric part for duration column (e.g., "3 months" -> 3)
                    xContent = parseInt(xContent.split(" ")[0]);
                    yContent = parseInt(yContent.split(" ")[0]);
                }

                if (dir === "asc") {
                    if (xContent > yContent) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (xContent < yContent) {
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

    function updateIndex() {
        const rows = document.querySelectorAll('#payments-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1; // Update index cell
        });
    }

    // Generate PDF
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Function to add the header
        function addHeader() {
            pdf.setFont("Arial");
            const img = new Image();
            img.src = '/images/pmdkkLogo.png';
            pdf.addImage(img, 'PNG', 10, 15, 30, 30);

            const textXPosition = 45;
            pdf.setFontSize(14.5);
            pdf.setFont("Arial", "bold");
            pdf.text("PERSATUAN MEMANAH DAERAH KOTA KINABALU (PMDKK)", textXPosition, 18);
            pdf.setFontSize(10);
            pdf.text("(D-SBH-03075)", textXPosition, 24);

            // Add current date
            const today = new Date();
            const currentDate = `${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}-${today.getFullYear()}`;
            pdf.text(`Date: ${currentDate}`, textXPosition, 30);
            pdf.text("Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia.", textXPosition, 36);
            pdf.text("Email: pmdkk2015@gmail.com", textXPosition, 42);
            pdf.text("Contact: 088-794 327", pdf.internal.pageSize.width - 45, 42);

            pdf.setFontSize(14);
            pdf.text("Transaction History", 14, 55);
        }

        // Table headers
        const headers = [['No.', 'Name', 'MemberID', 'Amount (RM)', 'Duration (Months)', 'Status', 'Bill Code', 'Transaction Date']];

        // Collect visible rows for the PDF
        const visibleRows = Array.from(document.querySelectorAll('#payments-table tr'))
            .filter(row => row.style.display !== 'none')
            .map((row, index) => [
                index + 1, // Adjust for visible index
                row.cells[1].innerText, // Name
                row.cells[2].innerText, // MemberID
                row.cells[3].innerText, // Amount
                row.cells[4].innerText, // Duration
                row.cells[5].innerText, // Status
                row.cells[6].innerText, // Bill Code
                row.cells[7].innerText  // Transaction Date
            ]);

        // Check if there's data to generate
        if (visibleRows.length === 0) {
            alert('No data available for PDF generation based on the current filters.');
            return;
        }

        // Add the header
        addHeader();

        // Generate the table in the PDF
    pdf.autoTable({
        head: headers,
        body: visibleRows,
        startY: 60, // Start position below the header on the first page
        styles: {
            font: "Arial",
            fontSize: 10,
            cellPadding: 3,
            halign: 'center',
            valign: 'middle',
            lineColor: [44, 62, 80],
            lineWidth: 0.1
        },
        headStyles: {
            fillColor: [169, 169, 169],
            textColor: [255, 255, 255]
        },
        bodyStyles: {
            fillColor: [255, 255, 255],
            textColor: [0, 0, 0]
        },
        margin: { top: 20 }, // Use a smaller top margin for all pages
        pageBreak: 'auto',
        didDrawPage: function (data) {
            // Add the header only on the first page
            if (data.pageNumber === 1) {
                addHeader();
            }

            // Add page numbers on each page
            const pageCount = pdf.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                pdf.setPage(i);
                pdf.setFontSize(10);
                const pageText = `Page ${i} of ${pageCount}`;
                const pageWidth = pdf.internal.pageSize.width;
                const textWidth = pdf.getTextWidth(pageText);
                pdf.text(pageText, (pageWidth - textWidth) / 2, pdf.internal.pageSize.height - 10);
            }
        },
        didDrawCell: function (data) {
            // Adjust the start position of the table for pages after the first
            if (data.row.index === 0 && data.pageNumber > 1) {
                data.settings.startY = 30; // Adjusted start position for second and subsequent pages
            }
        }
    });

        // Save the PDF
        const date = new Date().toISOString().split('T')[0];
        pdf.save(`transaction_history_${date}.pdf`);
    });



    function closeSuccessMessage() {
        document.getElementById('success-message').style.display = 'none';
    }
</script>

</body>
</html>
