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

        .attendance-list-header {
            text-align: left;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
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

        @media (max-width: 768px) {
            .filter-search-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-container {
                max-height: 300px;
            }
        }
    </style>
</head>
<body>

<header>
    @include('components.coachHeader')
</header>

<div class="attendance-list-container">
    <h1 class="attendance-list-header">Archer Attendance for {{ $filterMonth }} {{ $filterYear }}</h1>
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
                    <th class="sortable" data-type="num">No. <i class="fas fa-sort"></i></th>
                    <th class="sortable" data-type="alpha">Name <i class="fas fa-sort"></i></th>
                    <th class="sortable" data-type="num">MemberID <i class="fas fa-sort"></i></th>
                    <th class="sortable" data-type="attendance">Attendance <i class="fas fa-sort"></i></th>
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

<script>
    // Function to search rows by name
    function searchByName() {
        const input = document.getElementById("search-input").value.toLowerCase();
        const rows = document.querySelectorAll('#attendance-table tr');

        rows.forEach(function (row) {
            const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            if (name.includes(input)) {
                row.style.display = '';  // Show the row if it matches
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
        });
    });
</script>

</body>
</html>
