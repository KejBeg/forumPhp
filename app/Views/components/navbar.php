        <nav class='navbar'>
        		<div id="navbar-links">
        			<div><a href='/'>Chat</a></div>
							<div><a href='/users'>Users</a></div>
        		</div>
        		<div id="profile-links">
        			<script>
        				(async () => {
        					let navbar = document.querySelector('#profile-links');
        					if (await isTokenPresent()) {
        						let user = await getProfileInfo();

										let div = document.createElement('div');
										let a = document.createElement('a');
										a.href = '/profile';
										a.textContent = user.username;
										div.appendChild(a);
										navbar.appendChild(div);

										div= document.createElement('div');
										a = document.createElement('a');
										a.href = '/logout';
										a.textContent = 'Logout';
										div.appendChild(a);
										navbar.appendChild(div);
									} else {
										let div= document.createElement('div');
										let a = document.createElement('a');
										a.href = '/login';
										a.textContent = 'Login';
										div.appendChild(a);
										navbar.appendChild(div);

										div= document.createElement('div');
										a = document.createElement('a');
										a.href = '/register';
										a.textContent = 'Register';
										div.appendChild(a);
										navbar.appendChild(div);
        					}
        				})();
        			</script>
        		</div>

        	</ul>
        </nav>
