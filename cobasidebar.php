<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Responsive Sidebar</title>
    <script>
        const openSidebarBtn = document.getElementById('openSidebarBtn');
const sidebar = document.getElementById('sidebar');
const content = document.querySelector('.content');

openSidebarBtn.addEventListener('click', () => {
    sidebar.style.transform = 'translateX(0)';
});

document.addEventListener('click', (event) => {
    const isClickInsideSidebar = sidebar.contains(event.target);
    const isClickInsideButton = openSidebarBtn.contains(event.target);

    if (!isClickInsideSidebar && !isClickInsideButton) {
        sidebar.style.transform = 'translateX(-100%)';
    }
});

    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        button {
            /* display: none; */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            button {
                display: block;
            }

            .sidebar {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }

    </style>
</head>
<body>
    <button id="openSidebarBtn">Open Sidebar</button>
    <div class="sidebar" id="sidebar">
        <!-- Sidebar content goes here -->
        <ul>
            <li>Item 1</li>
            <li>Item 2</li>
            <li>Item 3</li>
        </ul>
    </div>
    <div class="content">
        <!-- Main content of the website goes here -->
        <h1>Welcome to the Website!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>
    <script src="script.js"></script>
</body>
</html>
