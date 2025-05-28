<div id="add-message-container">
	<form id="addMessage-form">
		<input type='text' name='content' id='content' placeholder='Please log in' required disabled>
		<input type='submit' value='Send' name='send'>
	</form>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const contentInput = document.getElementById('content');
		if (isTokenPresent()){

		contentInput.disabled = false; 
			contentInput.placeholder = 'Type your message here...';
		}
	});
</script>

<script type="module">
	document.querySelector('#addMessage-form').addEventListener('submit', async (e) => {
		e.preventDefault();

		const form = e.target;
		let registerHandler = new ApiHandler(
			'/api/addMessage', {
				content: form.content.value,
			},
			'POST'
		);

		await registerHandler.send();

		if( registerHandler.resData.success) {
			form.content.value = '';
			fetchMessages();
		}

	});
</script>
