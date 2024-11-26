<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring List</title>
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

        /* PDF Button Styles */
        .btn-pdf {
            background-color: #dc3545 !important; /* Force red for PDF button */
            color: white !important;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-pdf:hover {
            background-color: #b22222 !important; /* Darker red on hover */
            color: #f8d7da !important; /* Light text on hover */
        }

        /* Excel Button Styles */
        .btn-excel {
            background-color: #28a745; /* Green for Excel */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-excel:hover {
            background-color: #218838; /* Darker green */
        }

        .hr-divider {
            border: none;
            border-top: 2px solid #e0e0e0;
            margin: 10px 0;
        }

        /* Flex container for header and button */
        .scoring-header-container {
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
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px; 
            font-weight: 500;
            display: inline-block; 
            line-height: 1.2; 
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-view:hover {
            background-color: #3b1f8b;
            transform: scale(1.05); 
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

       /* Adjustments for screens up to 768px */
        @media (max-width: 768px) {
            .filter-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start; /* Align filters to the left */
                align-items: center; /* Center items vertically */
                gap: 12px; /* Slightly increased gap for better spacing */
            }

            .status-search-container,
            .date-filters {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: nowrap; /* Keep all filters in a single row */
            }

            .status-search-container select,
            .date-filters input,
            .date-filters button {
                font-size: 14px;
                padding: 8px;
                width: auto; /* Allow elements to adjust based on content */
                flex-shrink: 0; /* Prevent elements from shrinking */
            }

            .btn-download {
                font-size: 14px;
                padding: 10px;
                width: 100%; /* Full width on smaller screens */
                margin-top: 10px;
            }

            /* Table container and table adjustments for better fit */
            .table-container {
                overflow-x: auto; /* Allow horizontal scrolling if needed */
                max-height: 400px; /* Adjust max height for better fit */
            }

            table {
                width: 100%; /* Ensure the table takes the full width */
                font-size: 14px; /* Adjust font size for better readability */
            }

            table th, table td {
                font-size: 14px;
                padding: 8px; /* Adjust padding to save space */
                white-space: nowrap; /* Prevent text wrapping */
            }

            table th {
                background-color: #444; /* Darker header for contrast */
                color: white;
                position: sticky; /* Make headers sticky */
                top: 0; /* Keep headers at the top when scrolling */
                z-index: 2;
            }
        }

        /* Adjustments for screens up to 480px */
        @media (max-width: 480px) {
            .filter-container {
                flex-direction: column; /* Stack elements vertically on very small screens */
                align-items: flex-start;
                gap: 15px;
            }

            .status-search-container,
            .date-filters {
                width: 100%; /* Make each filter full width */
            }

            .status-search-container select,
            .date-filters input,
            .date-filters button {
                font-size: 12px;
                padding: 8px;
            }

            .btn-download {
                font-size: 12px;
                padding: 8px;
                width: 100%; /* Full width for better layout */
            }

            table th, table td {
                font-size: 12px;
                padding: 6px;
            }

            /* Table container and table adjustments for smaller screens */
            .table-container {
                overflow-x: auto; /* Horizontal scroll for small screens */
                max-height: 300px; /* Reduce height for smaller screens */
            }

            table {
                width: 100%;
                font-size: 12px; /* Smaller font size for compact display */
            }

            table th, table td {
                font-size: 12px;
                padding: 6px; /* Reduce padding for compactness */
                white-space: nowrap; /* Prevent text wrapping */
            }

            /* Optional: Collapse some columns for very small screens */
            table th:nth-child(3),
            table td:nth-child(3),
            table th:nth-child(6),
            table td:nth-child(6) {
                display: none; /* Hide columns like MemberID or Bill Code if needed */
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.coachHeader') 
</header>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
        <button class="close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<div class="scoring-history-container">
    <div class="scoring-header-container">
        <h1 class="scoring-history-header">Scoring History of Enrolled Archers</h1>
        <div class="btn-container">
            <!-- PDF Download Button -->
            <button id="generate-pdf" class="btn-download btn-pdf">Download PDF</button>
            <!-- Excel Export Button -->
            <button id="export-excel" class="btn-download btn-excel">Export to Excel</button>
        </div>
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
            <form action="{{ route('coach.scoringList') }}" method="GET">
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
                            <a href="{{ route('coach.scoringDetails', ['id' => $score->id, 'referrer' => 'scoringList']) }}" class="btn btn-view">View Details</a> 
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

</div>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // Sorting function for the table
    function sortTable(n) {
        const table = document.getElementById("scoringTable");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                let xContent = x.innerHTML.toLowerCase();
                let yContent = y.innerHTML.toLowerCase();

                // Handle date sorting
                if (n === 2) {
                    const xDate = new Date(xContent);
                    const yDate = new Date(yContent);
                    if (dir === "asc" && xDate > yDate) {
                        shouldSwitch = true;
                        break;
                    } else if (dir === "desc" && xDate < yDate) {
                        shouldSwitch = true;
                        break;
                    }
                }
                // Handle total score sorting
                else if (n === 4) { // Adjusted to sort the "Total Score" column
                    const xValue = parseInt(xContent.split("/")[0]); // Extract numeric value
                    const yValue = parseInt(yContent.split("/")[0]); // Extract numeric value
                    if (dir === "asc" && xValue > yValue) {
                        shouldSwitch = true;
                        break;
                    } else if (dir === "desc" && xValue < yValue) {
                        shouldSwitch = true;
                        break;
                    }
                }
                // Handle string sorting for other columns
                else {
                    if (dir === "asc" && xContent > yContent) {
                        shouldSwitch = true;
                        break;
                    } else if (dir === "desc" && xContent < yContent) {
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
        updateIndex();
    }

    // Update the index after sorting
    function updateIndex() {
        const rows = document.querySelectorAll('#scoring-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1; // Update index cell
        });
    }

    // Search function for archer names
    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#scoring-table tr');

        let visibleIndex = 1; // Initialize index to start from 1

        rows.forEach(function (row) {
            const name = row.cells[1].innerText.toLowerCase();
            if (name.includes(input)) {
                row.style.display = ''; // Show matching row
                row.cells[0].innerHTML = visibleIndex++; // Update index for visible rows
            } else {
                row.style.display = 'none'; // Hide non-matching row
            }
        });
    }

    // Function to generate PDF with autoTable
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Set font
        pdf.setFont("Arial");

        // Add logo
        const img = new Image();
        img.src = '/images/pmdkkLogo.png'; // Ensure the image path is correct
        img.onload = function () {
            pdf.addImage(img, 'PNG', 10, 15, 30, 30); // X, Y, Width, Height

            // Header text
            const textXPosition = 45;
            pdf.setFontSize(14.5);
            pdf.setFont("Arial", "bold");
            pdf.text("PERSATUAN MEMANAH DAERAH KOTA KINABALU (PMDKK)", textXPosition, 18);

            // Organization ID
            pdf.setFontSize(10);
            pdf.text("(D-SBH-03075)", textXPosition, 24);

            // Current date
            pdf.setFontSize(10);
            const today = new Date();
            const currentDate = `${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}-${today.getFullYear()}`; // Format: MM-DD-YYYY
            pdf.text(`Date: ${currentDate}`, textXPosition, 30);

            // Address and contact
            pdf.text("Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia.", textXPosition, 36);
            pdf.text("Email: pmdkk2015@gmail.com", textXPosition, 42);
            pdf.text("Contact: 088-794 327", pdf.internal.pageSize.width - 45, 42);

            // Title
            pdf.setFontSize(14);
            pdf.setFont("Arial", "bold");
            pdf.text('Scoring History of Enrolled Archers', 14, 55);

            // Define table headers (without Performance column)
            const headers = [['No.', 'Archer Name', 'Date', 'Distance', 'Total Score']];

            // Extract table data from HTML table, excluding Performance column
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

            // Create table in PDF
            pdf.autoTable({
                head: headers,
                body: tableRows,
                startY: 60, // Position to start table below header
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
                    fillColor: [169, 169, 169], // Grey for header
                    textColor: [255, 255, 255]  // White text for header
                },
                bodyStyles: {
                    fillColor: [255, 255, 255],
                    textColor: [0, 0, 0]
                }
            });

            // Add page numbers in the footer
            const pageCount = pdf.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                pdf.setPage(i);
                pdf.setFontSize(10);
                const pageText = `Page ${i} of ${pageCount}`;
                const pageWidth = pdf.internal.pageSize.width;
                const textWidth = pdf.getTextWidth(pageText);
                pdf.text(pageText, (pageWidth - textWidth) / 2, pdf.internal.pageSize.height - 10); // Center-aligned
            }

            // Save the PDF file with a dynamic filename
            pdf.save(`scoring_history_${currentDate}.pdf`);
        };
    });

    document.getElementById('export-excel').addEventListener('click', function () {
        // Collect visible rows for the Excel sheet
        const tableRows = Array.from(document.querySelectorAll('#scoringTable tbody tr'))
            .filter(row => row.style.display !== 'none') // Include only visible rows
            .map((row, index) => {
                const cells = Array.from(row.cells);
                return [
                    index + 1, // Index
                    cells[1]?.innerText || '', // Archer Name
                    cells[2]?.innerText || '', // Date
                    cells[3]?.innerText || '', // Distance
                    cells[4]?.innerText || ''  // Total Score
                ];
            });

        // Add table headers
        const headers = ['No.', 'Archer Name', 'Date', 'Distance', 'Total Score'];
        tableRows.unshift(headers);

        // Create worksheet and workbook
        const worksheet = XLSX.utils.aoa_to_sheet(tableRows);

        // Adjust column widths for better readability
        worksheet['!cols'] = [
            { wch: 5 },   // No.
            { wch: 25 },  // Archer Name
            { wch: 15 },  // Date
            { wch: 15 },  // Distance
            { wch: 15 }   // Total Score
        ];

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'ScoringHistory');

        // Generate a filename with the current date
        const today = new Date();
        const currentDate = `${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}-${today.getFullYear()}`;
        const filename = `scoring_history_${currentDate}.xlsx`;

        // Export to Excel
        XLSX.writeFile(workbook, filename);
    });
</script>

</body>
</html>
