<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Committee Profile</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
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
            flex-direction: column;
            gap: 40px;
        }

        .profile-sidebar {
            width: 30%;
            background-color: #E0ECF8;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .profile-sidebar img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        /* General Button Styling */
        .btn-cancel, .btn-update {
            display: inline-block;
            color: white;
            padding: 15px 20px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            border: none;
            text-decoration: none;
            font-size: 16px;
            width: 100%;
            text-transform: uppercase;
            box-sizing: border-box;
        }

        /* Cancel Button */
        .btn-cancel {
            background-color: #ff6b6b;
        }

        .btn-cancel:hover {
            background-color: #e04a4a;
        }

        /* Update Button */
        .btn-update {
            background-color: #5f4bb6;
        }

        .btn-update:hover {
            background-color: #3b1f8b;
        }

        /* Specific Styling for the Upload Picture Button */
        .profile-sidebar .btn-update {
            background-color: #f59342;
            padding: 10px 15px; /* Smaller button */
        }

        .profile-sidebar .btn-update:hover {
            background-color: #d57829;
        }

        .profile-sidebar button[type="button"] {
            margin-bottom: 15px; /* Increase gap between Browse and Upload buttons */
        }

        .profile-details {
            width: 100%;
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
            background-color: #E0E0E0;
        }

        .profile-details input:disabled {
            background-color: #B0B0B0;
            color: #555555;
        }

        .half-width {
            grid-column: span 1;
        }

        .full-width {
            grid-column: span 2;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0; /* Reduced margin to shorten gap */
        }

        h3 {
            margin-top: 0px; /* Reduced top margin for Change Password section */
        }

        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
                gap: 20px;
            }

            .profile-details {
                grid-template-columns: 1fr;
            }

            /* Ensure full-width buttons on smaller screens */
            .btn-cancel, .btn-update {
                width: 100%;
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Close Button Styling */
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
            color: #0c3d20; /* Darker green on hover */
        }

        /* Styling for file name display */
        #file-name {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>
    <!-- Header is included here -->
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Success or Error Message -->
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <div class="profile-container">
        <!-- Sidebar Section -->
        <div class="profile-sidebar">
            <h2>Edit Profile</h2>
            <img src="{{ $user->account_profile_picture_path ? asset('storage/' . $user->account_profile_picture_path) : 'https://via.placeholder.com/150' }}" alt="Profile Picture">
            <!-- Profile Picture Upload Form -->
            <form action="{{ route('committee.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Hidden file input -->
                <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*" style="display: none;" onchange="displayFileName()">
                
                <!-- Button to trigger file input -->
                <button type="button" onclick="document.getElementById('profile-picture-input').click();">Browse file</button>

                <!-- Display selected file name -->
                <p id="file-name">No file selected</p>
                
                <!-- Submit button -->
                <button type="submit" class="btn-update">Upload Picture</button>
            </form>
        </div>

        <!-- Profile Details Section -->
        <form class="profile-details" action="{{ route('committee.updateProfile') }}" method="POST">
            @csrf
            <div>
                <label for="membership-id">Membership ID</label>
                <input type="text" id="membership-id" value="{{ $membership_id }}" disabled>
            </div>
            <div>
                <label for="role">Role</label>
                <input type="text" id="role" value="Committee" disabled>
            </div>
            <div class="full-width">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="account_full_name" value="{{ $user->account_full_name }}">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="account_email_address" value="{{ $user->account_email_address }}">
            </div>
            <div>
                <label for="contact-number">Contact Number</label>
                <input type="text" id="contact-number" name="account_contact_number" value="{{ $user->account_contact_number }}">
            </div>
            <div style="margin-top: 15px;">
                <a href="{{ url('committee/profile') }}" class="btn-cancel">Cancel</a>
            </div>
            <div style="margin-top: 15px;">
                <button type="submit" class="btn-update">Update</button>
            </div>
        </form>

        <hr>

        <!-- Change Password Section -->
        <h3>Change Password</h3>
        <form class="profile-details" action="{{ route('committee.changePassword') }}" method="POST">
        @csrf
        <div class="full-width">
            <label for="current-password">Current Password</label>
            <input type="password" id="current-password" name="current_password" placeholder="Enter your current password" required>
        </div>
        <div class="half-width">
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new_account_password" placeholder="Enter your new password" required>
        </div>
        <div class="half-width">
            <label for="confirm-new-password">Confirm New Password</label>
            <input type="password" id="confirm-new-password" name="new_account_password_confirmation" placeholder="Confirm your new password" required>
        </div>

        <!-- Submit Button for Password Change -->
        <div style="margin-top: 15px;">
            <button type="submit" class="btn-update">Change Password</button>
        </div>
    </form>
    </div>

    <!-- JavaScript for closing the success message and displaying file name -->
    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }

        function displayFileName() {
            const input = document.getElementById('profile-picture-input');
            const fileNameDisplay = document.getElementById('file-name');

            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = 'No file selected';
            }
        }
    </script>
</body>
</html>
