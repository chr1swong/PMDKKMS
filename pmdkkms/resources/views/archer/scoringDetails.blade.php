<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Details</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        header {
            width: 100%;
            background-color: #001f3f;
            padding: 10px 0;
            display: flex;
            justify-content: center;
        }

        .main-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            max-width: 1300px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            margin-top: 20px;
            align-items: center;
            justify-content: center;
        }

        .right-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            max-width: 460px;
            box-sizing: border-box;
        }

        .image-container {
            width: 800px;
            height: 800px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 90px repeat(6, 1fr) 80px;
            gap: 10;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .grid-item {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            font-weight: 600;
            background-color: white;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .grid-item:nth-child(8n+1) {
            background-color: #2196f3;
            color: white;
            font-weight: 700;
        }

        .total-cell {
            background-color: #e0e0e0;
            font-weight: 700;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            font-size: 16px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            max-width: 150px;
        }

        .btn-back {
            background-color: #757575;
            color: white;
        }

        .btn-back:hover {
            background-color: #616161;
        }

        .score-summary {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
        }

        .info-container {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .info-container p {
            margin: 5px 0;
        }

        .notes-section {
            margin-top: 10px;
        }

        .notes-section label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        .notes-section textarea {
            width: 100%;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: white;
            resize: none;
            height: 100px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
        .main-container {
            display: flex;
            flex-direction: column; /* Stack the image and the right column */
            align-items: center; /* Center align the items */
            gap: 20px; /* Add some gap between the image and the right column */
        }

        .image-container {
            width: 100%; /* Make the image container full width */
            max-width: 350px; /* Limit the maximum width */
            height: auto; /* Adjust height automatically to maintain aspect ratio */
        }

        .right-column {
            width: 100%; /* Make the right column full width */
            max-width: 400px; /* Limit the maximum width */
            box-sizing: border-box;
        }

        .grid-container {
            grid-template-columns: 80px repeat(6, 1fr) 70px; /* Adjust the columns for better fit */
            gap: 5px; /* Reduce the gap for smaller screens */
        }

        .btn {
            font-size: 14px; /* Reduce font size for buttons */
            padding: 10px 16px; /* Adjust padding for smaller buttons */
            max-width: 120px; /* Limit the button width */
        }
    }
    </style>
</head>
<body>

<header>
    @include('components.archerHeader')
</header>

<div class="main-container">
    <!-- Display the submitted canvas image -->
    <div class="image-container">
        <img src="{{ asset('images/scoring/' . $score->canvas_image) }}" alt="Scoring Target">
    </div>

    <div class="right-column">
        <!-- Score Info Section -->
        <div class="info-container">
        <p><strong>Name:</strong> <span id="full-name">{{ $fullName }}</span></p>
            <p><strong>Distance:</strong> {{ $score->distance }} meters</p>
            <p><strong>Date:</strong> {{ $score->date }}</p>
        </div>

        <!-- Grid Container -->
        <div class="grid-container">
            <div class="grid-item">Set 1</div>
            <div class="grid-item">{{ $score->set1_score1 }}</div>
            <div class="grid-item">{{ $score->set1_score2 }}</div>
            <div class="grid-item">{{ $score->set1_score3 }}</div>
            <div class="grid-item">{{ $score->set1_score4 }}</div>
            <div class="grid-item">{{ $score->set1_score5 }}</div>
            <div class="grid-item">{{ $score->set1_score6 }}</div>
            <div class="grid-item total-cell">{{ $score->set1_total }}</div>

            <div class="grid-item">Set 2</div>
            <div class="grid-item">{{ $score->set2_score1 }}</div>
            <div class="grid-item">{{ $score->set2_score2 }}</div>
            <div class="grid-item">{{ $score->set2_score3 }}</div>
            <div class="grid-item">{{ $score->set2_score4 }}</div>
            <div class="grid-item">{{ $score->set2_score5 }}</div>
            <div class="grid-item">{{ $score->set2_score6 }}</div>
            <div class="grid-item total-cell">{{ $score->set2_total }}</div>

            <div class="grid-item">Set 3</div>
            <div class="grid-item">{{ $score->set3_score1 }}</div>
            <div class="grid-item">{{ $score->set3_score2 }}</div>
            <div class="grid-item">{{ $score->set3_score3 }}</div>
            <div class="grid-item">{{ $score->set3_score4 }}</div>
            <div class="grid-item">{{ $score->set3_score5 }}</div>
            <div class="grid-item">{{ $score->set3_score6 }}</div>
            <div class="grid-item total-cell">{{ $score->set3_total }}</div>

            <div class="grid-item">Set 4</div>
            <div class="grid-item">{{ $score->set4_score1 }}</div>
            <div class="grid-item">{{ $score->set4_score2 }}</div>
            <div class="grid-item">{{ $score->set4_score3 }}</div>
            <div class="grid-item">{{ $score->set4_score4 }}</div>
            <div class="grid-item">{{ $score->set4_score5 }}</div>
            <div class="grid-item">{{ $score->set4_score6 }}</div>
            <div class="grid-item total-cell">{{ $score->set4_total }}</div>

            <div class="grid-item">Set 5</div>
            <div class="grid-item">{{ $score->set5_score1 }}</div>
            <div class="grid-item">{{ $score->set5_score2 }}</div>
            <div class="grid-item">{{ $score->set5_score3 }}</div>
            <div class="grid-item">{{ $score->set5_score4 }}</div>
            <div class="grid-item">{{ $score->set5_score5 }}</div>
            <div class="grid-item">{{ $score->set5_score6 }}</div>
            <div class="grid-item total-cell">{{ $score->set5_total }}</div>

            <div class="grid-item">Set 6</div>
            <div class="grid-item">{{ $score->set6_score1 }}</div>
            <div class="grid-item">{{ $score->set6_score2 }}</div>
            <div class="grid-item">{{ $score->set6_score3 }}</div>
            <div class="grid-item">{{ $score->set6_score4 }}</div>
            <div class="grid-item">{{ $score->set6_score5 }}</div>
            <div class="grid-item">{{ $score->set6_score6 }}</div>
            <div class="grid-item total-cell">{{ $score->set6_total }}</div>

            <div class="grid-item total-cell" style="grid-column: span 7; text-align: right;">
                Overall Total
            </div>
            <div class="grid-item total-cell">{{ $score->overall_total }}</div>
        </div>

        <div class="score-summary">
            <p>
                <strong>X:</strong> <span style="font-weight: normal;">{{ $score->x_count }}</span>,&nbsp;&nbsp;&nbsp;
                <strong>10:</strong> <span style="font-weight: normal;">{{ $score->ten_count }}</span>,&nbsp;&nbsp;&nbsp;
                <strong>X+10:</strong> <span style="font-weight: normal;">{{ $score->x_and_ten_count }}</span>
            </p>
        </div>

        <div class="notes-section">
        <label for="notes">Notes:</label>
        <textarea id="notes" readonly>{{ $score->notes }}</textarea>
    </div>

    <div class="buttons">
        <a href="{{ route('archer.scoringHistory') }}" class="btn btn-back">Back</a>
    </div>
</div>
