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
            margin-bottom: 30px;
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

        .btn-view {
            background-color: #5f4bb6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
    </style>
</head>
<body>

<header>
    @include('components.coachHeader') 
</header>

<div class="scoring-history-container">
    <h1 class="scoring-history-header">Scoring History of Your Archer</h1>

    <!-- Filter Form -->
    <div class="filter-container">
        <form action="{{ route('coach.scoringHistoryArcher', $membership_id) }}" method="GET">
            <input type="date" name="start-date" value="{{ request('start-date') }}">
            <input type="date" name="end-date" value="{{ request('end-date') }}">
            <button type="submit">Filter</button>
        </form>
    </div>

    <!-- Scoring History Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Set</th>
                    <th>Distance</th>
                    <th>Total Score</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scoringData as $index => $score)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($score->date)->format('d F Y') }}</td>
                        <td>{{ $score->category }}</td>
                        <td>{{ $score->set }}</td>
                        <td>{{ $score->distance }}M</td>
                        <td>{{ $score->total }}/360</td>
                        <td>
                            <a href="{{ route('scoring.details', $score->id) }}" class="btn-view">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No scoring records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $scoringData->links() }}

    <!-- Back Button -->
    <a href="{{ route('coach.myArcher') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

</body>
</html>
