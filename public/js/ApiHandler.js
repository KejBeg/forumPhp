class ApiHandler {
	constructor(url, data = {}, method = 'POST', headers = {}) {
		this.url = url;
		this.data = data;
		this.method = method;
		this.headers = {
			'Content-Type': 'application/json',
			...headers,
		};
	}

	async send() {
		try {
			const options = {
				method: this.method,
				headers: this.headers,
				body: JSON.stringify(this.data),
			};

			this.response = await fetch(this.url, options);

			if (!this.response.ok) {
				throw new Error('An error occured during register process');
			}

			this.data = await this.response.json();

			if (!this.data.success) {
				throw new Error(this.data.message);
			}
		} catch (error) {
			document.querySelector('#error').textContent = error;
			console.log(`API Error: ${error}`);
		}
	}
}

export default ApiHandler;

