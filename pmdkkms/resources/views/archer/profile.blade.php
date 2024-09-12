<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        .profile-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 30px;
        }

        .profile-sidebar {
            width: 30%;
            background-color: #E0ECF8; /* Light blue background */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center content horizontally */
        }

        .profile-sidebar img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .profile-sidebar button {
            background-color: #555555; /* Dark grey button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 15px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            transition: background-color 0.3s ease;
        }

        .profile-sidebar button:hover {
            background-color: #333333;
        }

        .profile-details {
            width: 70%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            align-items: start;
        }

        .profile-details div {
            display: flex;
            flex-direction: column;
        }

        .profile-details label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .profile-details input {
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #E0E0E0; /* Gray background for input fields */
        }

        .profile-details input:disabled {
            background-color: #B0B0B0; /* Darker gray for disabled fields */
            color: #555555; /* Darker text color for disabled fields */
        }

        .full-width {
            grid-column: span 2; /* Make element take the whole row */
        }

        .extend-btn {
            background-color: #5f4bb6;
            color: white;
            padding: 15px 20px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            margin-top: 20px;
            grid-column: 1; /* Ensure it aligns under the first column */
            border: none; /* Remove border */
        }

        .extend-btn:hover {
            background-color: #3b1f8b;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
                gap: 20px;
            }

            .profile-details {
                grid-template-columns: 1fr;
            }

            .extend-btn {
                grid-column: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Header is included here -->
    <header>
        @include('components.archerHeader')
    </header>

    <!-- Main Profile Content -->
    <div class="profile-container">
        <!-- Sidebar Section -->
        <div class="profile-sidebar">
            <img src="https://via.placeholder.com/150" alt="Profile Picture">
            <button>Change</button>
            <a href="{{ url('/archer/editProfile') }}">
                <button>Edit Profile</button>
            </a>
        </div>

        <!-- Profile Details Section -->
        <div class="profile-details">
            <div>
                <label for="membership-id">Membership ID</label>
                <input type="text" id="membership-id" value="00001" disabled>
            </div>
            <div>
                <label for="role">Role</label>
                <input type="text" id="role" value="Archer" disabled>
            </div>
            <div class="full-width">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name" value="Full Name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" value="email@example.com">
            </div>
            <div>
                <label for="contact-number">Contact Number</label>
                <input type="text" id="contact-number" value="0123456789">
            </div>
            <div>
                <label for="membership-status">Membership Status</label>
                <input type="text" id="membership-status" value="Active" disabled>
            </div>
            <div>
                <label for="membership-expiry">Membership Expiry</label>
                <input type="text" id="membership-expiry" value="2025-01-24" disabled>
            </div>
            <button class="extend-btn">Extend Membership</button>
        </div>
    </div>
</body>
</html>
