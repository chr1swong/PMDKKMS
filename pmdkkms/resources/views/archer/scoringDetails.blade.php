<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- Header -->
<header>
    @include('components.archerHeader')
</header>

    <div class="container">
        <h2>Score Details</h2>

        <div>
            <label>Date: </label>
            <span>{{ \Carbon\Carbon::parse($score->date)->format('d F Y') }}</span>
        </div>
        <div>
            <label>Category: </label>
            <span>{{ $score->category }}</span>
        </div>
        <div>
            <label>Set: </label>
            <span>{{ $score->set }}</span>
        </div>
        <div>
            <label>Distance: </label>
            <span>{{ $score->distance }}M</span>
        </div>
        <div>
            <label>Total Score: </label>
            <span>{{ $score->total }}/360</span>
        </div>
        <div>
            <label>Notes: </label>
            <span>{{ $score->notes }}</span>
        </div>

        <a href="{{ route('archer.scoringHistory') }}" class="btn">Back to Scoring History</a>
    </div>
</body>
</html>
