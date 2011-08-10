<form id="UserRegisterForm" method="post" action="/users/register" accept-charset="utf-8">
    <fieldset id="register_fieldset">
        <legend><h3>Terms &amp; Conditions</h3></legend>
        
        <p class="leader">
            In order to continue you must agree to our latest terms and conditions.
        </p>
        
        <img src="/img/management.png" />
        
        <?php echo $this->element('../users/_terms'); ?>
        <div class="input text">
            <label for="UserTerms">Agree Terms &amp; Conditions</label>
            <input name="data[User][terms]" type="checkbox" id="UserTerms" />
            <!-- This element exists only to ensure some data is present if they submit the form without agreeing to T&Cs. -->
            <input name="data[User][post]" type="hidden" id="UserPost" />
        </div>
        <div class="actions">
            <ul>
                <li><button type="submit" id="proceed_button"><span>Proceed</span></button></li>
            </ul>
        </div>
    </fieldset>
</form>