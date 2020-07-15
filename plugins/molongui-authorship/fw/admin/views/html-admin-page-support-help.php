<?php
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div id="molongui-help" class="molongui-flex-container">

	<div class="molongui-flex-row">

		<div id="molongui-help-ticket" class="molongui-flex-column">
			<div class="molongui-flex-content">
                <h3><?php _e( 'Open a support ticket', 'molongui-common-framework' ); ?></h3>
                <p><?php printf( __( 'Submit a ticket below and get help from our friendly and knowledgeable %sMolonguis%s. We reply to every ticket, please check your Spam folder if you haven’t heard from us.', 'molongui-common-framework' ), '<i>', '</i>'); ?></p>
                <form id="molongui-help-ticket-form">
                    <div id="molongui-form-error" class="hidden"><?php _e( 'All fields are mandatory', 'molongui-common-framework' ); ?></div>
                    <p>
                        <label class="sr-only">Your Name</label>
                        <input type="text" name="your-name" required placeholder="<?php _e( 'Your name here', 'molongui-common-framework' ); ?>">
                    </p>
                    <p>
                        <label class="sr-only">Your Email</label>
                        <input type="email" name="your-email" required placeholder="<?php _e( 'Your e-mail here', 'molongui-common-framework' ); ?>">
                    </p>
                    <p>
                        <label class="sr-only">Subject</label>
                        <input type="text" name="your-subject" required placeholder="<?php _e( 'A subject here', 'molongui-common-framework' ); ?>">
                    </p>
                    <p>
                        <label class="sr-only">Plugin</label>
                        <select name="plugin" required>
                            <option value="">---</option>
                            <option value="Molongui Authorship Plugin">Molongui Authorship Plugin</option>
                            <option value="Molongui Bump Offer Plugin">Molongui Bump Offer Plugin</option>
                        </select>
                    </p>
                    <p>
                        <label class="sr-only"><?php _e( 'Your message', 'molongui-common-framework' ); ?></label>
                        <textarea name="your-message" cols="40" rows="7" required placeholder="Your message here"></textarea>
                    </p>
                    <p><input type="checkbox" id="molongui-accept-tos" name="molongui-accept-tos" value="1">I have read and accept the <a href="/privacy/">privacy policy</a>.</p>
                    <p class="hidden"><input type="hidden" name="ticket-id" value="<?php echo 'HR'.date('y').'-'.date('mdHis'); ?>"></p>
         <!--           <p><input id="molongui-submit-ticket" type="submit" value="<?php _e( 'Open ticket', 'molongui-common-framework' ); ?>"></p>-->
                    <button id="molongui-submit-ticket" type="submit"><?php _e( 'Open ticket', 'molongui-common-framework' ); ?></button>
                </form>
			</div>
		</div>

		<div id="molongui-help-chat" class="molongui-flex-column">
			<div class="molongui-flex-content">
                <h3><?php _e( 'Chat with us', 'molongui-common-framework' ); ?></h3>
                <p><?php printf( __( 'We speak English and Spanish and answer Monday to Friday during normal business hours (GMT). If offline, we will get back to you when back, so make sure to leave your e-mail address so we can reach you.', 'molongui-common-framework' ), '<i>', '</i>'); ?></p>
                <iframe src="https://www.tidiochat.com/chat/foioudbu7xqepgvwseufnvhcz6wkp7am"></iframe>
			</div>
		</div>

	</div>

</div>