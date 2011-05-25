<form id="UserLoginForm" method="post" action="/users/login" accept-charset="utf-8">
    <fieldset id="login_fieldset">
        <legend>Login</legend>
        <div class="input text">
            <label for="UserEmailAddress">Email Address</label>
            <input name="data[User][email_address]" type="text" id="UserEmailAddress" />
        </div>
        <div class="input password">
            <label for="UserPassword">Password</label>
            <input type="password" name="data[User][password]" id="UserPassword" />
        </div>
        <div class="actions">
            <ul>
                <li><button type="submit" id="login_button"><span>Login</span></button></li>
                <li><a href="/password-retrieval" title="retrieve your password"><span>Retrieve Login Details</span></a></li>
            </ul>
        </div>
    </fieldset>
</form>