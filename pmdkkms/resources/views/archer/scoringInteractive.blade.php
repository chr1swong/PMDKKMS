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

        .magnifier {
            position: absolute;
            display: none;
            border: 2px solid #000;
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            pointer-events: none;
            z-index: 10;
        }

        .magnifier canvas {
            transform: scale(2); /* Magnification factor */
            transform-origin: top left;
        }
    </style>
</head>
<body>

<!-- Canvas Target -->
<canvas id="targetCanvas" width="600" height="600"></canvas>
<div class="magnifier" id="magnifier">
    <canvas id="magnifierCanvas" width="150" height="150"></canvas>
</div>

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
    <button class="btn" onclick="revertScore()">Back</button>
    <button class="btn-clear" onclick="clearGrid()">Clear</button>
    <button class="btn-enter" onclick="enterScore()">Enter</button>
</div>

<script>
    const canvas = document.getElementById('targetCanvas');
    const ctx = canvas.getContext('2d');
    const magnifier = document.getElementById('magnifier');
    const magnifierCanvas = document.getElementById('magnifierCanvas');
    const magnifierCtx = magnifierCanvas.getContext('2d');

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
    let scoreHistory = []; 

    // Calculate score based on click distance from center (inner = X, outer = 1)
    let isDragging = false; // Track if the mouse is being dragged
    let currentX = 0, currentY = 0; // Store current position of the black dot
    let dots = []; // Store all released dots with their positions

    canvas.addEventListener('mousedown', (event) => {
        const rect = canvas.getBoundingClientRect();
        currentX = event.clientX - rect.left;
        currentY = event.clientY - rect.top;
        isDragging = true; // Start dragging

        // Show the magnifier
        magnifier.style.display = 'block';
        magnifier.style.left = `${event.pageX + 10}px`; // Align with page X
        magnifier.style.top = `${event.pageY + 10}px`; // Align with page Y
    });

    canvas.addEventListener('mousemove', (event) => {
        if (isDragging) {
            const rect = canvas.getBoundingClientRect();
            currentX = event.clientX - rect.left;
            currentY = event.clientY - rect.top;

             // Update magnifier position
            magnifier.style.left = `${event.clientX + 10}px`;
            magnifier.style.top = `${event.clientY + 10}px`;

            const zoomSize = 75; // Zoomed area size
            magnifierCtx.clearRect(0, 0, 150, 150);

            // Draw the zoomed-in section on the magnifier canvas
            magnifierCtx.drawImage(
                canvas,
                currentX - zoomSize / 3, currentY - zoomSize / 3, // Source from canvas
                zoomSize, zoomSize, // Area size on canvas
                0, 0, // Top-left corner of magnifier canvas
                115, 115 // Scale to fit the magnifier
            );

            // Draw the black dot inside the magnifier
            drawMagnifierDot(currentX, currentY, zoomSize);

            // Clear canvas and redraw the target during drag
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            drawTarget();
            drawAllDots(); // Redraw all previous dots
            drawDot(currentX, currentY); // Draw the current dragged dot
        }
    });

    // Function to draw the dot on the magnifier canvas
    function drawMagnifierDot(dotX, dotY, zoomSize) {
        const offsetX = 75 - (currentX - dotX); // Adjust for zoom area center
        const offsetY = 75 - (currentY - dotY); // Adjust for zoom area center

        magnifierCtx.beginPath();
        magnifierCtx.arc(offsetX, offsetY, 5, 0, Math.PI * 2); // Small black dot
        magnifierCtx.fillStyle = 'black';
        magnifierCtx.fill();
    }

    canvas.addEventListener('mouseup', (event) => {
        isDragging = false; // Stop dragging
        magnifier.style.display = 'none'; // Hide magnifier

        // Calculate the final score based on the released position
        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        let distance = Math.sqrt((x - canvas.width / 2) ** 2 + (y - canvas.height / 2) ** 2);

        // Adjust distance based on whether it's the innermost circle or other rings
        if (distance <= radii[radii.length - 1]) {
            distance -= 5; // Subtract 5px for innermost 'X' circle
        } else {
            distance -= 7; // Subtract 7px for other rings
        }

        let score;
        // Check if the dot is outside the outermost ring (considered a 'Miss')
        if (distance > radii[0]) {
            score = 'M'; // Miss with a value of 0
        } else if (distance <= radii[radii.length - 1]) {
            score = 'X'; // Set as 'X' for the innermost circle
        } else {
            score = 10 - Math.floor(distance / 30); // Calculate score for other rings
            if (score < 1) score = 1; // Ensure minimum score of 1
        }

        // Insert score into the next available spot in the grid
        let scorePlaced = false;
        for (let i = 0; i < 6 && !scorePlaced; i++) {
            for (let j = 0; j < 6; j++) {
                if (scoreGrid[i][j] === null) {
                    scoreGrid[i][j] = score;
                    document.getElementById(`set${i + 1}-score${j + 1}`).textContent = score;
                    scoreHistory.push({ set: i, position: j, dot: { x, y } });
                    scorePlaced = true; // Prevent further insertion
                    break;
                }
            }
        }

        // Store the dot's final position
        dots.push({ x, y });

        // Redraw the canvas with all dots
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawTarget();
        drawAllDots(); // Draw all stored dots
    });

    function drawDot(x, y) {
        ctx.beginPath();
        ctx.arc(x, y, 5, 0, Math.PI * 2); // Small black dot with 5px radius
        ctx.fillStyle = 'black';
        ctx.fill();
    }

    // Draw all released dots from the dots array
    function drawAllDots() {
        dots.forEach(dot => drawDot(dot.x, dot.y));
    }

    function revertScore() {
        if (scoreHistory.length === 0) return; // No scores to revert

        const lastEntry = scoreHistory.pop(); // Get the last score and dot position
        const { set, position, dot } = lastEntry;

        scoreGrid[set][position] = null; // Clear the score
        document.getElementById(`set${set + 1}-score${position + 1}`).textContent = '';

        // Remove the corresponding dot
        dots = dots.filter(d => d.x !== dot.x || d.y !== dot.y);

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawTarget();
        drawAllDots(); // Redraw remaining dots
    }

    function clearGrid() {
        // Clear the score grid
        for (let i = 0; i < 6; i++) {
            for (let j = 0; j < 6; j++) {
                scoreGrid[i][j] = null;
                document.getElementById(`set${i + 1}-score${j + 1}`).textContent = '';
            }
        }

        // Clear the dots and canvas, then redraw the target
        dots = []; // Reset the dots array
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear entire canvas
        drawTarget(); // Redraw the target without dots
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
