<?php
$title = APP_NAME;
$cssFiles = [
    'navbar.css',
    'error.css',
    'users.css',
];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>

<?php require COMPONENTS . '/error.php' ?>


<main>
    <form id="filter-form">
        <select>
            <option value="0" selected>All Users</option>
            <option value="1">Male</option>
            <option value="2">Female</option>
        </select>
        <input type="submit" value="Filter" class="filter-button">
    </form>

    <div class="user-list-container">


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>gender</th>
                    <th>messageCount</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script defer>
        const filterForm = document.querySelector('#filter-form');

        filterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const pickedValue = filterForm.querySelector('select').value;
            let getAllUsersHandler = new ApiHandler(
                '/api/getAllUsers', {
                    "filter": pickedValue
                },
                'POST'
            );
            await getAllUsersHandler.send();
            if (getAllUsersHandler.resData.success) {
                const users = getAllUsersHandler.resData.data.users;
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';
                users.forEach(user => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                <td>${user.id}</td>
                <td>${user.username}</td>
                <td>${user.gender}</td>
                <td>${user.message_count}</td>
            `;
                    tbody.appendChild(tr);
                });
            }
        });
    </script>
</main>

<?php require COMPONENTS . '/foot.php' ?>
