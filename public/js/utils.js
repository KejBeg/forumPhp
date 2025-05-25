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
