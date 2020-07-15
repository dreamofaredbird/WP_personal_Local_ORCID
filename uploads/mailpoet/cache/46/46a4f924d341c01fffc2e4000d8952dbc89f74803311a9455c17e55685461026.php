<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* settings.html */
class __TwigTemplate_57905a2cdcd8a21d6220fb31aa3d4943bafbf55b914c3532b3d645e11e2bb4b2 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "settings.html", 1);
        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "  <div id=\"mailpoet_settings\">

    <h1 class=\"title\">";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Settings");
        echo "</h1>

    <!-- settings form  -->
    <form
      id=\"mailpoet_settings_form\"
      name=\"mailpoet_settings_form\"
      class=\"mailpoet_form\"
      autocomplete=\"off\"
      novalidate
    >
      <!-- tabs -->
      <h2 class=\"nav-tab-wrapper\" id=\"mailpoet_settings_tabs\">
        <a class=\"nav-tab\" href=\"#basics\" data-automation-id=\"basic_settings_tab\">";
        // line 18
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Basics");
        echo "</a>
        <a class=\"nav-tab\" href=\"#signup\" data-automation-id=\"signup_settings_tab\">";
        // line 19
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sign-up Confirmation");
        echo "</a>
        <a class=\"nav-tab\" href=\"#mta\" data-automation-id=\"send_with_settings_tab\">";
        // line 20
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send With...");
        echo "</a>
        ";
        // line 21
        if (($context["is_woocommerce_active"] ?? null)) {
            // line 22
            echo "          <a class=\"nav-tab\" href=\"#woocommerce\" data-automation-id=\"woocommerce_settings_tab\">";
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("WooCommerce");
            echo "</a>
        ";
        }
        // line 24
        echo "        <a class=\"nav-tab\" href=\"#advanced\" data-automation-id=\"settings-advanced-tab\">";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Advanced");
        echo "</a>
        <a class=\"nav-tab\" href=\"#premium\" data-automation-id=\"activation_settings_tab\">";
        // line 25
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Key Activation");
        echo "</a>
      </h2>

      <!-- sending method -->
      <div data-tab=\"mta\" class=\"mailpoet_tab_panel\">
        ";
        // line 30
        $this->loadTemplate("settings/mta.html", "settings.html", 30)->display($context);
        // line 31
        echo "      </div>

      <!-- basics -->
      <div data-tab=\"basics\" class=\"mailpoet_tab_panel\">
        ";
        // line 35
        $this->loadTemplate("settings/basics.html", "settings.html", 35)->display($context);
        // line 36
        echo "      </div>

      <!-- sign-up confirmation -->
      <div data-tab=\"signup\" class=\"mailpoet_tab_panel\">
        ";
        // line 40
        $this->loadTemplate("settings/signup.html", "settings.html", 40)->display($context);
        // line 41
        echo "      </div>

      ";
        // line 43
        if (($context["is_woocommerce_active"] ?? null)) {
            // line 44
            echo "        <!-- woocommerce -->
        <div data-tab=\"woocommerce\" class=\"mailpoet_tab_panel\">
          ";
            // line 46
            $this->loadTemplate("settings/woocommerce.html", "settings.html", 46)->display($context);
            // line 47
            echo "        </div>
      ";
        }
        // line 49
        echo "
     <!-- advanced -->
      <div data-tab=\"advanced\" class=\"mailpoet_tab_panel\">
        ";
        // line 52
        $this->loadTemplate("settings/advanced.html", "settings.html", 52)->display($context);
        // line 53
        echo "      </div>

      <!-- premium -->
      <div data-tab=\"premium\" class=\"mailpoet_tab_panel\">
        ";
        // line 57
        $this->loadTemplate("settings/premium.html", "settings.html", 57)->display($context);
        // line 58
        echo "      </div>

      <p class=\"submit mailpoet_settings_submit\" style=\"display:none;\">
        <input
          type=\"submit\"
          class=\"button button-primary\"
          name=\"submit\"
          data-automation-id=\"settings-submit-button\"
          value=\"";
        // line 66
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Save settings");
        echo "\"
        />
      </p>
    </form>
  </div>

  <script type=\"text/javascript\">
    jQuery(function(\$) {
      // on dom loaded
      \$(function() {
        // on form submission
        \$('#mailpoet_settings_form').on('submit', function() {
          var errorFound = false;
          // Check if filled emails are valid
          var invalidEmails = \$.map(\$('#mailpoet_settings_form')[0].elements, function(el) {
            return el.type === 'email' && el.value && !window.mailpoet_email_regex.test(el.value) ? el.value : null;
          }).filter(function(val) { return !!val; });
          if (invalidEmails.length) {
            MailPoet.Notice.error(
              \"";
        // line 85
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("Invalid email addresses: "), "js"), "html", null, true);
        echo "\" + invalidEmails.join(', '),
              { scroll: true }
            );
            errorFound = true;
          }
          // if reCAPTCHA is enabled but keys are emty, show error
          var enabled = \$('input[name=\"captcha[type]\"]:checked').val() == 'recaptcha',
              site_key = \$('input[name=\"captcha[recaptcha_site_token]\"]').val().trim(),
              secret_key = \$('input[name=\"captcha[recaptcha_secret_token]\"]').val().trim();
          if (enabled && (site_key == '' || secret_key == '')) {
            \$('#settings_recaptcha_tokens_error').show();
            window.location.href = '#advanced';
            errorFound = true;
          } else {
            \$('#settings_recaptcha_tokens_error').hide();
          }
          // if new subscriber notification is enabled but sender is empty, show error
          var notifications_enabled = \$('input[name=\"subscriber_email_notification[enabled]\"]:checked').val(),
            address = \$('input[name=\"subscriber_email_notification[address]\"]').val().trim();
          if (notifications_enabled && address == '') {
            \$('#settings_subscriber_email_notification_error').show();
            window.location.href = '#basics';
            errorFound = true;
          } else {
            \$('#settings_subscriber_email_notification_error').hide();
          }
          var stats_notifications_enabled = \$('input[name=\"stats_notifications[enabled]\"]:checked').val(),
            stats_notifications_address = \$('input[name=\"stats_notifications[address]\"]').val().trim();
          if (stats_notifications_enabled && stats_notifications_address == '') {
            \$('#settings_stats_notifications_error').show();
            window.location.href = '#basics';
            errorFound = true;
          } else {
            \$('#settings_stats_notifications_error').hide();
          }
          ";
        // line 120
        if (($context["is_woocommerce_active"] ?? null)) {
            // line 121
            echo "            // if WooCommerce opt-in on checkout is enabled but the checkbox message is empty, show an error
            var woocommerce_optin_on_checkout_enabled = \$('input[name=\"woocommerce[optin_on_checkout][enabled]\"]:checked').val(),
              woocommerce_optin_on_checkout_message = \$('input[name=\"woocommerce[optin_on_checkout][message]\"]').val().trim();
            if (woocommerce_optin_on_checkout_enabled && woocommerce_optin_on_checkout_message == '') {
              \$('#settings_woocommerce_optin_on_checkout_error').show();
              window.location.href = '#woocommerce';
              errorFound = true;
            } else {
              \$('#settings_woocommerce_optin_on_checkout_error').hide();
            }
          ";
        }
        // line 132
        echo "          // stop processing if an error was found
          if (errorFound) {
            return false;
          }
          // if we're setting up a sending method, try to activate it
          if (\$('.mailpoet_mta_setup_save').is(':visible')) {
            \$('.mailpoet_mta_setup_save').trigger('click');
          }
          var mailpoet_premium_key = \$('#mailpoet_premium_key').val();
          // sync mss key with premium key
          \$('#mailpoet_api_key').val(mailpoet_premium_key);
          if (mailpoet_premium_key.length > 0) {
            \$('#mailpoet_premium_key_verify').trigger('click', false);
          }
          saveSettings();
          return false;
        });

        function saveSettings() {
          // serialize form data
          var settings_data = \$('#mailpoet_settings_form').mailpoetSerializeObject();

          // show loading screen
          MailPoet.Modal.loading(true);

          MailPoet.Ajax.post({
            api_version: window.mailpoet_api_version,
            endpoint: 'settings',
            action: 'set',
            data: settings_data
          }).always(function() {
            MailPoet.Modal.loading(false);
          }).done(function(response) {
            MailPoet.Notice.success(
              \"";
        // line 166
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("Settings saved"), "js"), "html", null, true);
        echo "\",
              { scroll: true }
            );
            MailPoet.trackEvent(
              'User has saved Settings',
              {
                'MailPoet Free version': window.mailpoet_version,
                'Sending method type': settings_data.mta_group || null,
                'Sending frequency (emails)': settings_data.mta_group != 'mailpoet' && settings_data.mta && settings_data.mta.frequency && settings_data.mta.frequency.emails,
                'Sending frequency (interval)': settings_data.mta_group != 'mailpoet' && settings_data.mta && settings_data.mta.frequency && settings_data.mta.frequency.interval,
                'Sending provider': settings_data.mta_group == 'smtp' && settings_data.smtp_provider,
                'Sign-up confirmation enabled': (settings_data.signup_confirmation && settings_data.signup_confirmation.enabled == true),
                'Bounce email is present': (settings_data.bounce && settings_data.bounce.address != \"\"),
                'Newsletter task scheduler method': (settings_data.cron_trigger && settings_data.cron_trigger.method)
              }
            );
          }).fail(function(response) {
            if (response.errors.length > 0) {
              MailPoet.Notice.error(
                response.errors.map(function(error) { return error.message; }),
                { scroll: true }
              );
            }
          });
        }

        // setup toggle checkboxes
        function toggleContent() {
          \$('#'+\$(this).data('toggle'))[
            (\$(this).is(':checked'))
            ? 'show'
            : 'hide'
          ]();
        }

        \$(document).on('click', 'input[data-toggle]', toggleContent);
        \$('input[data-toggle]').each(toggleContent);

        function toggleReCaptchaSettings() {
          if (\$('input[name=\"captcha[type]\"]:checked').val() == 'recaptcha') {
            \$('#settings_recaptcha_tokens').show();
          } else {
            \$('#settings_recaptcha_tokens').hide();
          }
        }
        \$('input[name=\"captcha[type]\"]').on('click', toggleReCaptchaSettings);
        toggleReCaptchaSettings();
        \$('#settings_recaptcha_tokens_error').hide();

        \$('#settings_subscriber_email_notification_error').hide();
        \$('#settings_stats_notifications_error').hide();

        ";
        // line 218
        if (($context["is_woocommerce_active"] ?? null)) {
            // line 219
            echo "          \$('#settings_woocommerce_optin_on_checkout_error').hide();
        ";
        }
        // line 221
        echo "
        function toggleLinuxCronSettings() {
          if (\$('input[name=\"cron_trigger[method]\"]:checked').val() === '";
        // line 223
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["cron_trigger"] ?? null), "linux_cron", []), "html", null, true);
        echo "') {
            \$('#settings_linux_cron').show();
          } else {
            \$('#settings_linux_cron').hide();
          }
        }
        \$('input[name=\"cron_trigger[method]\"]').on('click', toggleLinuxCronSettings);
        toggleLinuxCronSettings();

        // page preview
        \$('.mailpoet_page_preview').on('click', function() {
          var selection = \$(this).siblings('.mailpoet_page_selection');

          if (selection.length > 0) {
            \$(this).attr('href', \$(selection).find('option[value=\"'+\$(selection).val()+'\"]').data('preview-url'));
            \$(this).attr('target', '_blank');
          } else {
            \$(this).attr('href', 'javascript:;');
            \$(this).removeAttr('target');
          }
        });
      });
    });
    ";
        // line 246
        $context["newUser"] = (((($context["is_new_user"] ?? null) == true)) ? ("true") : ("false"));
        // line 247
        echo "    ";
        // line 248
        echo "      var mailpoet_is_new_user = ";
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["newUser"] ?? null), "js", null, true);
        echo ";
      var mailpoet_settings_sender_name = \"";
        // line 249
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sender", []), "name", []), "js", null, true);
        echo "\";
      var mailpoet_settings_sender_adddress = \"";
        // line 250
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sender", []), "address", []), "js", null, true);
        echo "\";
      var mailpoet_settings_reply_to_name = \"";
        // line 251
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "reply_to", []), "name", []), "js", null, true);
        echo "\";
      var mailpoet_settings_reply_to_address = \"";
        // line 252
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "reply_to", []), "address", []), "js", null, true);
        echo "\";
      var mailpoet_settings_signup_confirmation_name = \"";
        // line 253
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "from", []), "name", []), "js", null, true);
        echo "\";
      var mailpoet_settings_signup_confirmation_address = \"";
        // line 254
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "from", []), "address", []), "js", null, true);
        echo "\";
      var mailpoet_installed_at = '";
        // line 255
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["settings"] ?? null), "installed_at", []), "js", null, true);
        echo "';
      var mailpoet_mss_active = ";
        // line 256
        echo json_encode(($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "mailpoet"));
        echo ";
    ";
        // line 258
        echo "    var mailpoet_beacon_articles = [
      '57f71d49c697911f2d323486',
      '57fb0e1d9033600277a681ca',
      '57f49a929033602e61d4b9f4',
      '57fb134cc697911f2d323e3b',
    ];
  </script>
";
    }

    // line 266
    public function block_translations($context, array $blocks = [])
    {
        // line 267
        echo "  ";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["reinstallConfirmation" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Are you sure? All of your MailPoet data will be permanently erased (newsletters, statistics, subscribers, etc.)."), "announcementHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Get notified when someone subscribes"), "announcementParagraph1" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("It’s been a popular feature request from our users, we hope you get lots of emails about all your new subscribers!"), "announcementParagraph2" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("(You can turn this feature off if it’s too many emails.)"), "yourName" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your name"), "from" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("From"), "replyTo" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Reply-to")]);
        // line 275
        echo "
";
    }

    public function getTemplateName()
    {
        return "settings.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  414 => 275,  411 => 267,  408 => 266,  397 => 258,  393 => 256,  389 => 255,  385 => 254,  381 => 253,  377 => 252,  373 => 251,  369 => 250,  365 => 249,  360 => 248,  358 => 247,  356 => 246,  330 => 223,  326 => 221,  322 => 219,  320 => 218,  265 => 166,  229 => 132,  216 => 121,  214 => 120,  176 => 85,  154 => 66,  144 => 58,  142 => 57,  136 => 53,  134 => 52,  129 => 49,  125 => 47,  123 => 46,  119 => 44,  117 => 43,  113 => 41,  111 => 40,  105 => 36,  103 => 35,  97 => 31,  95 => 30,  87 => 25,  82 => 24,  76 => 22,  74 => 21,  70 => 20,  66 => 19,  62 => 18,  47 => 6,  43 => 4,  40 => 3,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "settings.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/settings.html");
    }
}
