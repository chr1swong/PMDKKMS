<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring History</title>
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

        .scoring-history-container {
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

        /* Flex container for header and button */
        .scoring-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .scoring-history-header {
            text-align: left;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            margin-bottom: 5px;
        }

        .filter-container input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-left: 10px;
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
            left: 25px;
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
            padding: 8px 12px; /* Adjusted padding to look balanced */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px; /* Ensure consistent font size */
            font-weight: 500;
            display: inline-block; /* Ensure the button doesn't stretch */
            line-height: 1.2; /* Adjust line height for vertical centering */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-view:hover {
            background-color: #3b1f8b;
            transform: scale(1.05); /* Slight scaling effect on hover */
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .table-container {
                max-height: 300px;
            }

            .scoring-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-download {
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.committeeHeader') 
</header>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
        <button class="close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<div class="scoring-history-container">
    <div class="scoring-header">
        <h1 class="scoring-history-header">Scoring History of Archers</h1>
        <!-- PDF Download Button -->
        <button id="generate-pdf" class="btn-download">Download PDF</button>
    </div>
    <hr class="hr-divider">

    <!-- Search Bar and Filter -->
    <div class="filter-container">
        <!-- Search bar for archer names -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name..">
        </div>

        <!-- Date filters -->
        <div class="date-filters">
            <form action="{{ route('committee.scoringHistory') }}" method="GET">
                <input type="date" name="start-date" id="start-date" value="{{ request('start-date') }}">
                <input type="date" name="end-date" id="end-date" value="{{ request('end-date') }}">
                <button type="submit">Filter</button>
            </form>
        </div>
    </div>

    <!-- Scoring History Table -->
    <div class="table-container">
        <table id="scoringTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th onclick="sortTable(1)">Archer Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">Date <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Distance <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Total Score <i class="fas fa-sort"></i></th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody id="scoring-table">
                @forelse($scoringData as $index => $score)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $score->archer_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($score->date)->format('d F Y') }}</td>
                        <td>{{ $score->distance }}M</td>
                        <td>{{ $score->overall_total }}/360</td>
                        <td>
                            <a href="{{ route('committee.scoringDetails', $score->id) }}" class="btn-view">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No scoring records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $scoringData->links() }}
</div>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<script>
    // Sorting function for the table
    function sortTable(n, type) {
        const table = document.getElementById("scoringTable");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc"; // Set the sorting direction to ascending by default
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (type === 'num') { // Numeric sorting
                    const xValue = parseFloat(x.innerHTML.replace('M', '').replace('/360', ''));
                    const yValue = parseFloat(y.innerHTML.replace('M', '').replace('/360', ''));
                    if (dir === "asc" && xValue > yValue) {
                        shouldSwitch = true;
                        break;
                    } else if (dir === "desc" && xValue < yValue) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (type === 'date') { // Date sorting
                    const xDate = new Date(x.innerHTML);
                    const yDate = new Date(y.innerHTML);
                    if (dir === "asc" && xDate > yDate) {
                        shouldSwitch = true;
                        break;
                    } else if (dir === "desc" && xDate < yDate) {
                        shouldSwitch = true;
                        break;
                    }
                } else { // Alphabetic sorting
                    if (dir === "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    } else if (dir === "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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
        // Recalculate index numbers after sorting
        updateIndex();
    }

    // Search function for archer names
    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#scoring-table tr');

        // Filter rows based on the search input
        rows.forEach((row) => {
            const name = row.cells[1].innerText.toLowerCase(); // Get archer name from the second cell
            if (name.includes(input)) {
                row.style.display = ''; // Show row if it matches the search
            } else {
                row.style.display = 'none'; // Hide row if it doesn't match
            }
        });
        updateIndex(); // Recalculate index numbers based on visible rows
    }

    // Function to recalculate index numbers for visible rows
    function updateIndex() {
        const rows = document.querySelectorAll('#scoring-table tr');
        let visibleIndex = 1; // Start index from 1

        rows.forEach((row) => {
            if (row.style.display !== 'none') { // Only update index for visible rows
                row.cells[0].innerHTML = visibleIndex++; // Set and increment the visible index
            }
        });
    }

    // Function to generate PDF with autoTable
    document.getElementById('generate-pdf').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');

    // Set the font to Arial
    pdf.setFont("Arial");

    // Add the logo
    const img = new Image();
    img.src = '/images/pmdkkLogo.png'; 
    img.onload = function () {
        // Draw the logo on the PDF
        pdf.addImage(img, 'PNG', 10, 15, 30, 30); // X, Y, Width, Height

        // Header with Organization Name, ID, Date, Address, and Email
        const textXPosition = 45;
        pdf.setFontSize(14.5);
        pdf.setFont("Arial", "bold");
        pdf.text("PERSATUAN MEMANAH DAERAH KOTA KINABALU (PMDKK)", textXPosition, 18);

        // Organization ID
        pdf.setFontSize(10);
        pdf.text("(D-SBH-03075)", textXPosition, 24);

        // Date
        pdf.setFontSize(10);
        pdf.setFont("Arial", "bold");
        const date = new Date();
        const formattedDate = date.toISOString().split('T')[0];
        pdf.text(`Date: ${formattedDate}`, textXPosition, 30);

        // Address
        pdf.setFontSize(10);
        pdf.setFont("Arial", "bold");
        pdf.text("Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia.", textXPosition, 36);

        // Email and Contact Information
        pdf.text("Email: pmdkk2015@gmail.com", textXPosition, 42);
        pdf.text("Contact: 088-794 327", pdf.internal.pageSize.width - 45, 42); 

        // Title
        pdf.setFontSize(14);
        pdf.setFont("Arial", "bold");
        pdf.text("Scoring History of Archers", 14, 55);

        // Table headers
        const headers = [['No.', 'Archer Name', 'Date', 'Distance', 'Total Score']];

        // Get table data
        const tableRows = [];
        const rows = document.querySelectorAll('#scoringTable tbody tr');
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            const rowData = [
                index + 1, // No.
                cells[1].innerText, // Archer Name
                cells[2].innerText, // Date
                cells[3].innerText, // Distance
                cells[4].innerText  // Total Score
            ];
            tableRows.push(rowData);
        });

        // Create the table in the PDF
        pdf.autoTable({
            head: headers,
            body: tableRows,
            startY: 60,
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
                fillColor: [169, 169, 169], // Grey color for header
                textColor: [255, 255, 255]
            },
            bodyStyles: {
                fillColor: [255, 255, 255],
                textColor: [0, 0, 0]
            }
        });

        // Center-aligned page numbers in the footer
        const pageCount = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            pdf.setPage(i);
            pdf.setFontSize(10);
            const pageText = `Page ${i} of ${pageCount}`;
            const pageWidth = pdf.internal.pageSize.width;
            const textWidth = pdf.getTextWidth(pageText);
            pdf.text(pageText, (pageWidth - textWidth) / 2, pdf.internal.pageSize.height - 10); // Center-aligned
        }

        // Save the PDF with the current date in the filename
        pdf.save(`scoring_history_${formattedDate}.pdf`);
    };
});

</script>

</body>
</html>
