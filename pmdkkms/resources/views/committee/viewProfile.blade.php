<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile Page</title>
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
            gap: 30px;
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
        }

        .profile-sidebar img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .profile-sidebar button {
            background-color: #555555;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 15px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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

        .profile-details span {
            padding: 10px;
            font-size: 16px;
            background-color: #E0E0E0;
            border-radius: 8px;
            display: inline-block;
        }

        .full-width {
            grid-column: span 2;
        }

        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
                gap: 20px;
            }

            .profile-details {
                grid-template-columns: 1fr;
            }
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
            color: #0c3d20;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Back Button Styling */
        .back-button button {
            background-color: #5f4bb6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .back-button button:hover {
            background-color: #3b1f8b;
        }
    </style>
</head>

<body>
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Success Message with Close Button -->
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <!-- Main Profile Content -->
    <div class="profile-container">
        <!-- Sidebar Section -->
        <div class="profile-sidebar">
            <img src="{{ $member->account_profile_picture_path ? asset('storage/' . $member->account_profile_picture_path) : 'https://via.placeholder.com/150' }}" alt="Profile">
            
            <!-- Back Button -->
            <a href="{{ route('committee.member') }}" class="back-button">
                <button type="button">Back</button>
            </a>
            <!-- Edit Profile Button -->
            <a href="{{ route('committee.editMemberProfile', ['membership_id' => $member->membership_id]) }}" class="edit-button">
                <button type="button">Edit Profile</button>
            </a>
        </div>

        <!-- Profile Details Section -->
        <div class="profile-details">
            <div>
                <label for="membership-id">Membership ID</label>
                <span id="membership-id">{{ $member->membership_id }}</span>
            </div>
            <div>
                <label for="role">Role</label>
                <span id="role">{{ $member->account_role == 1 ? 'Archer' : ($member->account_role == 2 ? 'Coach' : 'Committee Member') }}</span>
            </div>
            <div class="full-width">
                <label for="full-name">Full Name</label>
                <span id="full-name">{{ $member->account_full_name }}</span>
            </div>
            <div>
                <label for="email">Email</label>
                <span id="email">{{ $member->account_email_address }}</span>
            </div>
            <div>
                <label for="contact-number">Contact Number</label>
                <span id="contact-number">{{ $member->account_contact_number }}</span>
            </div>
            <div>
                <label for="membership-status">Membership Status</label>
                <span id="membership-status">{{ $member->membership_status == 1 ? 'Active' : 'Inactive' }}</span>
            </div>
            <div>
                <label for="membership-expiry">Membership Expiry</label>
                <span id="membership-expiry">{{ $member->membership_expiry }}</span>
            </div>
        </div>
    </div>

    <!-- JavaScript for closing the success message -->
    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }
    </script>
</body>
</html>
