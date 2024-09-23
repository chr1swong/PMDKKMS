<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Archer</title>
    <!-- External CSS and Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container-wrapper {
            width: 100%;
            margin: 40px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-container {
            width: 80%;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        h1 {
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        .filter-search-container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;
            gap: 20px;
            margin-top: 10px;
        }

        .search-container input {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
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
            margin-top: 20px;
            width: 80%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            background-color: white;
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

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-enroll {
            background-color: #28a745;
            color: white;
        }

        .btn-unenroll {
            background-color: #ff4d4d;
            color: white;
        }

        .btn-view:hover, .btn-enroll:hover, .btn-unenroll:hover, .btn-delete:hover {
            opacity: 0.9;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background-color: #555;
        }

        @media (max-width: 768px) {
            .btn-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }

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
    </style>
</head>
<body>
    <header>
        @include('components.coachHeader')
    </header>

    <!-- Popup message -->
    @if(session('popupMessage'))
        <div class="alert alert-success" id="success-message">
            {{ session('popupMessage') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <div class="container-wrapper">
        <div class="header-container">
            <h1>My Archer</h1>
            <div class="filter-search-container">
                <div class="search-container">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="search-input" onkeyup="searchByName()" placeholder="Search by name...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table-container for displaying archers -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>MemberID</th>
                        <th>Membership Status</th>
                        <th>Performance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="archers-table">
                    <!-- Loop through enrolled archers -->
                    @foreach($enrolledArchers as $key => $archer)
                    <tr data-name="{{ strtolower($archer->account_full_name) }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $archer->account_full_name }}</td>
                        <!-- Format the member ID to 6 digits -->
                        <td>{{ str_pad($archer->membership_id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <!-- Display membership status -->
                            {{ $archer->membership_status == 1 ? 'Active' : 'Inactive' }}
                        </td>
                        <td>
                            <div class="btn-container">
                                <button class="btn btn-view">View Training Score</button>
                                <button class="btn btn-view">View Attendance Details</button>
                            </div>
                        </td>
                        <td>
                            <div class="btn-container">
                                <form action="{{ route('coach.unenrollArcher', $archer->account_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-unenroll">Unenroll</button>
                                </form>
                                <button class="btn btn-view">View Profile</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    <!-- Loop through unenrolled archers -->
                    @php $unenrollStart = count($enrolledArchers) + 1; @endphp
                    @foreach($unenrolledArchers as $key => $archer)
                    <tr data-name="{{ strtolower($archer->account_full_name) }}">
                        <td>{{ $unenrollStart + $key }}</td> <!-- Continue numbering -->
                        <td>{{ $archer->account_full_name }}</td>
                        <!-- Format the member ID to 6 digits -->
                        <td>{{ str_pad($archer->membership_id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <!-- Display membership status -->
                            {{ $archer->membership_status == 1 ? 'Active' : 'Inactive' }}
                        </td>
                        <td>
                            <div class="btn-container">
                                <button class="btn btn-view">View Training Score</button>
                                <button class="btn btn-view">View Attendance Details</button>
                            </div>
                        </td>
                        <td>
                            <div class="btn-container">
                                <form action="{{ route('coach.enrollArcher', $archer->account_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-enroll">Enroll</button>
                                </form>
                                <button class="btn btn-view">View Profile</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }

        function searchByName() {
            const input = document.getElementById("search-input").value.toLowerCase();
            const rows = document.querySelectorAll('#archers-table tr');

            rows.forEach(function (row) {
                const name = row.getAttribute('data-name');
                if (name.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
