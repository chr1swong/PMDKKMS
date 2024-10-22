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
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center; 
            box-sizing: border-box;
        }

        .title {
            margin: 0; 
            padding: 0; 
            font-size: 24px;
            font-weight: 600;
            text-align: left;
        }

        .title-container {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Push the button to the end */
            gap: 10px; /* Add spacing between the title and the button */
        }

        .view-history-btn {
            margin-left: auto; /* Push the button to the right */
            padding: 8px 16px; /* Make the button smaller */
            background-color: #FFA500; /* Yellowish-orange color */
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            text-align: center;
            font-size: 14px; /* Adjust the font size for smaller button */
        }

        .view-history-btn:hover {
            background-color: #FF8C00; /* Darker orange on hover */
            transform: scale(1.05); /* Slight hover effect */
        }

        .styled-divider {
            border: none;
            height: 2px;
            background-color: #808080;
            margin: 4px 0; /* Reduce margin to minimize spacing */
            padding: 0;
        }

        header {
            width: 100%;
            background-color: #001f3f; /* Optional background color for header */
            padding: 10px 0; /* Adjust spacing for header */
            display: flex;
            justify-content: center;
        }

        .main-container {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Canvas on the left, form on the right */
            gap: 20px;
            max-width: 1200px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            margin-top: 20px; /* Add spacing below the header */
            align-items: center;
            justify-content: center; /* Center horizontally within available space */
        }

        .right-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            max-width: 400px; /* Set the same max-width */
            margin: 0 auto; /* Center align */
            box-sizing: border-box; /* Include padding in width calculations */
        }

        .input-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%; /* Full width */
            max-width: 400px; /* Same max-width as the grid container */
            box-sizing: border-box;
        }

        .input-section select {
            width: 100%; 
            padding: 10px;
            padding-right: 40px; /* Add space for the arrow */
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: white;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            position: relative;
        }

        .input-section select::after {
            content: '▼'; /* Unicode arrow */
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 16px;
            color: #777;
            z-index: 1; /* Ensure the arrow is on top */
        }

        .input-section input {
            width: auto;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .select-wrapper {
            position: relative;
            width: 100%;
        }

        .select-wrapper::after {
            content: '▼'; /* Unicode arrow */
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none; /* Prevent interaction with the arrow */
            font-size: 12px;
            color: #777;
        }

        .notes-section {
            margin-top: 5px;
        }

        .notes-section label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        .notes-section textarea {
            resize: none; /* Disable resizing */
            overflow-y: scroll; /* Add vertical scroll if content overflows */
            max-height: 150px; /* Set a fixed maximum height */
            min-height: 100px; /* Set a fixed minimum height */
            width: 100%; /* Full width of the container */
            font-family: 'Poppins', sans-serif; /* Matching the rest of the design */
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box; /* Include padding and border in the width */
            background-color: white; /* Set background color to white */
        }

        #targetCanvas {
            border: 1px solid #000;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 800px;  /* Larger canvas width */
            height: 800px; /* Larger canvas height */
        }

        .grid-container {
            display: grid;
            /* Adjust column sizes: narrower set and total columns, wider score cells */
            grid-template-columns: 80px repeat(6, 1.5fr) 60px;
            gap: 3px; /* Slightly increase gap for better readability */
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            width: 100%;
            max-width: 700px; /* Expand container width slightly */
            margin: 0 auto;
            box-sizing: border-box;
        }

        .grid-item {
            display: flex; /* Use flexbox for perfect alignment */
            align-items: center; /* Center content vertically */
            justify-content: center; /* Center content horizontally */
            padding: 12px; /* Increase padding for more space */
            text-align: center;
            font-weight: 600;
            background-color: white;
            border: 1px solid #ddd;
            font-size: 18px;
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }

        .grid-item:nth-child(8n+1) {
            background-color: #2196f3; /* Light blue color for SET rows */
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
        }

        .grid-item {
            padding: 10px;
        }

        .total-cell {
            background-color: #e0e0e0; /* Light grey color for total rows */
            font-weight: 700;
        }

        .score-summary {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            padding: 0;
        }

        .buttons {
            display: flex;
            justify-content: space-between; /* Spread buttons evenly */
            gap: 10px; /* Add space between buttons */
            margin-top: 0px; /* Space from the grid */
        }

        .btn {
            font-size: 16px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            flex: 1; /* Ensure all buttons take equal space */
            max-width: 150px;
            text-align: center;
        }

        .btn:hover {
            transform: scale(1.05); 
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
            margin-top: 20px; 
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

        .btn-undo {
            background-color: #ff6f6f; /* Lighter red */
            color: white;
        }

        .btn-undo:hover {
            background-color: #ff5252; /* Slightly darker on hover */
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

        /* Responsive design for mobile devices */
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 80px repeat(6, 1fr) 60px; /* Adjusted for smaller screens */
            }

            .buttons {
                flex-direction: column; /* Stack buttons vertically */
                width: 100%;
            }

            .buttons-container {
                flex-direction: column; /* Stack buttons on smaller screens */
                gap: 10px;
            }

            .btn {
                width: 80%; /* Full width for buttons on smaller screens */
                max-width: none;
            }
        }
    </style>
    
</head>
<body>

<header>
    @include('components.archerHeader')
</header>

<div class="main-container">
    <!-- Canvas -->
    <canvas id="targetCanvas" width="800" height="800"></canvas>
    <div class="magnifier" id="magnifier">
        <canvas id="magnifierCanvas" width="150" height="150"></canvas>
    </div>

    <!-- Right Column with Input and Grid -->
    <div class="right-column">
        <!-- Form Section -->
        <form action="{{ route('scoring.store') }}" method="POST" id="scoreForm">
            @csrf

            <div class="input-section">
            <div class="title-container">
                <h2 class="title">Scoring</h2>
                <button type="button" class="btn view-history-btn" onclick="navigateToHistory()">View Scoring History</button>
            </div>
                <hr class="styled-divider">
                <select id="distance" name="distance" required>
                    <option value="10" selected>10 meters</option>
                    <option value="20">20 meters</option>
                    <option value="30">30 meters</option>
                    <option value="40">40 meters</option>
                    <option value="50">50 meters</option>
                    <option value="60">60 meters</option>
                    <option value="70">70 meters</option>
                </select>
                <input type="date" id="date" name="date" value="{{ now()->format('Y-m-d') }}" required>

                <div class="notes-section">
                    <label for="notes" style="font-weight: bold;">Notes: <span style="font-size: 12px; font-style: italic;">*Optional*</span></label>
                    <textarea name="notes" id="notes" placeholder="Add any notes here (optional)"></textarea>
                </div>
            </div>


            <!-- Update Hidden Inputs -->
            <div id="hidden-score-inputs">
                <!-- Set 1 -->
                <input type="hidden" name="set1_score1">
                <input type="hidden" name="set1_score2">
                <input type="hidden" name="set1_score3">
                <input type="hidden" name="set1_score4">
                <input type="hidden" name="set1_score5">
                <input type="hidden" name="set1_score6">

                <!-- Set 2 -->
                <input type="hidden" name="set2_score1">
                <input type="hidden" name="set2_score2">
                <input type="hidden" name="set2_score3">
                <input type="hidden" name="set2_score4">
                <input type="hidden" name="set2_score5">
                <input type="hidden" name="set2_score6">

                <!-- Set 3 -->
                <input type="hidden" name="set3_score1">
                <input type="hidden" name="set3_score2">
                <input type="hidden" name="set3_score3">
                <input type="hidden" name="set3_score4">
                <input type="hidden" name="set3_score5">
                <input type="hidden" name="set3_score6">

                <!-- Set 4 -->
                <input type="hidden" name="set4_score1">
                <input type="hidden" name="set4_score2">
                <input type="hidden" name="set4_score3">
                <input type="hidden" name="set4_score4">
                <input type="hidden" name="set4_score5">
                <input type="hidden" name="set4_score6">

                <!-- Set 5 -->
                <input type="hidden" name="set5_score1">
                <input type="hidden" name="set5_score2">
                <input type="hidden" name="set5_score3">
                <input type="hidden" name="set5_score4">
                <input type="hidden" name="set5_score5">
                <input type="hidden" name="set5_score6">

                <!-- Set 6 -->
                <input type="hidden" name="set6_score1">
                <input type="hidden" name="set6_score2">
                <input type="hidden" name="set6_score3">
                <input type="hidden" name="set6_score4">
                <input type="hidden" name="set6_score5">
                <input type="hidden" name="set6_score6">
            </div>


            <!-- Grid Container -->
            <div class="grid-container" id="scoreGrid">
                <div class="grid-item">Set 1</div>
                <div class="grid-item" id="set1-score1"></div>
                <div class="grid-item" id="set1-score2"></div>
                <div class="grid-item" id="set1-score3"></div>
                <div class="grid-item" id="set1-score4"></div>
                <div class="grid-item" id="set1-score5"></div>
                <div class="grid-item" id="set1-score6"></div>
                <div class="grid-item total-cell" id="set1-total">0</div>

                <div class="grid-item">Set 2</div>
                <div class="grid-item" id="set2-score1"></div>
                <div class="grid-item" id="set2-score2"></div>
                <div class="grid-item" id="set2-score3"></div>
                <div class="grid-item" id="set2-score4"></div>
                <div class="grid-item" id="set2-score5"></div>
                <div class="grid-item" id="set2-score6"></div>
                <div class="grid-item total-cell" id="set2-total">0</div>

                <div class="grid-item">Set 3</div>
                <div class="grid-item" id="set3-score1"></div>
                <div class="grid-item" id="set3-score2"></div>
                <div class="grid-item" id="set3-score3"></div>
                <div class="grid-item" id="set3-score4"></div>
                <div class="grid-item" id="set3-score5"></div>
                <div class="grid-item" id="set3-score6"></div>
                <div class="grid-item total-cell" id="set3-total">0</div>

                <div class="grid-item">Set 4</div>
                <div class="grid-item" id="set4-score1"></div>
                <div class="grid-item" id="set4-score2"></div>
                <div class="grid-item" id="set4-score3"></div>
                <div class="grid-item" id="set4-score4"></div>
                <div class="grid-item" id="set4-score5"></div>
                <div class="grid-item" id="set4-score6"></div>
                <div class="grid-item total-cell" id="set4-total">0</div>

                <div class="grid-item">Set 5</div>
                <div class="grid-item" id="set5-score1"></div>
                <div class="grid-item" id="set5-score2"></div>
                <div class="grid-item" id="set5-score3"></div>
                <div class="grid-item" id="set5-score4"></div>
                <div class="grid-item" id="set5-score5"></div>
                <div class="grid-item" id="set5-score6"></div>
                <div class="grid-item total-cell" id="set5-total">0</div>

                <div class="grid-item">Set 6</div>
                <div class="grid-item" id="set6-score1"></div>
                <div class="grid-item" id="set6-score2"></div>
                <div class="grid-item" id="set6-score3"></div>
                <div class="grid-item" id="set6-score4"></div>
                <div class="grid-item" id="set6-score5"></div>
                <div class="grid-item" id="set6-score6"></div>
                <div class="grid-item total-cell" id="set6-total">0</div>

                <div class="grid-item total-cell" style="grid-column: span 7; text-align: right;">
                    Overall Total
                </div>
                <div class="grid-item total-cell" id="overall-total">0</div>
            </div>

            <div class="score-summary">
                <p>
                    <strong>X:</strong> <span id="x-count" style="font-weight: normal;">0</span>,&nbsp;&nbsp;&nbsp;
                    <strong>10:</strong> <span id="ten-count" style="font-weight: normal;">0</span>,&nbsp;&nbsp;&nbsp;
                    <strong>X+10:</strong> <span id="x-and-ten-count" style="font-weight: normal;">0</span>
                </p>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button type="button" class="btn btn-clear" onclick="clearGrid()">Clear</button>
                <button type="button" class="btn btn-undo" onclick="revertScore()">Undo</button>
                <button type="submit" class="btn btn-enter" onclick="submitScores()">Submit</button>
            </div>
        </form>
    </div>
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
        const targetRadius = 500;
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;

        const padding = 30;

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
        ctx.font = '14px Poppins'; 
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

    function calculateTotal(setIndex) {
        let total = 0;
        for (let j = 0; j < 6; j++) {
            const score = scoreGrid[setIndex][j];
            if (score === 'X') {
                total += 10;  // Treat 'X' as 10 points
            } else if (score === 'M' || score === null) {
                total += 0;   // Treat 'M' and empty cells as 0 points
            } else {
                total += parseInt(score, 10);  // Add numeric scores
            }
        }
        document.getElementById(`set${setIndex + 1}-total`).textContent = total;
        updateOverallTotal();
    }

    function updateOverallTotal() {
        let overallTotal = 0;
        for (let i = 0; i < 6; i++) {
            const setTotal = parseInt(document.getElementById(`set${i + 1}-total`).textContent, 10);
            overallTotal += isNaN(setTotal) ? 0 : setTotal;
        }
        document.getElementById('overall-total').textContent = overallTotal;
    }

    let xCount = 0;
    let tenCount = 0;
    let xAndTenCount = 0;

    function updateScoreSummary() {
        document.getElementById('x-count').textContent = xCount;
        document.getElementById('ten-count').textContent = tenCount;
        document.getElementById('x-and-ten-count').textContent = xAndTenCount;
    }

    function resetCounters() {
        xCount = 0;
        tenCount = 0;
        xAndTenCount = 0;
        updateScoreSummary();
    }


    canvas.addEventListener('mouseup', (event) => {
        if (scoreHistory.length >= 36) {
            alert('All grid boxes are filled!');
            return; // Stop further processing if the grid is full
        }

        isDragging = false; // Stop dragging
        magnifier.style.display = 'none'; // Hide magnifier

        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        let distance = Math.sqrt((x - canvas.width / 2) ** 2 + (y - canvas.height / 2) ** 2);

        // Adjust distance based on whether it's the innermost circle or other rings
        if (distance <= radii[radii.length - 1]) {
            distance -= 5;
        } else {
            distance -= 7;
        }

        let score;
        if (distance > radii[0]) {
            score = 'M';  // Miss
        } else if (distance <= radii[radii.length - 1]) {
            score = 'X';  // Innermost circle
            xCount++;
            xAndTenCount++; // Increment X+10 only for X
        } else {
            score = 10 - Math.floor(distance / 30); // Calculate other scores
            if (score < 1) score = 1; // Ensure minimum score of 1
            if (score === 10) {
                tenCount++;
                xAndTenCount++; // Increment X+10 only for 10
            }
        }

        let scorePlaced = false;
        for (let i = 0; i < 6 && !scorePlaced; i++) {
            for (let j = 0; j < 6; j++) {
                if (scoreGrid[i][j] === null) {
                    scoreGrid[i][j] = score;
                    document.getElementById(`set${i + 1}-score${j + 1}`).textContent = score;
                    scoreHistory.push({ set: i, position: j, dot: { x, y }, score });
                    scorePlaced = true;
                    calculateTotal(i);  // Update the total after placing a score
                    break;
                }
            }
        }

        updateScoreSummary();
        
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
        const { set, position, dot, score } = lastEntry;

        // Decrement X or 10 counters if applicable
        if (score === 'X') {
            xCount--;
            xAndTenCount--; // Decrement combined counter
        }
        if (score === 10) {
            tenCount--;
            xAndTenCount--; // Decrement combined counter
        }

        updateScoreSummary(); // Update the displayed counters

        scoreGrid[set][position] = null; // Clear the score
        document.getElementById(`set${set + 1}-score${position + 1}`).textContent = '';

        // Find the last matching dot and remove only that one
        for (let i = dots.length - 1; i >= 0; i--) {
            if (dots[i].x === dot.x && dots[i].y === dot.y) {
                dots.splice(i, 1); // Remove the last matching dot
                break; // Stop after removing one dot
            }
        }

        // Redraw the canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawTarget();
        drawAllDots(); // Redraw remaining dots

        // Recalculate the total for the relevant set
        calculateTotal(set);
    }


    function clearGrid() {
        // Clear the score grids
        for (let i = 0; i < 6; i++) {
            for (let j = 0; j < 6; j++) {
                scoreGrid[i][j] = null;
                document.getElementById(`set${i + 1}-score${j + 1}`).textContent = '';
            }
            // Reset the total for each set
            document.getElementById(`set${i + 1}-total`).textContent = '0';
        }

        // Clear the dots and canvas, then redraw the target
        dots = []; // Reset the dots array
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear entire canvas
        drawTarget(); // Redraw the target without dots

        resetCounters(); // // Reset all counters including X, 10, and X+10
        updateOverallTotal();
    }

    function submitScores() {
        for (let set = 1; set <= 6; set++) {
            for (let score = 1; score <= 6; score++) {
                let value = document.getElementById(`set${set}-score${score}`).textContent || '0';
                
                // Treat 'X' as 10
                if (value === 'X') value = 10;

                // Populate the corresponding hidden input
                document.querySelector(`input[name="set${set}_score${score}"]`).value = parseInt(value, 10);
            }
        }
        document.getElementById('scoreForm').submit();
    }

    //Touch Screen part
    // Helper function to get the correct event (touch or mouse)
    function getEventCoords(event) {
        const rect = canvas.getBoundingClientRect();
        let clientX, clientY;

        if (event.touches) {
            // Handle touch events
            const touch = event.touches[0];
            clientX = touch.clientX;
            clientY = touch.clientY;
        } else {
            // Handle mouse events
            clientX = event.clientX;
            clientY = event.clientY;
        }

        return {
            x: clientX - rect.left,
            y: clientY - rect.top,
        };
    }

    // Updated start drag for both mouse and touch events
    function startDrag(event) {
        event.preventDefault(); // Prevents default behavior like scrolling on mobile

        const { x, y } = getEventCoords(event);
        currentX = x;
        currentY = y;
        isDragging = true;

        // Show the magnifier
        magnifier.style.display = 'block';
        magnifier.style.left = `${event.pageX + 10}px`;
        magnifier.style.top = `${event.pageY + 10}px`;
    }

    // Handle drag movement for mouse and touch events
    function moveDrag(event) {
        if (!isDragging) return;

        const { x, y } = getEventCoords(event);
        currentX = x;
        currentY = y;

        // Update magnifier position
        const touch = event.touches ? event.touches[0] : event;
        magnifier.style.left = `${touch.pageX + 10}px`;
        magnifier.style.top = `${touch.pageY + 10}px`;

        // Draw zoomed-in view
        const zoomSize = 75;
        magnifierCtx.clearRect(0, 0, 150, 150);
        magnifierCtx.drawImage(
            canvas,
            currentX - zoomSize / 3, currentY - zoomSize / 3,
            zoomSize, zoomSize,
            0, 0,
            115, 115
        );
    }

    // Handle drag end for both mouse and touch
    function endDrag() {
        isDragging = false;
        magnifier.style.display = 'none';
    }

    // Add event listeners for both mouse and touch events
    canvas.addEventListener('mousedown', startDrag);
    canvas.addEventListener('mousemove', moveDrag);
    canvas.addEventListener('mouseup', endDrag);

    canvas.addEventListener('touchstart', startDrag);
    canvas.addEventListener('touchmove', moveDrag);
    canvas.addEventListener('touchend', endDrag);
    
    drawTarget();

    function navigateToHistory() {
        console.log('Navigating to Scoring History');
        window.location.href = "{{ route('archer.scoringHistory') }}";
    }
</script>

</body>
</html>
