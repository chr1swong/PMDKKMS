<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

        .password-input {
            display: flex;
            align-items: center;
            position: relative;
        }

        .password-input input {
            flex-grow: 1;
            padding-right: 40px; /* Add space for the icon */
        }

        .password-input .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }

        .full-width {
            grid-column: span 2; /* Make element take the whole row */
        }

        .btn-cancel, .btn-update {
            display: inline-block;
            background-color: #ff6b6b;
            color: white;
            padding: 15px 20px; /* Increased padding for taller buttons */
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            border: none;
            text-decoration: none; /* Remove the underline from the anchor */
            font-size: 16px;
        }

        .btn-update {
            background-color: #5f4bb6;
        }

        .btn-cancel:hover {
            background-color: #e04a4a;
        }

        .btn-update:hover {
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
            <h2>Edit Profile</h2>
            <img src="https://via.placeholder.com/150" alt="Profile Picture">
            <button>Change</button>
        </div>

        <!-- Profile Details Section -->
        <form class="profile-details">
            <div>
                <label for="membership-id">Membership ID</label>
                <input type="text" id="membership-id" value="00001" disabled>
            </div>
            <div>
                <label for="role">Role</label>
                <input type="text" id="role" value="Archer" disabled>
            </div>
            <div class="full-width">
                <label for="name">Full Name</label>
                <input type="text" id="name" placeholder="Enter your name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your email">
            </div>
            <div>
                <label for="contact-number">Contact Number</label>
                <input type="text" id="contact-number" placeholder="Mobile Number">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Password (at least 8 characters)">
            </div>
            <div>
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" placeholder="Confirm Password">
            </div>
            <div style="margin-top: 15px;"> 
                <a href="{{ url('archer/profile') }}" class="btn-cancel">Cancel</a>
            </div>
            <div style="margin-top: 15px;">
                <button type="submit" class="btn-update">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
