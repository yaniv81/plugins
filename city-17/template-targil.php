<?php
/*
  Template Name: Targil
 */
get_header();
?>
<div class="overlay"></div>
<div class="popmessage">
    <div class="popmessage-text"></div>
    <div class="close">x</div>
</div>
<div class="wrapper">
    <h1>SUBMIT YOUR APPLICATION</h1>
    <div class="form-container">
        <img class="people-img" src="<?= get_template_directory_uri() . "/img/people.svg" ?>" />

        <h2>Personal Information</h2>
        <p>Please fill in all mandatory fields</p>


        <div class="form-wrapper">
            <form id="contact-form">
                <div class="form-row">
                    <div class="form-item"><input type="text" name="fname" placeholder="*First Name" /></div>
                    <div class="form-item"><input type="text" name="lname" placeholder="*Last Name" /></div>
                </div> 
                <div class="form-row">
                    <div class="form-item"><input type="email" name="email" placeholder="*Email" /></div>
                    <div class="form-item"><input type="phone"  name="phone" placeholder="Phone Number" /></div>
                </div> 

                <div class="form-row">
                    <div class="form-item">
                        <select name="select_country" class="select-country placeholder">
                            <option value="">Choose Country</option>
                            <option value="israel">Israel</option>
                            <option value="italy">Italy</option>
                        </select>
                    </div>
                    <div class="form-item"><input type="text" class="date" name="date" placeholder="Date of Birth" /></div>
                </div> 
                <div class="sep"></div>
                <div class="form-row terms-row">
                    <div class="checkbox-wrapper">
                        <input type="checkbox"  name='terms'  id="terms"/><label for="terms"></label> 
                    </div>
                    <div>
                        <p>I have read and agree to the <a href="#">Terms and Conditions</a> and the <a href="#">Privacy Policy</a></p>
                    </div>
                </div>
                <div class="form-row form-row-hidden">
                    <div class="form-item"><input type="hidden" name="checkme" value="" id="hidden_input" /></div>
                </div> 
                <div class="form-row submit-row">
                    <input value="SUBMIT" type="submit" />
                </div>
                <div class="form-row form-group">

                </div>
            </form>

        </div>
    </div>

</div>


<?php
wp_footer();
