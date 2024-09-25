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
            padding: 20px;
        }

        .scoring-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            max-width: 1200px;
            margin: 60px auto 0; /* Increased margin-top to 60px for more space */
        }

        .scoring-header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .scoring-sidebar {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .scoring-sidebar div {
            margin-bottom: 20px;
        }

        .scoring-sidebar label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        .scoring-sidebar .input-box {
            background-color: #E0E0E0;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
        }

        .scoring-sidebar .view-history-btn {
            background-color: #FDD835;
            color: black;
            border: none;
            padding: 15px;
            font-size: 18px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .scoring-sidebar .view-history-btn:hover {
            background-color: #FBC02D;
        }

        .scoring-form-container {
            background-color: #E0E0E0;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .scoring-form {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .scoring-form label {
            font-weight: bold;
            font-size: 16px;
        }

        .scoring-form input, 
        .scoring-form select {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: white;
        }

        .scoring-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        .scoring-table th, 
        .scoring-table td {
            padding: 14px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 16px;
        }

        .add-btn {
            background-color: #3F51B5;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .add-btn:hover {
            background-color: #303F9F;
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
        }
    </style>
</head>

<body>

<!-- Header -->
<header>
        @include('components.archerHeader')
</header>
    <div class="scoring-container">
        <!-- Sidebar -->
        <div class="scoring-sidebar">
            <div>
                <label>Membership ID</label>
                <div class="input-box">
                    000001
                </div>
            </div>

            <div>
                <label>Name</label>
                <div class="input-box">
                    Christopher Wong Sen Li
                </div>
            </div>

            <button class="view-history-btn">View Scoring History</button>
        </div>

        <!-- Main Form -->
        <div class="scoring-form-container">
            <div class="scoring-header">Scoring</div>

            <!-- Form for selecting set, category, distance, and date -->
            <form action="#" method="POST" class="scoring-form">
                <div>
                    <label for="set">Set</label>
                    <input type="number" name="set" id="set" value="1" min="1" required>
                </div>

                <div>
                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                        <option value="Recurve">Recurve</option>
                        <option value="Compound">Compound</option>
                        <option value="Barebow">Barebow</option>
                        <!-- Add more categories as needed -->
                    </select>
                </div>

                <div>
                    <label for="distance">Distance</label>
                    <input type="number" name="distance" id="distance" value="1" min="1" required>
                </div>

                <div>
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" value="2024-03-15" required>
                </div>
            </form>

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
                        <td><input type="number" name="score1" min="0" max="10" required></td>
                        <td><input type="number" name="score2" min="0" max="10" required></td>
                        <td><input type="number" name="score3" min="0" max="10" required></td>
                        <td><input type="number" name="score4" min="0" max="10" required></td>
                        <td><input type="number" name="score5" min="0" max="10" required></td>
                        <td><input type="number" name="score6" min="0" max="10" required></td>
                        <td><input type="number" name="total" readonly></td>
                    </tr>
                </tbody>
            </table>

            <!-- Notes section -->
            <div class="notes-section">
                <label for="notes">Notes: <span style="font-size: 12px; font-style: italic;">*Optional*</span></label>
                <textarea name="notes" id="notes" placeholder="Add any notes here (optional)"></textarea>
            </div>

            <!-- Add button -->
            <button class="add-btn">Add</button>
        </div>
    </div>
</body>
</html>
