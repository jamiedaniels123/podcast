<form id="UserRegisterForm" method="post" action="/users/register" accept-charset="utf-8">
    <fieldset id="register_fieldset">
        <legend><h3>Terms &amp; Conditions</h3></legend>
        
        <p class="leader">
            In order to continue you must agree to our latest terms and conditions. <a href="http://www8.open.ac.uk/about/main/admin-and-governance/policies-and-statements/conditions-use-open-university-websites"  title="click here to view our terms and conditions">Click here to view</a>
        </p>
        
        <img src="/img/management.png" />
        
        
        <!--<?php echo $this->element('../users/_terms'); ?>-->
        
        <div id="content" class="checkbox" style="margin: 30px 0px 15px 50px;">
            <label for="UserTerms">I agree terms &amp; conditions</label>
            <input name="data[User][terms]" type="checkbox" id="UserTerms" />
            <!-- This element exists only to ensure some data is present if they submit the form without agreeing to T&Cs. -->
            <input name="data[User][post]" type="hidden" id="UserPost" />
        </div>
        
			<button type="submit" style="margin: 0px 0px 0px 68px;" class="button blue" id="proceed_button"><span>Proceed</span></button>
            
    </fieldset>
</form>