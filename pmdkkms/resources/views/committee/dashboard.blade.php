<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Dashboard</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            min-width: 220px;
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card i {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .card h3 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .card span {
            font-size: 24px;
            font-weight: bold;
        }

        .card.archers {
            background-color: #5A67D8;
        }

        .card.coaches {
            background-color: #48BB78;
        }

        .card.committee {
            background-color: #F56565;
        }

        .card.payments {
            background-color: #ED8936;
        }

        .upcoming-events,
        .announcements-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .event-card,
        .announcement-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .event-card:hover,
        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .event-details,
        .announcement-details {
            font-size: 16px;
        }

        .event-details i,
        .announcement-details i {
            margin-right: 8px;
        }

        .event-action,
        .announcement-action {
            text-align: right;
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px; /* Ensure both buttons have the same font size */
            transition: background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #5A67D8;
            color: white;
        }

        .edit-btn:hover {
            background-color: #434190;
        }

        .delete-btn {
            background-color: #F56565;
            color: white;
        }

        .delete-btn:hover {
            background-color: #D9534F;
        }

        .announcements-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .announcements-header h3 {
            margin: 0;
        }

        .add-btn {
            background-color: #5A67D8;
            color: white;
            padding: 10px 13px;
            border-radius: 50%;
            cursor: pointer;
            border: none;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .add-btn i {
            margin: 0;
        }

        .add-btn:hover {
            background-color: #434190;
        }

        /* Modal styling for add announcement */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 40px;
            border-radius: 8px;
            width: 60%;
            max-width: 800px;
        }

        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-group textarea {
            resize: vertical; /* Allow vertical resizing only */
        }

        /* Centering the submit button */
        .submit-btn {
            background-color: #2f855a; /* Darker green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        .submit-btn:hover {
            background-color: #276749; /* Even darker on hover */
        }

        /* Modal styling for delete confirmation */
        .modal-delete {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-delete-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }

        .modal-delete button {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .confirm-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .cancel-delete {
            background-color: #ccc;
            color: black;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .cards {
                flex-direction: column;
            }

            .event-card,
            .announcement-card {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            .event-action,
            .announcement-action {
                margin-top: 10px;
                text-align: left;
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Header is included here -->
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Main Dashboard Content -->
    <div class="dashboard-container">
        <h2>Committee Dashboard</h2>

        <!-- Cards Section -->
        <div class="cards">
            <a href="{{ route('committee.member', ['role' => 'archer']) }}" class="card-link">
                <div class="card archers">
                    <i class="fas fa-bullseye"></i>
                    <h3>Archers</h3>
                    <span>{{ $archerCount }}</span> <!-- Dynamic count of archers -->
                </div>
            </a>

            <a href="{{ route('committee.member', ['role' => 'coach']) }}" class="card-link">
                <div class="card coaches">
                    <i class="fas fa-user-tie"></i>
                    <h3>Coaches</h3>
                    <span>{{ $coachCount }}</span> <!-- Dynamic count of coaches -->
                </div>
            </a>

            <a href="{{ route('committee.member', ['role' => 'committee']) }}" class="card-link">
                <div class="card committee">
                    <i class="fas fa-users"></i>
                    <h3>Committee</h3>
                    <span>{{ $committeeCount }}</span> <!-- Dynamic count of committee members -->
                </div>
            </a>

            <div class="card payments">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Payments</h3>
            </div>
        </div>

        <!-- Announcements Section -->
        <div class="announcements-container">
            <div class="announcements-header">
                <h3>Announcements</h3>
                <button id="addAnnouncementBtn" class="add-btn">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            @if($announcements->isEmpty())
                <div class="announcement-card">
                    <p>No announcements available.</p>
                </div>
            @else
                @foreach($announcements as $announcement)
                    <div class="announcement-card">
                        <div class="announcement-details">
                            <h4>{{ $announcement->title }}</h4>
                            <p>{{ $announcement->content }}</p>
                        </div>
                        <div class="announcement-action">
                            <button class="action-btn delete-btn" onclick="showDeleteModal('{{ route('announcements.destroy', $announcement->id) }}')"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Modal for Adding Announcement -->
        <div id="announcementModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Announcement</h2>
                <form action="{{ route('announcements.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea id="content" name="content" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal-delete">
            <div class="modal-delete-content">
                <h3>Confirm Deletion</h3>
                <p>Are you sure you want to delete this announcement?</p>
                <button class="confirm-delete" id="confirmDeleteButton">Confirm</button>
                <button class="cancel-delete" onclick="closeDeleteModal()">Cancel</button>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="upcoming-events">
            <h3>Upcoming Events</h3>
            @if($upcomingEvents->isEmpty())
                <p>No upcoming events available.</p>
            @else
                @foreach($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="event-details">
                            <p><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                            <p><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        </div>
                        <div class="event-action">
                            <!-- Link to the events.index route -->
                            <a href="{{ route('events.index', ['event_id' => $event->id]) }}" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('announcementModal');
            var addBtn = document.getElementById('addAnnouncementBtn');
            var closeBtn = document.getElementsByClassName('close')[0];

            // When the user clicks the button, open the modal
            addBtn.onclick = function () {
                modal.style.display = 'block';
            }

            // When the user clicks on the close button, close the modal
            closeBtn.onclick = function () {
                modal.style.display = 'none';
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });

        // Function to open delete confirmation modal
        function showDeleteModal(deleteUrl) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('confirmDeleteButton').onclick = function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(tokenInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
</body>
</html>
