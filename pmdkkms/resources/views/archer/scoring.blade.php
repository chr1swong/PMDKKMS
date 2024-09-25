<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Scoring</title>
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

        /* General button styling */
        .btn {
            font-size: 18px;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-block;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* View Scoring History Button */
        .view-history-btn {
            background-color: #fdd835;
            color: black;
        }

        .view-history-btn:hover {
            background-color: #fbc02d;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .view-history-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(253, 216, 53, 0.5);
        }

        /* Submit Button */
        .add-btn {
            background-color: #3f51b5;
            color: white;
            width: auto;
        }

        .add-btn:hover {
            background-color: #303f9f;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.25);
        }

        .add-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(63, 81, 181, 0.5);
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

        .scoring-form input, 
        .scoring-form select {
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

        .scoring-form-item input,
        .scoring-form-item select {
            width: 100%;
            max-width: 180px;
        }

        .distance-container {
            position: relative;
        }

        .distance-container input {
            padding-right: 30px;
        }

        .distance-container::after {
            content: 'M';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #888;
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

        .notes-section,
        .scoring-table {
            max-width: 100%;
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

        /* Responsive Design: Mobile and Tablets */
        @media (max-width: 1024px) {
            .scoring-container {
                grid-template-columns: 1fr; /* Stack sidebar and content */
                padding: 10px;
            }

            .scoring-sidebar {
                margin-bottom: 20px; /* Space between sidebar and form */
            }

            .scoring-form {
                flex-direction: column;
                gap: 20px;
            }

            .scoring-form-item input,
            .scoring-form-item select {
                max-width: 100%; /* Full width on smaller screens */
            }

            .btn {
                padding: 12px;
                font-size: 16px;
            }

            .view-history-btn {
                width: 100%; /* Full-width buttons on mobile */
            }

            .add-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- Header -->
<header>
    @include('components.archerHeader')
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
                {{ $membership_id }}
            </div>
        </div>

        <div>
            <label>Archer Name</label>
            <div class="input-box">
                {{ Auth::user()->account_full_name }}
            </div>
        </div>

        <button class="btn view-history-btn">View Scoring History</button>
    </div>

    <!-- Main Form -->
    <div class="scoring-form-container">
        <div class="scoring-header">Scoring</div>
        <hr class="scoring-header-line">

        <!-- Form for submitting scoring data -->
        <form action="{{ route('archer.storeScore') }}" method="POST">
            @csrf
            <div class="scoring-form">
                <div class="scoring-form-item">
                    <label for="set">Set</label>
                    <input type="number" name="set" id="set" value="1" min="1" required>
                </div>

                <div class="scoring-form-item">
                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                        <option value="Recurve">Recurve</option>
                        <option value="Compound">Compound</option>
                        <option value="Barebow">Barebow</option>
                    </select>
                </div>

                <div class="scoring-form-item">
                    <label for="distance">Distance</label>
                    <div class="distance-container">
                        <input type="number" name="distance" id="distance" value="1" min="1" required>
                    </div>
                </div>

                <div class="scoring-form-item">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" value="{{ now()->format('Y-m-d') }}" required>
                </div>
            </div>

            <!-- Score input table -->
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
                        <td><input type="number" name="score1" min="0" max="60" required></td>
                        <td><input type="number" name="score2" min="0" max="60" required></td>
                        <td><input type="number" name="score3" min="0" max="60" required></td>
                        <td><input type="number" name="score4" min="0" max="60" required></td>
                        <td><input type="number" name="score5" min="0" max="60" required></td>
                        <td><input type="number" name="score6" min="0" max="60" required></td>
                        <td><input type="number" name="total" readonly></td>
                    </tr>
                </tbody>
            </table>

            <!-- Notes section -->
            <div class="notes-section">
                <label for="notes" style="font-weight: bold;">Notes: <span style="font-size: 12px; font-style: italic;">*Optional*</span></label>
                <textarea name="notes" id="notes" placeholder="Add any notes here (optional)" style="font-weight: bold;"></textarea>
            </div>

            <!-- Submit button -->
            <div style="text-align: center; margin-top: 20px;">
                <button type="submit" class="btn add-btn">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript to auto-calculate total score
    const scoreInputs = document.querySelectorAll('input[name^="score"]');
    const totalInput = document.querySelector('input[name="total"]');

    scoreInputs.forEach(input => {
        input.addEventListener('input', () => {
            let total = 0;
            scoreInputs.forEach(score => {
                total += parseInt(score.value) || 0;
            });
            totalInput.value = total;
        });
    });
</script>

</body>
</html>
