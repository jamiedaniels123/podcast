<form id="UserLoginForm" method="post" action="/users/login" accept-charset="utf-8">
    <fieldset id="login_fieldset">
        <legend><h3>Login</h3></legend>
        <div class="input text">
            <label for="UserEmailAddress">Email Address</label>
            <input name="data[User][email_address]" type="text" id="UserEmailAddress" />
        </div>
        <div class="input password">
            <label for="UserPassword">Password</label>
            <input type="password" name="data[User][password]" id="UserPassword" />
        </div>
				<button type="submit" class="button blue" id="login_button"><span>Login</span></button>
				<a href="/password-retrieval" class="button white" title="retrieve your password"><span>Retrieve Login Details</span></a>
    </fieldset>
</form>