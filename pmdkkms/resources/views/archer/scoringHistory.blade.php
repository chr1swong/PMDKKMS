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
        <button id="generate-pdf" class="btn-download">Download PDF</button>
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

    {{ $scoringData->links() }}

    <a href="{{ route('archer.scoring') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<script>
    function sortTable(n) {
        const table = document.getElementById("scoringTable");
        let switching = true, dir = "asc", switchcount = 0;
        while (switching) {
            switching = false;
            let rows = table.rows;
            for (let i = 1; i < rows.length - 1; i++) {
                let shouldSwitch = false;
                const x = rows[i].getElementsByTagName("TD")[n];
                const y = rows[i + 1].getElementsByTagName("TD")[n];
                const xValue = n === 1 ? new Date(x.innerHTML) : parseInt(x.innerHTML);
                const yValue = n === 1 ? new Date(y.innerHTML) : parseInt(y.innerHTML);
                if (dir === "asc" ? xValue > yValue : xValue < yValue) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
        updateIndex();
    }

    function updateIndex() {
        const rows = document.querySelectorAll('#scoring-table tr');
        rows.forEach((row, index) => {
            row.cells[0].innerHTML = index + 1;
        });
    }

    document.getElementById('generate-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        const headers = [['No.', 'Date', 'Distance', 'Total Score']];

        const tableRows = [];
        const rows = document.querySelectorAll('#scoringTable tbody tr');

        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            const rowData = [
                index + 1,
                cells[1].innerText,
                cells[2].innerText,
                cells[3].innerText
            ];
            tableRows.push(rowData);
        });

        pdf.setFontSize(18);
        pdf.text('Scoring History', 14, 20);

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

        const currentDate = new Date().toISOString().split('T')[0];
        pdf.save(`scoring_history_${currentDate}.pdf`);
    });
</script>

</body>
</html>

