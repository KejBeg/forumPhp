
class ApiHandler {
	/**
	 * @param {string} url - The URL to send the request to.
	 * @param {object} reqData - The data to send in the request body.
	 * @param {string} method - The HTTP method to use (default is 'POST').
	 * @param {object} headers - Additional headers to include in the request.
	 */
	constructor(url, reqData = {}, method = "POST", headers = {}) {
		this.url = url;
		this.reqData = reqData;
		this.method = method;
		this.headers = {
			"Content-Type": "application/json",
			...headers,
		};


		if (isTokenPresent()) {
			this.headers["Authorization"] = `Bearer ${getToken()}`;
		}
	}


	async send() {
		const options = {
			method: this.method,
			headers: this.headers,
			body: JSON.stringify(this.reqData),
		};

		this.response = await fetch(this.url, options);

		this.resData = await this.response.json();

		let errorElement = document.querySelector("#error");
		if (this.resData.success) {
			errorElement.innerHTML = "";
		} else {
			errorElement.innerHTML = this.resData.message;
		}
	}
}

