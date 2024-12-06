<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Attendance More</title>
    <!-- External CSS and Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            overflow-x: hidden;
            padding: 20px;
        }

        .attendance-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .attendance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .attendance-list-header {
            text-align: left;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .header-text {
            font-size: 20px;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;  /* Align buttons to the right */
            gap: 10px;  /* Add some space between the buttons */
            margin-left: 500px;
        }

        /* PDF Button Styles */
        .btn-pdf {
            background-color: #dc3545 !important;
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
            background-color: #b22222 !important;
            color: #f8d7da !important;
        }

        /* Excel Button Styles */
        .btn-excel {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-excel:hover {
            background-color: #218838;
        }

        .btn-container {
            display: flex;
            justify-content: center;
        }

        .filter-search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            margin-top: 40px;
        }

        .filter-container select,
        .search-wrapper input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
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

        .attendance-table-container {
            width: 100%;
            margin: 20px auto;
            max-height: 420px;
            overflow-y: auto;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            background-color: white;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        .attendance-table-container {
            width: 100%;
            margin: 20px auto;
            max-height: 420px; /* This will make the table scrollable after 10 rows */
            overflow-y: auto;  /* Enables vertical scrolling */
        }

        .attendance-table th,
        .attendance-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #e1e1e1;
        }

        .attendance-table th {
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        .attendance-table td {
            background-color: #f9f9f9;
            vertical-align: middle;
        }

        .attendance-table th.sortable:hover {
            background-color: #555;
        }

        .btn-view {
            background-color: #5f4bb6;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-view:hover {
            background-color: #3b1f8b;
        }

        /* Back Button Styles */
        .back-btn {
            background-color: #5f4bb6;  /* Purple background to match the theme */
            color: white;  /* White text */
            padding: 10px 20px;  /* Padding for a larger, clickable area */
            text-decoration: none;  /* Remove underline */
            border-radius: 5px;  /* Rounded corners */
            font-weight: 600;  /* Slightly bolder text */
            transition: background-color 0.3s ease;  /* Smooth hover transition */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Subtle shadow for depth */
        }

        /* Back Button Hover Effect */
        .back-btn:hover {
            background-color: #4831a6;  /* Darker shade on hover */
            text-decoration: none;  /* Keep text-decoration off during hover */
            color: white;  /* Ensure white text on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .attendance-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-container {
                width: 100%;
                justify-content: space-between;
            }

            .filter-container select {
                width: calc(50% - 5px);
            }

            .search-wrapper input {
                font-size: 14px;
            }

            .attendance-table-container {
                max-height: 300px;
            }

            .attendance-table th,
            .attendance-table td {
                font-size: 12px;
                padding: 8px;
            }

            .btn-view {
                font-size: 12px;
                padding: 6px 10px;
            }
        }

        @media (max-width: 480px) {
            .filter-search-container {
                flex-direction: column;
                gap: 15px;
            }

            .filter-container {
                flex-direction: row;
                justify-content: space-between;
                width: 100%;
            }

            .filter-container select {
                font-size: 12px;
                padding: 6px;
            }

            .search-wrapper input {
                font-size: 12px;
                padding: 6px;
            }

            .attendance-table-container {
                max-height: 250px;
            }

            .attendance-table th,
            .attendance-table td {
                font-size: 10px;
                padding: 5px;
            }

            .btn-download {
                font-size: 10px;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.coachHeader')
</header>

<div class="attendance-container">
        <!-- Attendance Detail Header -->
        <div class="attendance-header">
        <div class="header-text">
            <strong>Attendance Details for</strong><br>
            <strong>User:</strong> {{ $archer->account->account_full_name }}<br>
            <strong>ID:</strong> {{ $archer->membership_id }}
        </div>
        <div class="btn-container">
            <!-- PDF Download Button -->
            <button id="generate-pdf" class="btn-download btn-pdf">Download PDF</button>
            <!-- Excel Export Button -->
            <button id="export-excel" class="btn-download btn-excel">Export to Excel</button>
        </div>
            <a href="#" onclick="window.history.back();" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <!-- Detailed Attendance Table -->
        <div class="attendance-table-container">
            <table class="attendance-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="sortable" data-type="text">Attendance Status <i class="fas fa-sort"></i></th>
                        <th class="sortable" data-type="text">Attendance Date <i class="fas fa-sort"></i></th>
                        <th class="sortable" data-type="text">Check-in Time <i class="fas fa-sort"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendanceRecords as $index => $attendance)
                        @php
                            $attendanceDate = \Carbon\Carbon::parse($attendance->attendance_date)->format('Y-m-d');
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($attendance->attendance_status) }}</td>
                            <td data-date="{{ $attendanceDate }}">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('F d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</div>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // Sort the table based on column
    function sortTable(n) {
        if (n === 0) return; // Prevent sorting on the index column (column 0)

        const table = document.querySelector('.attendance-table');
        const rows = Array.from(table.rows).slice(1); // Exclude header row
        const isAscending = table.querySelectorAll('th')[n].classList.contains('asc');

        // Sorting based on the data type (text or number)
        const type = table.querySelectorAll('th')[n].getAttribute('data-type');
        
        rows.sort((rowA, rowB) => {
            const cellA = rowA.cells[n];
            const cellB = rowB.cells[n];

            let comparison = 0;

            if (type === 'num') {
                comparison = parseInt(cellA.innerText) - parseInt(cellB.innerText);
            } else if (type === 'date') {
                // Compare dates (stored in data-date attribute)
                const dateA = new Date(cellA.getAttribute('data-date')); // Parse the date string as Date object
                const dateB = new Date(cellB.getAttribute('data-date'));
                
                // Handle invalid dates gracefully
                if (isNaN(dateA)) dateA = new Date(0); // Default to a very early date if invalid
                if (isNaN(dateB)) dateB = new Date(0); // Default to a very early date if invalid

                comparison = dateA - dateB; // Compare full date (year, month, and day)
            } else {
                if (cellA.innerText.trim() < cellB.innerText.trim()) comparison = -1;
                if (cellA.innerText.trim() > cellB.innerText.trim()) comparison = 1;
            }

            return isAscending ? comparison : -comparison;
        });

        // Reorder rows and update index
        rows.forEach((row, index) => {
            row.cells[0].innerText = index + 1; // Set dynamic index to 1-based
            table.appendChild(row); // Reorder rows
        });

        // Toggle the sorting state and update icons
        const th = table.querySelectorAll('th')[n];
        const icons = th.querySelectorAll('i');
        
        // Remove all icons before adding the new one
        icons.forEach(icon => icon.classList.remove('fa-sort', 'fa-sort-up', 'fa-sort-down'));

        // Add new sorting icon
        if (isAscending) {
            th.classList.remove('asc');
            th.classList.add('desc');
            icons[0].classList.add('fa-sort-down');
        } else {
            th.classList.remove('desc');
            th.classList.add('asc');
            icons[0].classList.add('fa-sort-up');
        }
    }

    // Attach sorting only to sortable columns
    document.querySelectorAll('.attendance-table th.sortable').forEach((th, index) => {
        th.addEventListener('click', () => sortTable(index + 1)); // Start sorting from index 1, not 0
    });

    // Function to generate PDF with autoTable
    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Set the font
        pdf.setFont("Arial");

        // Add the logo
        const img = new Image();
        img.src = '/images/pmdkkLogo.png'; // Ensure the image path is correct

        img.onload = function () {
            pdf.addImage(img, 'PNG', 10, 15, 30, 30); // X, Y, Width, Height

            // Add header details
            const textXPosition = 45;
            pdf.setFontSize(14.5);
            pdf.setFont("Arial", "bold");
            pdf.text("PERSATUAN MEMANAH DAERAH KOTA KINABALU (PMDKK)", textXPosition, 18);
            pdf.setFontSize(10);
            pdf.text("(D-SBH-03075)", textXPosition, 24);

            // Add date and address details
            const today = new Date();
            const currentDate = `${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}-${today.getFullYear()}`;
            pdf.text(`Date: ${currentDate}`, textXPosition, 30);
            pdf.text("Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia.", textXPosition, 36);
            pdf.text("Email: pmdkk2015@gmail.com", textXPosition, 42);
            pdf.text("Contact: 088-794 327", pdf.internal.pageSize.width - 45, 42);

            // Add the title with Blade variables
            // Use Blade to inject PHP values directly into JavaScript
            const archerName = "{{ $archer->account->account_full_name }}";
            const membershipId = "{{ $archer->membership_id }}";
            pdf.setFontSize(14);
            pdf.setFont("Arial", "bold");
            pdf.text(`Attendance Details for ${archerName} (ID: ${membershipId})`, 14, 55);

            // Define headers for the table
            const headers = [['No.', 'Attendance Status', 'Attendance Date', 'Check-in Time']];

            // Extract data from the HTML table
            const tableRows = [];
            const rows = document.querySelectorAll('.attendance-table tbody tr');
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1, // No.
                    cells[1].innerText, // Attendance Status
                    cells[2].innerText, // Attendance Date
                    cells[3].innerText, // Check-in Time
                ];
                tableRows.push(rowData);
            });

            // Generate the table in the PDF
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

            // Save the PDF
            pdf.save(`attendance_details_${membershipId}.pdf`);
        };
    });

    // Export to Excel function
   // Pass the PHP variable to JavaScript
    const membershipId = "{{ $archer->membership_id }}"; 

    // Export to Excel function
    document.getElementById('export-excel').addEventListener('click', function () {
        // Collect visible rows for the Excel sheet
        const tableRows = Array.from(document.querySelectorAll('.attendance-table tbody tr'))
            .map((row, index) => {
                const cells = Array.from(row.cells);
                return [
                    index + 1, // Index
                    cells[1]?.innerText || '', // Attendance Status
                    cells[2]?.innerText || '', // Attendance Date
                    cells[3]?.innerText || '', // Check-in Time
                ];
            });

        // Add table headers
        const headers = ['No.', 'Attendance Status', 'Attendance Date', 'Check-in Time'];
        tableRows.unshift(headers);

        // Create worksheet and workbook
        const worksheet = XLSX.utils.aoa_to_sheet(tableRows);

        // Adjust column widths for better readability
        worksheet['!cols'] = [
            { wch: 5 },   // No.
            { wch: 25 },  // Attendance Status
            { wch: 20 },  // Attendance Date
            { wch: 20 }   // Check-in Time
        ];

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'AttendanceList');

        // Generate a filename using the current membership ID
        const filename = `attendance_details_${membershipId}.xlsx`;

        // Export to Excel
        XLSX.writeFile(workbook, filename);
    });


    
</script>

</body>
</html>
