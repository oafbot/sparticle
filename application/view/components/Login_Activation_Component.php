<div id=container>
    <p>Your account needs to be activated before you can log in.
    <br />
    Please enter your email address below, and a confirmation key will be sent to you.
    </p>
    <br />
    <form id="login" method="post" action="<? self::path_to('/account/resend_confirmation/'); ?>" >
        <fieldset>
            <div>
                <label>Email
                    <input type="email" name="email" id="email" required="true"/>
                </label>&nbsp;&nbsp;
                <label>
                    <input type="submit" name="button" id="login_button" value="send"/>
                </label>
            </div>        
         </fieldset>       
    </form>
</div>