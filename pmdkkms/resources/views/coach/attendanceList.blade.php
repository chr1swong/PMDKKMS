<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Archer Attendance</title>
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

        .attendance-list-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Flex container for header and button */
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

        /* Common Button Styles */
        .btn-download {
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 14px;
        }

        .hr-divider {
            border: none;
            border-top: 2px solid #e0e0e0;
            margin: 10px 0;
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

        .table-container {
            width: 100%;
            margin: 20px auto;
            max-height: 420px;
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

        table th.sortable:hover {
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

        .btn-container {
            display: flex;
            justify-content: center;
        }

        .btn-download {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-download:hover {
            background-color: #218838;
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

            .table-container {
                max-height: 300px;
            }

            table th, table td {
                font-size: 12px;
                padding: 8px;
            }

            .btn-view {
                font-size: 12px;
                padding: 6px 10px;
            }

            .btn-download {
                font-size: 12px;
                padding: 8px 15px;
                width: 100%;
                margin-top: 10px;
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

            .table-container {
                max-height: 250px;
            }

            table th, table td {
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

<div class="attendance-list-container" id="attendance-list">
    <div class="attendance-header">
        <h1 class="attendance-list-header">Archer Attendance for {{ $filterMonth }} {{ $filterYear }}</h1>
        <div class="btn-container">
            <!-- PDF Download Button -->
            <button id="generate-pdf" class="btn-download btn-pdf">Download PDF</button>
            <!-- Excel Export Button -->
            <button id="export-excel" class="btn-download btn-excel">Export to Excel</button>
        </div>
    </div>
    <hr class="hr-divider">

    <!-- Filter and Search -->
    <div class="filter-search-container">
        <div class="filter-container">
            <form method="GET" action="{{ route('coach.attendanceList') }}">
                <!-- Month Filter -->
                <select id="attendance-filter" name="attendance-filter" onchange="this.form.submit()">
                    <option value="January" {{ request('attendance-filter', $filterMonth) == 'January' ? 'selected' : '' }}>January</option>
                    <option value="February" {{ request('attendance-filter', $filterMonth) == 'February' ? 'selected' : '' }}>February</option>
                    <option value="March" {{ request('attendance-filter', $filterMonth) == 'March' ? 'selected' : '' }}>March</option>
                    <option value="April" {{ request('attendance-filter', $filterMonth) == 'April' ? 'selected' : '' }}>April</option>
                    <option value="May" {{ request('attendance-filter', $filterMonth) == 'May' ? 'selected' : '' }}>May</option>
                    <option value="June" {{ request('attendance-filter', $filterMonth) == 'June' ? 'selected' : '' }}>June</option>
                    <option value="July" {{ request('attendance-filter', $filterMonth) == 'July' ? 'selected' : '' }}>July</option>
                    <option value="August" {{ request('attendance-filter', $filterMonth) == 'August' ? 'selected' : '' }}>August</option>
                    <option value="September" {{ request('attendance-filter', $filterMonth) == 'September' ? 'selected' : '' }}>September</option>
                    <option value="October" {{ request('attendance-filter', $filterMonth) == 'October' ? 'selected' : '' }}>October</option>
                    <option value="November" {{ request('attendance-filter', $filterMonth) == 'November' ? 'selected' : '' }}>November</option>
                    <option value="December" {{ request('attendance-filter', $filterMonth) == 'December' ? 'selected' : '' }}>December</option>
                </select>

                <!-- Year Filter -->
                <select id="year-filter" name="year-filter" onchange="this.form.submit()">
                    @for ($year = now()->year; $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request('year-filter', $filterYear) == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </form>
        </div>

        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name..">
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="table-container">
        <table id="attendanceTable">
            <thead>
                <tr>
                    <th>No.</th> <!-- Index column without sorter -->
                    <th class="sortable" data-type="alpha">Name <i class="fas fa-sort"></i></th>
                    <th class="sortable" data-type="num">MemberID <i class="fas fa-sort"></i></th>
                    <th class="sortable" data-type="alpha">Attendance <i class="fas fa-sort"></i></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="attendance-table">
            @if($attendanceSummary->isEmpty())
                <tr>
                    <td colspan="5">No attendance records found for {{ $filterMonth }} {{ $filterYear }}.</td>
                </tr>
            @else
                @foreach($attendanceSummary as $key => $summary)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $summary['membership']->account->account_full_name }}</td>
                    <td>{{ $summary['membership']->membership_id }}</td>
                    <td><span class="attendance-summary">{{ $summary['presentCount'] }}/{{ $summary['daysInMonth'] }}</span></td>
                    <td>
                        <div class="btn-container">
                            <!-- Pass the referrer parameter -->
                            <a href="{{ route('coach.attendanceView', ['membership_id' => $summary['membership']->membership_id, 'referrer' => 'attendanceList']) }}" class="btn btn-view">View Attendance Details</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

</div>

<!-- jsPDF and autoTable libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // Function to search rows by name
    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#attendance-table tr');

        let visibleIndex = 1; // Initialize index to start from 1

        rows.forEach(function (row) {
            const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            if (name.includes(input)) {
                row.style.display = '';  // Show the row if it matches
                row.cells[0].innerHTML = visibleIndex++; // Update index for visible rows
            } else {
                row.style.display = 'none';  // Hide the row if it doesn't match
            }
        });
    }

    // Function to sort the table
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', () => {
            const table = document.getElementById('attendanceTable');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const type = header.getAttribute('data-type');
            const index = Array.from(header.parentNode.children).indexOf(header);
            let direction = header.dataset.sortDirection || 'asc';
            direction = direction === 'asc' ? 'desc' : 'asc';
            header.dataset.sortDirection = direction;

            rows.sort((a, b) => {
                const aValue = a.querySelectorAll('td')[index].innerText;
                const bValue = b.querySelectorAll('td')[index].innerText;

                if (type === 'num') {
                    return direction === 'asc' ? aValue - bValue : bValue - aValue;
                } else {
                    return direction === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
                }
            });

            rows.forEach(row => table.querySelector('tbody').appendChild(row));
            updateIndex(); // Recalculate index numbers after sorting
        });
    });

    // Function to recalculate index numbers
    function updateIndex() {
        const rows = document.querySelectorAll('#attendance-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1; // Update index cell
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
            const today = new Date();
            const currentDate = `${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}-${today.getFullYear()}`; // Format: MM-DD-YYYY
            pdf.text(`Date: ${currentDate}`, textXPosition, 30);

            // Address
            pdf.setFontSize(10);
            pdf.text("Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia.", textXPosition, 36);

            // Email and Contact Information
            pdf.text("Email: pmdkk2015@gmail.com", textXPosition, 42);
            pdf.text("Contact: 088-794 327", pdf.internal.pageSize.width - 45, 42); 

            // Title
            pdf.setFontSize(14);
            pdf.setFont("Arial", "bold");
            pdf.text(`Archer Attendance for {{ $filterMonth }} {{ $filterYear }}`, 14, 55);

            // Table headers
            const headers = [['No.', 'Name', 'MemberID', 'Coach', 'Attendance']];

            // Get table data
            const tableRows = [];
            const rows = document.querySelectorAll('#attendanceTable tbody tr');
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1, // No.
                    cells[1].innerText, // Name
                    cells[2].innerText, // MemberID
                    cells[3].innerText, // Coach
                    cells[4].innerText  // Attendance
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
            pdf.save(`attendance_list_{{ $filterMonth }}_{{ $filterYear }}.pdf`);
        };
    });

    document.getElementById('export-excel').addEventListener('click', function () {
        // Collect visible rows for the Excel sheet
        const tableRows = Array.from(document.querySelectorAll('#attendanceTable tbody tr'))
            .filter(row => row.style.display !== 'none') // Include only visible rows
            .map((row, index) => {
                const cells = Array.from(row.cells);
                return [
                    index + 1, // Index
                    cells[1]?.innerText || '', // Name
                    cells[2]?.innerText || '', // MemberID
                    cells[3]?.innerText || '', // Attendance
                ];
            });

        // Add table headers
        const headers = ['No.', 'Name', 'MemberID', 'Attendance'];
        tableRows.unshift(headers);

        // Create worksheet and workbook
        const worksheet = XLSX.utils.aoa_to_sheet(tableRows);

        // Adjust column widths for better readability
        worksheet['!cols'] = [
            { wch: 5 },   // No.
            { wch: 25 },  // Name
            { wch: 15 },  // MemberID
            { wch: 15 }   // Attendance
        ];

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'AttendanceList');

        // Generate a filename with the current month and year
        const filename = `attendance_list_{{ $filterMonth }}_{{ $filterYear }}.xlsx`;

        // Export to Excel
        XLSX.writeFile(workbook, filename);
    });
</script>

</body>
</html>
