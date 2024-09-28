<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring Details</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .scoring-container {
            display: grid;
            grid-template-columns: 20% 80%;
            gap: 40px;
            max-width: 1400px;
            margin: 80px auto 0;
            padding: 20px;
        }

        .scoring-header {
            font-size: 28px;
            font-weight: bold;
            text-align: left;
            margin-bottom: 10px;
        }

        .scoring-header-line {
            border: 0;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .scoring-sidebar {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .scoring-sidebar div {
            margin-bottom: 30px;
        }

        .scoring-sidebar label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        .scoring-sidebar .input-box {
            background-color: #E0E0E0;
            padding: 15px;
            border-radius: 8px;
            font-size: 18px;
        }

        .scoring-form-container {
            background-color: #FFFFFF;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .scoring-form {
            display: flex;
            justify-content: flex-start;
            gap: 50px;
            margin-bottom: 20px;
        }

        .scoring-form label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        .scoring-form input {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: white;
            width: 100%;
        }

        .scoring-form-item {
            display: flex;
            flex-direction: column;
        }

        .scoring-form-item input#set, 
        .scoring-form-item input#distance {
            max-width: 100px;
        }

        .scoring-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        .scoring-table th, 
        .scoring-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 16px;
        }

        .scoring-table input {
            width: 50px;
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            text-align: center;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .notes-section {
            margin-top: 20px;
        }

        .notes-section textarea {
            width: 100%;
            height: 100px;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            background-color: white;
            resize: vertical;
            box-sizing: border-box;
        }

        /* Flexbox to align buttons */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* Back button */
        .back-btn {
            background-color: #3f51b5;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-btn:hover {
            background-color: #303f9f;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.25);
        }

        .back-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(63, 81, 181, 0.5);
        }
    </style>
</head>

<body>

<!-- Header -->
<header>
    @include('components.coachHeader')
</header>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
        <button class="close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<div class="scoring-container">
    <!-- Sidebar -->
    <div class="scoring-sidebar">
        <div>
            <label>Membership ID</label>
            <div class="input-box">
                {{ $score->membership_id }}
            </div>
        </div>

        <div>
            <label>Archer Name</label>
            <div class="input-box">
                {{ $archerName }}
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="scoring-form-container">
        <div class="scoring-header">Scoring Details</div>
        <hr class="scoring-header-line">

        <!-- Scoring details -->
        <div class="scoring-form">
            <div class="scoring-form-item">
                <label for="set">Set</label>
                <input type="number" name="set" id="set" value="{{ $score->set }}" readonly>
            </div>

            <div class="scoring-form-item">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" value="{{ $score->category }}" readonly>
            </div>

            <div class="scoring-form-item">
                <label for="distance">Distance</label>
                <input type="number" name="distance" id="distance" value="{{ $score->distance }}" readonly>
            </div>

            <div class="scoring-form-item">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="{{ \Carbon\Carbon::parse($score->date)->format('Y-m-d') }}" readonly>
            </div>
        </div>

        <!-- Score display table -->
        <table class="scoring-table">
            <thead>
                <tr>
                    <th>End</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Score</td>
                    <td><input type="number" name="score1" min="0" max="60" value="{{ $score->score1 }}" readonly></td>
                    <td><input type="number" name="score2" min="0" max="60" value="{{ $score->score2 }}" readonly></td>
                    <td><input type="number" name="score3" min="0" max="60" value="{{ $score->score3 }}" readonly></td>
                    <td><input type="number" name="score4" min="0" max="60" value="{{ $score->score4 }}" readonly></td>
                    <td><input type="number" name="score5" min="0" max="60" value="{{ $score->score5 }}" readonly></td>
                    <td><input type="number" name="score6" min="0" max="60" value="{{ $score->score6 }}" readonly></td>
                    <td><input type="number" name="total" value="{{ $score->total }}" readonly></td>
                </tr>
            </tbody>
        </table>

        <!-- Notes section -->
        <div class="notes-section">
            <label for="notes" style="font-weight: bold;">Notes: </label>
            <textarea name="notes" id="notes" readonly>{{ $score->notes }}</textarea>
        </div>

        <!-- Back button -->
        <div class="button-group" style="margin-top: 20px;">
            <a href="{{ route('coach.scoringHistoryArcher', $score->membership_id) }}" class="back-btn">Back</a>
        </div>
    </div>
</div>

</body>
</html>
