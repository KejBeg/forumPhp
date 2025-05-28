<?php
$title = $_SERVER['APP_NAME'];
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
	<script>
		document.addEventListener('DOMContentLoaded', async () => {
			let getAllUsersHandler = new ApiHandler(
				'/api/getAllUsers', {},
				'POST'
			);
			await getAllUsersHandler.send();
			if (getAllUsersHandler.resData.success) {
				const users = getAllUsersHandler.resData.data.users;
				const tbody = document.querySelector('table tbody');
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
		})
	</script>
</main>

<?php require COMPONENTS . '/foot.php' ?>
