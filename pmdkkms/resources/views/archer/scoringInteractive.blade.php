<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Scoring Mode</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #targetCanvas {
            border: 1px solid #000;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 10px;
            width: 80%;
        }

        .grid-item {
            width: 100%;
            padding: 10px;
            border: 1px solid black;
            text-align: center;
            font-weight: bold;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin-top: 10px;
        }

        .btn {
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #d32f2f;
        }

        .btn-enter {
            background-color: #4caf50;
            color: white;
        }

        .btn-enter:hover {
            background-color: #388e3c;
        }

        .btn-clear {
            background-color: #757575;
            color: white;
        }

        .btn-clear:hover {
            background-color: #616161;
        }
    </style>
</head>
<body>

<!-- Canvas Target -->
<canvas id="targetCanvas" width="600" height="600"></canvas>

<!-- Score Grid -->
<div class="grid-container" id="scoreGrid">
    <div class="grid-item">Set</div>
    <div class="grid-item">1</div>
    <div class="grid-item">2</div>
    <div class="grid-item">3</div>
    <div class="grid-item">4</div>
    <div class="grid-item">5</div>
    <div class="grid-item">6</div>

    <!-- Dynamically created rows for each set -->
    <div class="grid-item">Set 1</div>
    <div class="grid-item" id="set1-score1"></div>
    <div class="grid-item" id="set1-score2"></div>
    <div class="grid-item" id="set1-score3"></div>
    <div class="grid-item" id="set1-score4"></div>
    <div class="grid-item" id="set1-score5"></div>
    <div class="grid-item" id="set1-score6"></div>

    <div class="grid-item">Set 2</div>
    <div class="grid-item" id="set2-score1"></div>
    <div class="grid-item" id="set2-score2"></div>
    <div class="grid-item" id="set2-score3"></div>
    <div class="grid-item" id="set2-score4"></div>
    <div class="grid-item" id="set2-score5"></div>
    <div class="grid-item" id="set2-score6"></div>

    <div class="grid-item">Set 3</div>
    <div class="grid-item" id="set3-score1"></div>
    <div class="grid-item" id="set3-score2"></div>
    <div class="grid-item" id="set3-score3"></div>
    <div class="grid-item" id="set3-score4"></div>
    <div class="grid-item" id="set3-score5"></div>
    <div class="grid-item" id="set3-score6"></div>

    <div class="grid-item">Set 4</div>
    <div class="grid-item" id="set4-score1"></div>
    <div class="grid-item" id="set4-score2"></div>
    <div class="grid-item" id="set4-score3"></div>
    <div class="grid-item" id="set4-score4"></div>
    <div class="grid-item" id="set4-score5"></div>
    <div class="grid-item" id="set4-score6"></div>

    <div class="grid-item">Set 5</div>
    <div class="grid-item" id="set5-score1"></div>
    <div class="grid-item" id="set5-score2"></div>
    <div class="grid-item" id="set5-score3"></div>
    <div class="grid-item" id="set5-score4"></div>
    <div class="grid-item" id="set5-score5"></div>
    <div class="grid-item" id="set5-score6"></div>

    <div class="grid-item">Set 6</div>
    <div class="grid-item" id="set6-score1"></div>
    <div class="grid-item" id="set6-score2"></div>
    <div class="grid-item" id="set6-score3"></div>
    <div class="grid-item" id="set6-score4"></div>
    <div class="grid-item" id="set6-score5"></div>
    <div class="grid-item" id="set6-score6"></div>
</div>

<!-- Buttons -->
<div class="buttons">
    <button class="btn btn-cancel" onclick="cancel()">Cancel</button>
    <button class="btn-clear" onclick="clearGrid()">Clear</button>
    <button class="btn-enter" onclick="enterScore()">Enter</button>
</div>

<script>
    const canvas = document.getElementById('targetCanvas');
    const ctx = canvas.getContext('2d');

    const colors = ['white', 'white', '#9E9E9E', '#9E9E9E', '#2D9CDB', '#2D9CDB', '#EB5757', '#EB5757', '#F2C94C', '#F2C94C', '#F2C94C'];
    const radii = [300, 270, 240, 210, 180, 150, 120, 90, 60, 33, 12]; // Adjusted radii for new size

    function drawTarget() {
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;

        colors.forEach((color, index) => {
            ctx.beginPath();
            ctx.arc(centerX, centerY, radii[index], 0, Math.PI * 2);
            ctx.fillStyle = color;
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 1;
            ctx.stroke();
        });

        // Crosshair at the center
        ctx.strokeStyle = 'black';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(centerX - 5, centerY);
        ctx.lineTo(centerX + 5, centerY);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(centerX, centerY - 5);
        ctx.lineTo(centerX, centerY + 5);
        ctx.stroke();

        // Scores at the edges of each ring
        const scores = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        ctx.font = '14px Poppins'; // Increased font size
        ctx.fillStyle = 'black';
        ctx.textAlign = 'center';

        scores.forEach((score, i) => {
            const angle = Math.PI / 2;
            const scoreX = centerX + Math.cos(angle) * (radii[i] - 15);
            const scoreY = centerY - Math.sin(angle) * (radii[i] - 15);
            ctx.fillText(score, scoreX, scoreY);
        });
    }

    const scoreGrid = Array(6).fill(null).map(() => Array(6).fill(null));

    // Calculate score based on click distance from center (inner = X, outer = 1)
    canvas.addEventListener('click', (event) => {
        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const distance = Math.sqrt((x - canvas.width / 2) ** 2 + (y - canvas.height / 2) ** 2);

        let score;
        
        // Check if click is within the innermost circle for 'X'
        if (distance <= radii[radii.length - 1]) {
            score = 'X'; // Set as 'X' for the innermost circle
        } else {
            score = 10 - Math.floor(distance / 30); // Calculate regular score for other rings
            if (score < 1) score = 1; // Ensure minimum score is 1
        }

        // Insert score into the next available spot in the grid
        for (let i = 0; i < 6; i++) {
            for (let j = 0; j < 6; j++) {
                if (scoreGrid[i][j] === null) {
                    scoreGrid[i][j] = score;
                    document.getElementById(`set${i + 1}-score${j + 1}`).textContent = score;
                    return;
                }
            }
        }
    });

    function clearGrid() {
        for (let i = 0; i < 6; i++) {
            for (let j = 0; j < 6; j++) {
                scoreGrid[i][j] = null;
                document.getElementById(`set${i + 1}-score${j + 1}`).textContent = '';
            }
        }
    }

    function enterScore() {
        alert('Scores submitted: ' + JSON.stringify(scoreGrid));
        clearGrid();
    }

    function cancel() {
        window.location.href = "{{ route('archer.scoring') }}";
    }

    drawTarget();
</script>

</body>
</html>
