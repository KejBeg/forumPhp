function isTokenPresent() {
	const token = getCookie("access_token");
	if (!token) {
		return false;
	}
	return true;
}

function getToken() {
	if (!isTokenPresent()) return null;
	return getCookie("access_token");
}

async function getProfileInfo() {
	if (!isTokenPresent()) return null;

	let checkHandler = new ApiHandler("/api/check", {}, "POST");
	await checkHandler.send();

	return checkHandler.resData.data;
}

function getCookie(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(";").shift();
}

function removeCookie(name) {
	document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

async function fetchMessages() {
	const messagesList = document.querySelector(".message-list-container ul");
	let getMessagesHandler = new ApiHandler("/api/getMessages", {}, "POST");

	await getMessagesHandler.send();

	if (getMessagesHandler.resData.success) {
		const messages = getMessagesHandler.resData.data.messages;

		messagesList.innerHTML = "";

		messages.forEach((message) => {
			const li = document.createElement("li");

			const textEl = document.createElement("span");
			textEl.textContent = `${message.username}: ${message.content}`;

			const editButton = document.createElement("button");
			editButton.textContent = "Edit";
			editButton.classList.add("edit-button");
			editButton.addEventListener("click", async () => {
				const newContent = prompt("Edit your message:", message.content);
				if (newContent) {
					let editMessageHandler = new ApiHandler(
						"/api/editMessage",
						{
							messageId: message.id,
							content: newContent,
						},
						"POST",
					);
					await editMessageHandler.send();
					if (editMessageHandler.resData.success) {
						fetchMessages();
					}
				}
			});

			const deleteButton = document.createElement("button");
			deleteButton.textContent = "Delete";
			deleteButton.classList.add("delete-button");
			deleteButton.addEventListener("click", async () => {
				const deleteHandler = new ApiHandler(
					"/api/deleteMessage",
					{ messageId: message.id },
					"POST",
				);
				await deleteHandler.send();
				if (deleteHandler.resData.success) {
					fetchMessages();
				}
			});

			li.appendChild(textEl);
			li.appendChild(editButton);
			li.appendChild(deleteButton);

			messagesList.appendChild(li);
		});
	}
}

async function messageEditing() {
	const messagesList = document.querySelector(".message-list-container ul");
	if (!isTokenPresent()) return;
	const currentUserId = getProfileInfo().id;

	for (const li of messagesList.children) {
	}
}
