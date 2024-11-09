<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics List</title>
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

        .analytics-container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .analytics-header {
            font-size: 28px;
            font-weight: bold;
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
            cursor: pointer;
            width: 140px;
        }

        .btn-view-analytics {
            background-color: #5f4bb6;
            color: white;
        }

        .btn-view-analytics:hover {
            background-color: #3b1f8b;
        }
    </style>
</head>
<body>

<header>
    @include('components.committeeHeader') 
</header>

<div class="analytics-container">
    <div class="header-row">
        <h1 class="analytics-header">Analytics List</h1>
    </div>
    <hr class="hr-divider">

    <!-- Analytics List Table -->
    <div class="table-container">
        <table id="analyticsTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Coach</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="analytics-table">
                @foreach($members as $key => $member)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $member->account_full_name }}</td>
                    <td>{{ $member->coach_name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('committee.analyticsDetails', ['archerId' => $member->account_id]) }}" class="btn btn-view-analytics">
                            View Analytics
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>