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
            overflow-x: hidden; 
            background-color: #f4f4f4;
            margin: 0;
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

        .membership-id {
            background-color: #E0E0E0;
            padding: 10px;
            border-radius: 8px;
            font-size: 18px;
            max-width: 150px;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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

        /* PDF and Excel Button Styles */
        .btn-pdf {
            background-color: #dc3545; /* Red for PDF */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-pdf:hover {
            background-color: #b22222 !important; /* Darker red */
            color: #f8d7da; /* Light text color */
        }

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
            margin-bottom: 20px;
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

        /* Success message styling */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

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

        /*Responsive Adjustments */
        @media (max-width: 768px) {
            .scoring-history-container {
                padding: 15px;
                border-radius: 8px;
                text-align: center;
            }

            .scoring-header {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .filter-container {
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: flex-start; /* Align all elements to the left */
                width: 100%; /* Ensure the container takes full width */
            }

            .membership-id {
                font-size: 14px;
                text-align: left;
                margin-bottom: 10px;
                width: 100%; /* Make it full width */
            }
            
            .filter-container form {
                display: flex;
                flex-wrap: nowrap;
                gap: 10px;
                justify-content: flex-start; /* Align the date fields and button to the left */
                width: 100%; /* Ensure the form takes full width */
            }

            .filter-container input {
                width: auto; /* Adjust width to fit content */
                max-width: 130px; /* Limit maximum width */
                font-size: 14px;
            }

            .filter-container button {
                width: auto; /* Adjust width to fit content */
                max-width: 100px; /* Limit maximum width */
                font-size: 14px;
            }

            .btn {
                font-size: 12px;
                padding: 8px 10px;
                width: 100%;
                max-width: 150px;
                margin: 5px auto;
            }

            .back-btn {
                width: 90%;
                max-width: 300px;
                padding: 10px 15px;
                font-size: 14px;
                margin: 15px auto;
                text-align: center;
            }

            /* Responsive adjustments for the table */
            .table-container {
                max-height: 300px; /* Adjust max height for smaller screens */
                overflow-y: auto; /* Keep vertical scrolling */
            }

            table th, table td {
                font-size: 14px; /* Reduce font size for better fit */
                padding: 8px; /* Reduce padding for compact layout */
            }

            table th {
                cursor: pointer;
            }

            .btn-view {
                font-size: 12px;
                padding: 8px 12px;
                max-width: 100px; /* Adjust button size */
            }
        }   
    </style>
</head>
<body>

<header>
    @include('components.archerHeader') 
</header>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
        <button class="close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<div class="scoring-history-container">
    <div class="scoring-header">
        <h1 class="scoring-history-header">Scoring History</h1>
        <div>
            <button id="generate-pdf" class="btn-pdf">Download PDF</button>
            <button id="export-excel" class="btn-excel">Export to Excel</button>
        </div>
    </div>

    <hr class="hr-divider">

    <div class="filter-container">
        <div>
            <label for="membership-id">Membership ID</label>
            <div class="membership-id">
                {{ $membership_id }}
            </div>
        </div>

        <div>
            <form action="{{ route('archer.scoringHistory') }}" method="GET">
                <input type="date" name="start-date" id="start-date" value="{{ request('start-date') }}">
                <input type="date" name="end-date" id="end-date" value="{{ request('end-date') }}">
                <button type="submit">Filter</button>
            </form>
        </div>
    </div>

    <div class="table-container">
        <table id="scoringTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th onclick="sortTable(1)">Date <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">Distance <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Total Score <i class="fas fa-sort"></i></th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody id="scoring-table">
                @forelse($scoringData as $index => $score)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($score->date)->format('d F Y') }}</td>
                        <td>{{ $score->distance }}M</td>
                        <td>{{ $score->overall_total }}/360</td>
                        <td>
                            <a href="{{ route('scoring.details', $score->id) }}" class="btn btn-view">View Scoring Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No scoring records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <a href="{{ route('archer.scoring') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    function sortTable(n) {
        const table = document.getElementById("scoringTable");
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr')); // Convert rows to an array
        let direction = table.dataset.sortDirection === 'asc' ? 'desc' : 'asc'; // Toggle sort direction
        table.dataset.sortDirection = direction;

        // Sorting logic
        rows.sort((rowA, rowB) => {
            let cellA = rowA.cells[n].textContent.trim();
            let cellB = rowB.cells[n].textContent.trim();
            let comparison = 0;

            // Handle date sorting
            if (n === 1) {
                cellA = new Date(cellA);
                cellB = new Date(cellB);
                comparison = cellA - cellB;
            }
            // Handle numeric sorting for distance and total score
            else if (n === 2 || n === 3) {
                cellA = parseInt(cellA.replace(/[^0-9]/g, ""), 10); // Remove non-numeric characters
                cellB = parseInt(cellB.replace(/[^0-9]/g, ""), 10); // Remove non-numeric characters
                comparison = cellA - cellB;
            } 
            // Handle string comparison
            else {
                comparison = cellA.localeCompare(cellB);
            }

            return direction === 'asc' ? comparison : -comparison;
        });

        // Rebuild the tbody with the sorted rows
        rows.forEach(row => tbody.appendChild(row));

        // Recalculate index numbers after sorting
        updateIndex();
    }

    // Update index numbers after sorting
    function updateIndex() {
        const rows = document.querySelectorAll('#scoring-table tr');
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }

    // Call updateIndex on page load
    window.onload = updateIndex;

    
    // Generate PDF
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Add logo and header information
        const img = new Image();
        img.src = '/images/pmdkkLogo.png';
        
        img.onload = function () {
            // Insert logo in the PDF
            pdf.addImage(img, 'PNG', 10, 15, 30, 30);

            // Add Organization details
            const textXPosition = 45;
            pdf.setFontSize(14.5);
            pdf.setFont("Arial", "bold");
            pdf.text("PERSATUAN MEMANAH DAERAH KOTA KINABALU (PMDKK)", textXPosition, 18);
            
            pdf.setFontSize(10);
            pdf.text("(D-SBH-03075)", textXPosition, 24);

            const today = new Date();
            const currentDate = `${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}-${today.getFullYear()}`;
            pdf.text(`Date: ${currentDate}`, textXPosition, 30);

            pdf.text("Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia.", textXPosition, 36);
            pdf.text("Email: pmdkk2015@gmail.com", textXPosition, 42);
            pdf.text("Contact: 088-794 327", pdf.internal.pageSize.width - 45, 42);

            // Title of the document
            pdf.setFontSize(14);
            pdf.setFont("Arial", "bold");
            pdf.text('Scoring History', 14, 55);

            // Define table headers (excluding the "Performance" column)
            const headers = [['No.', 'Date', 'Distance', 'Total Score']];

            // Capture visible rows in the scoring table for the PDF
            const tableRows = [];
            const rows = document.querySelectorAll('#scoringTable tbody tr');

            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1, // Serial Number
                    cells[1].innerText, // Date
                    cells[2].innerText, // Distance
                    cells[3].innerText  // Total Score
                ];
                tableRows.push(rowData);
            });

            // Add the table with data to the PDF
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
        // Get all visible rows in the table
        const rows = Array.from(document.querySelectorAll('#scoringTable tbody tr'))
            .filter(row => row.style.display !== 'none') // Only include visible rows
            .map((row, index) => {
                const cells = Array.from(row.cells);
                return [
                    index + 1, // Visible row index
                    cells[1]?.innerText || '', // Date
                    cells[2]?.innerText || '', // Distance
                    cells[3]?.innerText || ''  // Total Score
                ];
            });

        // Add table headers
        const headers = ['No.', 'Date', 'Distance', 'Total Score'];
        rows.unshift(headers);

        // Create worksheet and workbook
        const worksheet = XLSX.utils.aoa_to_sheet(rows);

        // Adjust column widths for better readability
        worksheet['!cols'] = [
            { wch: 5 },   // No.
            { wch: 20 },  // Date
            { wch: 15 },  // Distance
            { wch: 15 }   // Total Score
        ];

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'ScoringHistory');

        // Generate a filename with the current date
        const date = new Date().toISOString().split('T')[0];
        XLSX.writeFile(workbook, `scoring_history_${date}.xlsx`);
    });
</script>

</body>
</html>

