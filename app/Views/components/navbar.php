        <nav class='navbar'>
        	<ul>
        		<li><a href='/'>Home</a></li>
        		<script>
        			(async () => {
        				let navbar = document.querySelector('.navbar ul ');
        				if (await isTokenPresent()) {
        					$user = await getProfileInfo();
        					navbar.innerHTML += `<li><a href='/profile'>${$user.name}</a></li>`;
        					navbar.innerHTML += `<li><a href='/logout'>Logout</a></li>`;
        				} else {
        					navbar.innerHTML += `<li><a href='/login'>Login</a></li>`;
									navbar.innerHTML += `<li><a href='/register'>Register</a></li>`;
        				}
        			})();
        		</script>

        	</ul>
        </nav>
        </nav>
        </nav>
