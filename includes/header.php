<!DOCTYPE html>
<html>
<head>
    <title>Client Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-gray-900 text-white p-5 flex flex-col">

        <!-- TOP MENU -->
        <div>
            <h1 class="text-xl font-bold mb-6">Admin Panel</h1>

            <a href="dashboard.php" class="block py-2 hover:bg-gray-700 px-2 rounded">Dashboard</a>
            <a href="clients.php" class="block py-2 hover:bg-gray-700 px-2 rounded">Clients</a>
            <a href="projects.php" class="block py-2 hover:bg-gray-700 px-2 rounded">Projects</a>
        </div>

        <!-- PUSH LOGOUT TO BOTTOM -->
        <div class="mt-auto">

            <a href="logout.php"
               class="block text-center bg-red-600 hover:bg-red-700 text-white py-2 rounded">
                Logout
            </a>

        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 p-6">