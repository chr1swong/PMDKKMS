<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member Profile</title>
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
            width: 100%;
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

        .profile-sidebar button[type="button"] {
            margin-bottom: 15px;
        }

        .btn-cancel, .btn-update {
            padding: 10px 30px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-cancel {
            background-color: #e04a4a;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #c93a3a;
        }

        .btn-update {
            background-color: #5f4bb6;
            color: white;
        }

        .btn-update:hover {
            background-color: #3b1f8b;
        }

        .profile-details {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
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

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .button-group {
            display: flex; /* Enable flexbox layout */
            flex-wrap: nowrap; /* Prevent buttons from wrapping */
            justify-content: flex-end; /* Align buttons to the right */
            gap: 20px; /* Add spacing between buttons */
            margin-top: 20px; /* Add margin for spacing */
        }

        @media (max-width: 768px) {
            .profile-details {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-wrap: wrap; /* Allow buttons to stack vertically on smaller screens */
                justify-content: center; /* Center-align for smaller screens */
                gap: 10px; /* Reduce gap for smaller devices */
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        @include('components.committeeHeader')
    </header>

    <div class="profile-container">
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Sidebar -->
        <div class="profile-sidebar">
            <h2>Edit Profile</h2>
            <img src="{{ $member->account_profile_picture_path ? asset('storage/' . $member->account_profile_picture_path) : 'https://via.placeholder.com/150' }}" alt="Profile Picture">
            
            <form action="{{ route('committee.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*" style="display: none;" onchange="displayFileName()">
                <button type="button" onclick="document.getElementById('profile-picture-input').click();">Browse</button>
                <p id="file-name">No file selected</p>
                <button type="submit" class="btn-update">Upload Picture</button>
            </form>
        </div>

        <!-- Profile Details Form -->
        <form class="profile-details" action="{{ route('committee.editMemberProfile', ['membership_id' => $member->membership_id]) }}" method="POST">
            @csrf
            <div>
                <label for="membership-id">Membership ID</label>
                <input type="text" id="membership-id" value="{{ $member->membership_id }}" disabled>
            </div>
            <div>
                <label for="role">Role</label>
                <input type="text" id="role" value="{{ $member->account_role == 1 ? 'Archer' : ($member->account_role == 2 ? 'Coach' : 'Committee') }}" disabled>
            </div>
            <div class="full-width">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="account_full_name" value="{{ old('account_full_name', $member->account_full_name) }}" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="account_email_address" value="{{ old('account_email_address', $member->account_email_address) }}" required>
            </div>
            <div>
                <label for="contact-number">Contact Number</label>
                <input type="text" id="contact-number" name="account_contact_number" value="{{ old('account_contact_number', $member->account_contact_number) }}" required>
            </div>
            <div class="button-group">
                <a href="{{ url()->previous() }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-update">Save Changes</button>
            </div>
        </form>
    </div>

    <script>
        function displayFileName() {
            const input = document.getElementById('profile-picture-input');
            const fileNameDisplay = document.getElementById('file-name');
            fileNameDisplay.textContent = input.files[0] ? input.files[0].name : 'No file selected';
        }
    </script>
</body>
</html>
