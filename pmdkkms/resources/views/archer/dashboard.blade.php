<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARCHER Dashboard</title>
</head>
<body>

    <h1>Welcome!</h1>
    
    <!-- Logout Form -->
     <!--
    <form id="logout-form" action="#" method="POST" style="display: none;">
        @csrf
    </form> -->
    <form id="logout-form" action="#" method="GET" style="display: none;">
        @csrf
    </form>

    <h1>Lorem ipsum dolor sit amet</h1>

    <!-- Logout Button -->
    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </button>
</body>
</html>
