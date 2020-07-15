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

/* settings/mta.html */
class __TwigTemplate_bc82896d5ed75bc9621e50a1d543d97fe7ce7a1724725ff43a9759978c66f0d2 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context["intervals"] = [0 => 1, 1 => 2, 2 => 5, 3 => 10, 4 => 15, 5 => 30];
        // line 2
        $context["default_frequency"] = ["website" => ["emails" => 25, "interval" => 5], "smtp" => ["emails" => 100, "interval" => 5]];
        // line 12
        echo "
<!-- mta: group -->
<input
  type=\"hidden\"
  id=\"mta_group\"
  name=\"mta_group\"
  value=\"";
        // line 18
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["settings"] ?? null), "mta_group", []), "html", null, true);
        echo "\"
/>
<input
  type=\"hidden\"
  id=\"mailpoet_smtp_provider\"
  name=\"mailpoet_smtp_provider\"
  value=\"";
        // line 24
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["settings"] ?? null), "smtp_provider", []), "html", null, true);
        echo "\"
/>
<!-- mta: method -->
<input
  type=\"hidden\"
  id=\"mta_method\"
  name=\"mta[method]\"
  value=\"";
        // line 31
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "method", []), "html", null, true);
        echo "\"
/>

<!-- mta: sending frequency -->
<input
  type=\"hidden\"
  id=\"mta_frequency_emails\"
  name=\"mta[frequency][emails]\"
  value=\"";
        // line 39
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "frequency", []), "emails", []), "html", null, true);
        echo "\"
/>
<input
  type=\"hidden\"
  id=\"mta_frequency_interval\"
  name=\"mta[frequency][interval]\"
  value=\"";
        // line 45
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "frequency", []), "interval", []), "html", null, true);
        echo "\"
/>

<!-- mta: mailpoet sending service key -->
<input
  type=\"hidden\"
  id=\"mailpoet_api_key\"
  name=\"mta[mailpoet_api_key]\"
  value=\"";
        // line 53
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "mailpoet_api_key", []), "html", null, true);
        echo "\"
/>

<!-- smtp: available sending methods -->
<ul class=\"mailpoet_sending_methods\">
  <li
    data-group=\"mailpoet\"
    class=\"";
        // line 60
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "mailpoet")) {
            echo " mailpoet_active ";
        }
        echo " ";
        if ( !($context["mss_key_valid"] ?? null)) {
            echo " mailpoet_invalid_key ";
        }
        echo "\"
  >
    <div class=\"mailpoet_sending_method_description\">
      <h3>
        ";
        // line 64
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("MailPoet Sending Service");
        echo "
      </h3>

      <div class=\"mailpoet_description\">
        <span class=\"";
        // line 68
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "mailpoet")) {
            echo " mailpoet_hidden";
        }
        echo "\" id=\"mailpoet_sending_method_active_text\">
          <strong>";
        // line 69
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("You're now sending with MailPoet!");
        echo "</strong>
        </span>

        <span class=\"";
        // line 72
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "mailpoet")) {
            echo " mailpoet_hidden";
        }
        echo "\" id=\"mailpoet_sending_method_inactive_text\">
          <strong>";
        // line 73
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Solve all of your sending problems!");
        echo "</strong>
        </span>

        <ul class=\"sending-method-benefits mailpoet_success\">
          <li class=\"mailpoet_success_item\">";
        // line 77
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Reach the inbox, not the spam box.");
        echo "</li>
          <li class=\"mailpoet_success_item\">";
        // line 78
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Easy configuration: enter a key to activate the sending service.");
        echo "</li>
          <li class=\"mailpoet_success_item\">";
        // line 79
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Super fast: send up to 50,000 emails per hour.");
        echo "</li>
          <li class=\"mailpoet_success_item\">";
        // line 80
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("All emails are signed with SPF & DKIM.");
        echo "</li>
          <li class=\"mailpoet_success_item\">";
        // line 81
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Automatically remove invalid and bounced addresses (bounce handling) to keep your lists clean.");
        echo "</li>
        </ul>

        <p class=\"mailpoet_sending_methods_help\">
          ";
        // line 85
        $context["badgeClassName"] = (((($context["is_new_user"] ?? null) == true)) ? ("mailpoet_badge mailpoet_badge_video") : ("mailpoet_badge mailpoet_badge_video mailpoet_badge_video_grey"));
        // line 86
        echo "          ";
        echo MailPoet\Util\Helpers::replaceLinkTags(sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("[link]%s See video guide[/link]"), "<span class=\"dashicons dashicons-format-video\"></span>"), "https://kb.mailpoet.com/article/235-video-guide-sending-options", ["class" =>         // line 88
($context["badgeClassName"] ?? null), "target" => "_blank", "data-beacon-article" => "5a3d4c260428631938003802"], "link");
        // line 90
        echo "
        </p>
      </div>
    </div>
    <div class=\"mailpoet_status ";
        // line 94
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "mailpoet") ||  !($context["mss_key_valid"] ?? null))) {
            echo " mailpoet_invalid_key ";
        }
        echo "\">
      <div class=\"mailpoet_activated ";
        // line 95
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "mailpoet") ||  !($context["mss_key_valid"] ?? null))) {
            echo " mailpoet_hidden ";
        }
        echo "\">
        <span>";
        // line 96
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activated");
        echo "</span>
      </div>
      <div class=\"mailpoet_actions\">
        <div class=\"mailpoet_invalid_key ";
        // line 99
        if (($context["mss_key_valid"] ?? null)) {
            echo " mailpoet_hidden ";
        }
        echo "\">
          <a class=\"button-primary\" href=\"";
        // line 100
        echo $this->env->getExtension('MailPoet\Twig\Functions')->addReferralId("https://www.mailpoet.com/free-plan");
        echo "\" rel=\"noopener noreferrer\" target=\"_blank\">";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Free up to 1,000 subscribers");
        echo "</a>
          ";
        // line 101
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("or");
        echo "
          ";
        // line 102
        echo MailPoet\Util\Helpers::replaceLinkTags($this->env->getExtension('MailPoet\Twig\I18n')->translate("[link]enter your key[/link]"), "#premium");
        // line 106
        echo "
        </div>
        <div class=\"mailpoet_valid_key ";
        // line 108
        if (( !($context["mss_key_valid"] ?? null) || ($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "mailpoet"))) {
            echo " mailpoet_hidden ";
        }
        echo "\">
          <button type=\"button\" class=\"mailpoet_sending_service_activate button-primary\">";
        // line 109
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activate");
        echo "</button>
        </div>
      </div>
  </li>
  <li
    data-group=\"other\"
    ";
        // line 115
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "mailpoet")) {
            echo "class=\"mailpoet_active\"";
        }
        // line 116
        echo "  >
    <div class=\"mailpoet_sending_method_description\">
      <h3>";
        // line 118
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Other");
        echo "</h3>
      <div class=\"mailpoet_description\">
        <strong>";
        // line 120
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send emails via your host (not recommended!) or via a third-party sender.");
        echo "</strong>
        <ul class=\"sending-method-benefits mailpoet_error\">
          <li class=\"mailpoet_error_item\">";
        // line 122
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Unless you're a pro, you’ll probably end up in spam.");
        echo "</li>
          <li class=\"mailpoet_error_item\">";
        // line 123
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sending speed is limited by your host and/or your third-party (with a 2,000 per hour maximum).");
        echo "</li>
          <li class=\"mailpoet_error_item\">";
        // line 124
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Manual configuration of SPF and DKIM required.");
        echo "</li>
          <li class=\"mailpoet_error_item\">";
        // line 125
        echo MailPoet\Util\Helpers::replaceLinkTags($this->env->getExtension('MailPoet\Twig\I18n')->translate("Bounce handling is available, but only with an extra [link]add-on[/link]."), "https://wordpress.org/plugins/bounce-handler-mailpoet/", ["target" => "_blank"]);
        // line 129
        echo "
          </li>
        </ul>
      </div>
    </div>
    <div class=\"mailpoet_status\">
      <span>";
        // line 135
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activated");
        echo "</span>
      <div class=\"mailpoet_actions\">
        ";
        // line 137
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "mailpoet")) {
            // line 138
            echo "          <a class=\"button-primary mailpoet_other_sending_method_action\" href=\"#mta/other\">";
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activate");
            echo "</a>
        ";
        } else {
            // line 140
            echo "          <a class=\"button-secondary mailpoet_other_sending_method_action\" href=\"#mta/other\">";
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Configure");
            echo "</a>
        ";
        }
        // line 142
        echo "      </div>
    </div>
  </li>
</ul>

<div id=\"mailpoet_sending_method_setup\">

  <!-- Sending Method: Other -->
  <div class=\"mailpoet_sending_method\" data-group=\"other\" style=\"display:none;\">
    <table class=\"form-table\">
      <tr>
        <th scope=\"row\">
          <label for=\"mailpoet_smtp_method\">
            ";
        // line 155
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Method");
        echo "
          </label>
        </th>
        <td>
          <!-- smtp provider -->
          <select
            id=\"mailpoet_smtp_method\"
            name=\"smtp_provider\"
          >
            <option data-interval=\"5\" data-emails=\"25\" value=\"server\">
              ";
        // line 165
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your web host / web server");
        echo "
            </option>
            <option data-interval=\"5\" data-emails=\"100\" value=\"manual\"
              ";
        // line 169
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "smtp")) {
            // line 171
            echo "              selected=\"selected\"
              ";
        }
        // line 173
        echo "            >
              ";
        // line 174
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("SMTP");
        echo "
            </option>
            <!-- providers -->
            <optgroup label=\"";
        // line 177
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select your provider");
        echo "\">
              ";
        // line 178
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable($this->getAttribute(($context["hosts"] ?? null), "smtp", []));
        foreach ($context['_seq'] as $context["host_key"] => $context["host"]) {
            // line 179
            echo "              <option
                value=\"";
            // line 180
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["host_key"], "html", null, true);
            echo "\"
                data-emails=\"";
            // line 181
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["host"], "emails", []), "html", null, true);
            echo "\"
                data-interval=\"";
            // line 182
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["host"], "interval", []), "html", null, true);
            echo "\"
                data-fields=\"";
            // line 183
            echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_join_filter($this->getAttribute($context["host"], "fields", []), ","), "html", null, true);
            echo "\"
              ";
            // line 184
            if (($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) == $context["host_key"])) {
                // line 185
                echo "              selected=\"selected\"
              ";
            }
            // line 187
            echo "              >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["host"], "name", []), "html", null, true);
            echo "</option>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['host_key'], $context['host'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 189
        echo "            </optgroup>
          </select>
        </td>
      </tr>
      <tr id=\"mailpoet_sending_method_host\"
        ";
        // line 195
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "smtp")) {
            // line 197
            echo "        style=\"display:none;\"
        ";
        }
        // line 199
        echo "      >
        <th scope=\"row\">
          <label for=\"mailpoet_web_host\">
            ";
        // line 202
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your web host");
        echo "
          </label>
        </th>
        <td>
          <p>
            <!-- sending frequency -->
            <select
              id=\"mailpoet_web_host\"
              name=\"web_host\"
            >

              <!-- web hosts -->
              <option
                value=\"manual\"
                data-emails=\"25\"
                data-interval=\"5\"
                label=\"";
        // line 218
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Not listed (default)");
        echo "\"
              >
              ";
        // line 220
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable($this->getAttribute(($context["hosts"] ?? null), "web", []));
        foreach ($context['_seq'] as $context["host_key"] => $context["host"]) {
            // line 221
            echo "              <option
                value=\"";
            // line 222
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["host_key"], "html", null, true);
            echo "\"
                data-emails=\"";
            // line 223
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["host"], "emails", []), "html", null, true);
            echo "\"
                data-interval=\"";
            // line 224
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["host"], "interval", []), "html", null, true);
            echo "\"
              ";
            // line 225
            if (($this->getAttribute(($context["settings"] ?? null), "web_host", []) == $context["host_key"])) {
                // line 226
                echo "              selected=\"selected\"
              ";
            }
            // line 228
            echo "              >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["host"], "name", []), "html", null, true);
            echo "</option>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['host_key'], $context['host'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 230
        echo "            </select>
          </p>

        </td>
      </tr>
      <tr>
        <th scope=\"row\">
          <label for=\"mailpoet_web_host\">
            ";
        // line 238
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sending frequency");
        echo "
          </label>
        </th>
        <td>
          <p>
            <!-- sending frequency -->
            <select
              id=\"mailpoet_sending_frequency\"
              name=\"mailpoet_sending_frequency\"
            >
              <option value=\"auto\">
                ";
        // line 249
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Recommended");
        echo "
              </option>
              <option value=\"manual\"
                ";
        // line 253
        if ( !($this->getAttribute(($context["settings"] ?? null), "mailpoet_sending_frequency", []) == "auto")) {
            // line 255
            echo "                selected=\"selected\"
                ";
        }
        // line 257
        echo "              >
                ";
        // line 258
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("I'll set my own frequency");
        echo "
              </option>
            </select>
            <span id=\"mailpoet_recommended_daily_emails\"></span>
          </p>
          <div id=\"mailpoet_sending_frequency_manual\"
            ";
        // line 265
        if (($this->getAttribute(($context["settings"] ?? null), "mailpoet_sending_frequency", []) == "auto")) {
            // line 267
            echo "              style=\"display: none\"
            ";
        }
        // line 269
        echo "          >
            <p>
              <input
                id=\"other_frequency_emails\"
                type=\"number\"
                min=\"1\"
                max=\"1000\"
              ";
        // line 276
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "frequency", []), "emails", [])) {
            // line 277
            echo "                value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "frequency", []), "emails", []), "html", null, true);
            echo "\"
              ";
        } else {
            // line 279
            echo "                value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["default_frequency"] ?? null), "website", []), "emails", []), "html", null, true);
            echo "\"
              ";
        }
        // line 281
        echo "              />
              ";
        // line 282
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("emails");
        echo "
              <select id=\"other_frequency_interval\">
                ";
        // line 284
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["intervals"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["interval"]) {
            // line 285
            echo "                <option
                  value=\"";
            // line 286
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["interval"], "html", null, true);
            echo "\"
                ";
            // line 288
            if (( !$this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "frequency", []), "interval", []) && (            // line 289
$context["interval"] == $this->getAttribute($this->getAttribute(($context["default_frequency"] ?? null), "website", []), "interval", [])))) {
                // line 291
                echo "                selected=\"selected\"
                ";
            }
            // line 293
            echo "                ";
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "frequency", []), "interval", []) == $context["interval"])) {
                // line 294
                echo "                selected=\"selected\"
                ";
            }
            // line 296
            echo "                >
                ";
            // line 297
            echo $this->env->getExtension('MailPoet\Twig\Functions')->getSendingFrequency($context["interval"]);
            echo "
                ";
            // line 298
            if (($context["interval"] == $this->getAttribute($this->getAttribute(($context["default_frequency"] ?? null), "website", []), "interval", []))) {
                // line 299
                echo "                (";
                echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("recommended");
                echo ")
                ";
            }
            // line 301
            echo "                </option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['interval'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 303
        echo "              </select>
              <span id=\"mailpoet_other_daily_emails\"></span>
            </p>
            <br />
            <p>
              ";
        // line 308
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("<strong>Warning!</strong> You may break the terms of your web host or provider by sending more than the recommended emails per day. Contact your host if you want to send more.");
        echo "
            </p>
          </div>
        </td>
      </tr>
      <tr class=\"mailpoet_smtp_field\" data-field=\"host\"
        ";
        // line 315
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "manual"))) {
            // line 317
            echo "        style=\"display:none;\"
        ";
        }
        // line 319
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_host]\">
            ";
        // line 322
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("SMTP Hostname");
        echo "
          </label>
          <p class=\"description\">
            ";
        // line 325
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("e.g.: smtp.mydomain.com");
        echo "
          </p>
        </th>
        <td>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"settings[mta_host]\"
            name=\"mta[host]\"
            value=\"";
        // line 334
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "host", []), "html", null, true);
        echo "\" />
        </td>
      </tr>
      <!-- smtp: port -->
      <tr class=\"mailpoet_smtp_field\" data-field=\"port\"
        ";
        // line 340
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "manual"))) {
            // line 342
            echo "        style=\"display:none;\"
        ";
        }
        // line 344
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_port]\">
            ";
        // line 347
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("SMTP Port");
        echo "
          </label>
        </th>
        <td>
          <input
            type=\"number\"
            max=\"65535\"
            min=\"1\"
            maxlength=\"5\"
            style=\"width:5em;\"
            id=\"settings[mta_port]\"
            name=\"mta[port]\"
            value=\"";
        // line 359
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "port", []), "html", null, true);
        echo "\"
          />
        </td>
      </tr>

      <!-- smtp: amazon region -->
      <tr class=\"mailpoet_aws_field\" data-field=\"region\"
        ";
        // line 367
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "AmazonSES"))) {
            // line 369
            echo "        style=\"display:none;\"
        ";
        }
        // line 371
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_region]\">
            ";
        // line 374
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Region");
        echo "
          </label>
        </th>
        <td>
          <select
            id=\"settings[mta_region]\"
            name=\"mta[region]\"
            value=\"";
        // line 381
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "smtp")) {
            // line 382
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "region", []), "html", null, true);
        }
        // line 383
        echo "\"
          >
            ";
        // line 385
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["hosts"] ?? null), "smtp", []), "AmazonSES", []), "regions", []));
        foreach ($context['_seq'] as $context["region"] => $context["server"]) {
            // line 386
            echo "            <option
              value=\"";
            // line 387
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["server"], "html", null, true);
            echo "\"
            ";
            // line 388
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "region", []) == $context["server"])) {
                // line 389
                echo "            selected=\"selected\"
            ";
            }
            // line 391
            echo "            >
            ";
            // line 392
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["region"], "html", null, true);
            echo "
            </option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['region'], $context['server'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 395
        echo "          </select>
        </td>
      </tr>

      <!-- smtp: amazon access_key -->
      <tr class=\"mailpoet_aws_field\" data-field=\"access_key\"
        ";
        // line 402
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "AmazonSES"))) {
            // line 404
            echo "        style=\"display:none;\"
        ";
        }
        // line 406
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_access_key]\">
            ";
        // line 409
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Access Key");
        echo "
          </label>
        </th>
        <td>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"settings[mta_access_key]\"

            name=\"mta[access_key]\"
            value=\"";
        // line 419
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "smtp")) {
            // line 420
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "access_key", []), "html", null, true);
        }
        // line 421
        echo "\"
          />
        </td>
      </tr>

      <!-- smtp: amazon secret_key -->
      <tr class=\"mailpoet_aws_field\" data-field=\"secret_key\"
        ";
        // line 429
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "AmazonSES"))) {
            // line 431
            echo "        style=\"display:none;\"
        ";
        }
        // line 433
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_secret_key]\">
            ";
        // line 436
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Secret Key");
        echo "
          </label>
        </th>
        <td>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"settings[mta_secret_key]\"

            name=\"mta[secret_key]\"
            value=\"";
        // line 446
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "smtp")) {
            // line 447
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "secret_key", []), "html", null, true);
        }
        // line 448
        echo "\"
          />
        </td>
      </tr>

      <!-- smtp: api key -->
      <tr class=\"mailpoet_sendgrid_field\" data-field=\"api_key\"
        ";
        // line 456
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "SendGrid"))) {
            // line 458
            echo "        style=\"display:none;\"
        ";
        }
        // line 460
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_api_key]\">
            ";
        // line 463
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("API Key");
        echo "
          </label>
        </th>
        <td>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"settings[mta_api_key]\"
            name=\"mta[api_key]\"
            value=\"";
        // line 472
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "api_key", []), "html", null, true);
        echo "\"
          />
        </td>
      </tr>

      <!-- smtp: login -->
      <tr id=\"mta_login\" class=\"mailpoet_smtp_field\" data-field=\"login\"
        ";
        // line 480
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "manual"))) {
            // line 482
            echo "        style=\"display:none;\"
        ";
        }
        // line 484
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_login]\">
            ";
        // line 487
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Login");
        echo "
          </label>
        </th>
        <td>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"settings[mta_login]\"
            name=\"mta[login]\"
            value=\"";
        // line 496
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "login", []), "html", null, true);
        echo "\"
          />
        </td>
      </tr>
      <!-- smtp: password -->
      <tr id=\"mta_password\" class=\"mailpoet_smtp_field\" data-field=\"password\"
        ";
        // line 503
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "manual"))) {
            // line 505
            echo "        style=\"display:none;\"
        ";
        }
        // line 507
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_password]\">
            ";
        // line 510
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Password");
        echo "
          </label>
        </th>
        <td>
          <input
            type=\"password\"
            class=\"regular-text\"
            id=\"settings[mta_password]\"
            name=\"mta[password]\"
            value=\"";
        // line 519
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "password", []), "html", null, true);
        echo "\"
          />
        </td>
      </tr>
      <!-- smtp: security protocol -->
      <tr class=\"mailpoet_smtp_field\" data-field=\"encryption\"
        ";
        // line 526
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "manual"))) {
            // line 528
            echo "        style=\"display:none;\"
        ";
        }
        // line 530
        echo "      >
        <th scope=\"row\">
          <label for=\"settings[mta_encryption]\">
            ";
        // line 533
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Secure Connection");
        echo "
          </label>
        </th>
        <td>
          <select id=\"settings[mta_encryption]\" name=\"mta[encryption]\">
            <option value=\"\">";
        // line 538
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("No");
        echo "</option>
            <option
              value=\"ssl\"
            ";
        // line 541
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "encryption", []) == "ssl")) {
            // line 542
            echo "            selected=\"selected\"
            ";
        }
        // line 544
        echo "            >SSL</option>
            <option
              value=\"tls\"
            ";
        // line 547
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "encryption", []) == "tls")) {
            // line 548
            echo "            selected=\"selected\"
            ";
        }
        // line 550
        echo "            >TLS</option>
          </select>
        </td>
      </tr>
      <!-- smtp: authentication -->
      <tr class=\"mailpoet_smtp_field\" data-field=\"authentication\"
        ";
        // line 557
        if ((($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "smtp") || ($this->getAttribute(($context["settings"] ?? null), "smtp_provider", []) != "manual"))) {
            // line 559
            echo "        style=\"display:none;\"
        ";
        }
        // line 561
        echo "      >
        <th scope=\"row\">
          <label>
            ";
        // line 564
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Authentication");
        echo "
          </label>
          <p class=\"description\">
            ";
        // line 567
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Leave this option set to Yes. Only a tiny portion of SMTP services prefer Authentication to be turned off.");
        echo "
          </p>
        </th>
        <td>
          <label>
            <input
              type=\"radio\"
              value=\"1\"
              name=\"mta[authentication]\"
            ";
        // line 577
        if (( !$this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "authentication", []) || ($this->getAttribute($this->getAttribute(        // line 578
($context["settings"] ?? null), "mta", []), "authentication", []) == "1"))) {
            // line 579
            echo "            checked=\"checked\"
            ";
        }
        // line 581
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes");
        echo "
          </label>
          &nbsp;
          <label>
            <input
              type=\"radio\"
              value=\"-1\"
              name=\"mta[authentication]\"
            ";
        // line 589
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "authentication", []) == "-1")) {
            // line 590
            echo "            checked=\"checked\"
            ";
        }
        // line 592
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("No");
        echo "
          </label>
        </td>
      </tr>
      </tbody>
    </table>

    <table class=\"form-table\">
      <tbody>
        <!-- SPF -->
        <tr id=\"mailpoet_mta_spf\">
          <th scope=\"row\">
            <label>
              ";
        // line 605
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("SPF Signature (Highly recommended!)");
        echo "
            </label>
            <p class=\"description\">
              ";
        // line 608
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("This improves your delivery rate by verifying that you're allowed to send emails from your domain.");
        echo "
            </p>
          </th>
          <td>
            <p>
              ";
        // line 613
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("SPF is set up in your DNS. Read your host's support documentation for more information.");
        echo "
            </p>
          </td>
        </tr>
        <!-- test method -->
        <tr>
          <th scope=\"row\">
            <label for=\"mailpoet_mta_test_email\">
              ";
        // line 621
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Test the sending method");
        echo "
            </label>
          </th>
          <td>
            <p>
              <input
                type=\"text\"
                id=\"mailpoet_mta_test_email\"
                class=\"regular-text\"
                value=\"";
        // line 630
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["current_user"] ?? null), "user_email", []), "html", null, true);
        echo "\"
              />
              <a
                id=\"mailpoet_mta_test\"
                class=\"button-secondary\"
              >";
        // line 635
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send a test email");
        echo "</a>

              <span id=\"tooltip-test\"></span>
            </p>
          </td>
        </tr>
        <!-- activate or cancel -->
        <tr>
          <th scope=\"row\">
            <p>
              <a
                href=\"javascript:;\"
                class=\"mailpoet_mta_setup_save button button-primary\"
              >";
        // line 648
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activate");
        echo "</a>
              &nbsp;
              <a
                href=\"javascript:;\"
                class=\"mailpoet_mta_setup_cancel\"
              >";
        // line 653
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("or Cancel");
        echo "</a>
            </p>
          </th>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script type=\"text/javascript\">
  jQuery(function(\$) {
    var tooltip = '";
        // line 665
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, MailPoet\Util\Helpers::replaceLinkTags($this->env->getExtension('MailPoet\Twig\I18n')->translate("Didn't receive the test email? Read our [link]quick guide[/link] to sending issues."), "https://kb.mailpoet.com/article/146-my-newsletters-are-not-being-received", ["target" => "_blank", "data-beacon-article" => "580846f09033604df5166ed1"]), "js"), "html", null, true);
        // line 667
        echo "'

    MailPoet.helpTooltip.show(document.getElementById(\"tooltip-test\"), {
      tooltipId: \"tooltip-settings-test\",
      tooltip: tooltip,
    });

    var sending_frequency_template =
      Handlebars.compile(\$('#mailpoet_sending_frequency_template').html());

    // om dom loaded
    \$(function() {
      // constrain number type inputs
      \$('input[type=\"number\"]').on('keyup', function() {
        var currentValue = \$(this).val();
        if(!currentValue) return;

        var minValue = \$(this).attr('min');
        var maxValue = \$(this).attr('max');
        \$(this).val(Math.min(Math.max(minValue, currentValue), maxValue));
      });

      // testing sending method
      \$('#mailpoet_mta_test').on('click', function() {
        // get test email and include it in data
        var recipient = \$('#mailpoet_mta_test_email').val();

        var settings = jQuery('#mailpoet_settings_form').mailpoetSerializeObject();
        var mailer = settings.mta;

        mailer.method = getMethodFromGroup(\$('#mailpoet_smtp_method').val());

        // check that we have a from address
        if(settings.sender.address.length === 0) {
          // validation
          return MailPoet.Notice.error(
            '";
        // line 703
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("The email could not be sent. Make sure the option \"Email notifications\" has a FROM email address in the Basics tab."), "js"), "html", null, true);
        echo "',
            { scroll: true, static: true }
          );
        }

        MailPoet.Modal.loading(true);
        MailPoet.Ajax.post({
          api_version: window.mailpoet_api_version,
          endpoint: 'mailer',
          action: 'send',
          data: {
            mailer: mailer,
            newsletter: {
              subject: \"";
        // line 716
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("This is a Sending Method Test");
        echo "\",
              body: {
                html: \"<p>";
        // line 718
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yup, it works! You can start blasting away emails to the moon.");
        echo "</p>\",
                text: \"";
        // line 719
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yup, it works! You can start blasting away emails to the moon.");
        echo "\"
              }
            },
            subscriber: recipient
          }
        }).always(function() {
          MailPoet.Modal.loading(false);
        }).done(function(response) {
          MailPoet.Notice.success(
            \"";
        // line 728
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("The email has been sent! Check your inbox."), "js"), "html", null, true);
        echo "\",
            { scroll: true }
          );
          trackTestEmailSent(mailer, true);

          const showSuccessDeliveryPoll = MailPoet.Poll.successDelivery.canShow('preview', true) && \$('#mailpoet_smtp_method').val() === 'server';
          if (showSuccessDeliveryPoll) {
            MailPoet.Poll.successDelivery.showModal('preview', 'IHedf1');
            MailPoet.Poll.successDelivery.setPollShown('preview');
          }
        }).fail(function(response) {
          if (response.errors.length > 0) {
            MailPoet.Notice.error(
              response.errors.map(function(error) { return _.escape(error.message); }),
              { scroll: true }
            );
          }
          trackTestEmailSent(mailer, false);
        });
      });

      // sending frequency update based on selected provider
      \$('#mailpoet_web_host').on('change keyup', renderHostSendingFrequency);

      // update manual sending frequency when values are changed
      \$('#other_frequency_emails').on('change keyup', function() {
        updateSendingFrequency('other');
      });
      \$('#other_frequency_interval').on('change keyup', function() {
        updateSendingFrequency('other');
      });

      // save configuration of a sending method
      \$('.mailpoet_sending_service_activate').on('click', function(e, navigateToTab) {
        \$('#mta_group').val('mailpoet');
        saveSendingMethodConfiguration('mailpoet', navigateToTab);
        if (MailPoetLib && MailPoetLib.checkSPFRecord) {
          MailPoetLib.checkSPFRecord.default();
        }
      });
      \$('.mailpoet_mta_setup_save').on('click', function() {
        \$('#mailpoet_smtp_method').trigger(\"change\");
        \$('#other_frequency_emails').trigger(\"change\");
        // get selected method
        var group = \$('.mailpoet_sending_method:visible').data('group');
        saveSendingMethodConfiguration(group);
      });
      \$('#mailpoet_smtp_method').on('change keyup', renderHostsSelect);
      \$('#mailpoet_sending_frequency').on('change keyup', sendingFrequencyMethodUpdated);

      ";
        // line 778
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "mailpoet")) {
            // line 779
            echo "        \$('#mailpoet_smtp_method').trigger(\"change\");
        \$('#other_frequency_emails').trigger(\"change\");
      ";
        }
        // line 782
        echo "
      function saveSendingMethodConfiguration(group, navigateToTab) {
        // set sending method
        if(group === undefined) {
          MailPoet.Notice.error(
            \"";
        // line 787
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("You have selected an invalid sending method."), "js"), "html", null, true);
        echo "\"
          );
        } else {
          // set new sending method active
          setSendingMethodGroup(group);

          // enforce signup confirmation depending on selected group
          setSignupConfirmation(group);

          // back to selection of sending methods
          if (navigateToTab === undefined || navigateToTab === true) {
            MailPoet.Router.navigate('mta', { trigger: true });
          }

          // save settings
          \$('.mailpoet_settings_submit > input').trigger('click');

          if (group === 'mailpoet') {
            updateMSSActivationUI()
          }
        }
      }

      function setSignupConfirmation(group) {
        if (group === 'mailpoet') {
          // force signup confirmation (select \"Yes\")
          \$('.mailpoet_signup_confirmation[value=\"1\"]').attr('checked', true);
          \$('.mailpoet_signup_confirmation[value=\"\"]').attr('checked', false);

          // hide radio inputs
          \$('#mailpoet_signup_confirmation_input').hide();

          // show mailpoet specific notice
          \$('#mailpoet_signup_confirmation_notice').show();

          // show signup confirmation options
          \$('#mailpoet_signup_options').show();
        } else {
          // show radio inputs
          \$('#mailpoet_signup_confirmation_input').show();

          // hide mailpoet specific notice
          \$('#mailpoet_signup_confirmation_notice').hide();
        }
      }

      function setSendingMethodGroup(group) {
        // deactivate other sending methods
        \$('.mailpoet_sending_methods .mailpoet_active')
          .removeClass('mailpoet_active');

        // set active sending method
        \$('.mailpoet_sending_methods li[data-group=\"'+group+'\"]')
          .addClass('mailpoet_active');

        var method = getMethodFromGroup(\$('#mta_group').val());

        \$('#mta_method').val(method);

        // set MailPoet method description
        \$('#mailpoet_sending_method_active_text')
          .toggleClass('mailpoet_hidden', group !== 'mailpoet');
        \$('#mailpoet_sending_method_inactive_text')
          .toggleClass('mailpoet_hidden', group === 'mailpoet');

        // Hide server error notices
        \$('.mailpoet_notice_server').hide();

        updateMSSActivationUI();
      }

      function getMethodFromGroup(group) {
        var group = group || 'website';

        switch(group) {
          case 'mailpoet':
            return 'MailPoet';
          break;
          case 'server':
          case 'website':
            return 'PHPMail';
          break;
          case 'manual':
          case 'smtp':
            var method = \$('#mailpoet_smtp_provider').val();
            if(method === 'manual') {
              return 'SMTP';
            }
            return method;
          break;
          default:
            return group;
        }
      }

      // cancel configuration of a sending method
      \$('.mailpoet_mta_setup_cancel').on('click', function() {
        // back to selection of sending methods
        MailPoet.Router.navigate('mta', { trigger: true });
      });

      // render sending frequency form
      \$('#mailpoet_smtp_provider').trigger('change');
      \$('#mailpoet_web_host').trigger('change');

      function trackTestEmailSent(mailer, success) {
        MailPoet.trackEvent(
          'User has sent a test email from Settings',
          {
            'Sending was successful': !!success,
            'Sending method type': mailer.method,
            'MailPoet Free version': window.mailpoet_version
          }
        );
      }

      \$('.mailpoet_sending_methods_help a').on('click', function() {
        MailPoet.trackEvent(
          'User has clicked to view the sending comparison table',
          {'MailPoet Free version': window.mailpoet_version}
        );
      });
    });

    function setProviderForm() {
      // check provider
      var provider = \$(this).find('option:selected').first();
      var fields = provider.data('fields');

      if(fields === undefined) {
        fields = [
          'host',
          'port',
          'login',
          'password',
          'authentication',
          'encryption'
        ];
      } else {
        fields = fields.split(',');
      }

      \$('.mailpoet_smtp_field').hide();

      fields.map(function(field) {
        \$('.mailpoet_smtp_field[data-field=\"'+field+'\"]').show();
      });

      // update sending frequency
      renderSMTPSendingFrequency(provider);
    }

    function renderSMTPSendingFrequency() {
      // set sending frequency
      var emails = \$('#smtp_frequency_emails').val();
      var interval = \$('#smtp_frequency_interval').val();
      setSendingFrequency({
        output: '#mailpoet_smtp_daily_emails',
        only_daily: true,
        emails: emails,
        interval: interval
      });
      \$('#mta_frequency_emails').val(emails);
      \$('#mta_frequency_interval').val(interval);
    }

    function sendingFrequencyMethodUpdated() {
      var method = \$(this).find('option:selected').first();
      var sendingMethod = \$('#mailpoet_smtp_method').find('option:selected').first().val();
      if(method.val() === \"manual\") {
        \$('#mailpoet_sending_frequency_manual').show();
        \$('#mailpoet_recommended_daily_emails').hide();
        \$('#other_frequency_emails').trigger(\"change\");
      } else {
        \$('#mailpoet_sending_frequency_manual').hide();
        if(sendingMethod !== \"server\") {
          \$('#mailpoet_recommended_daily_emails').show();
        }
        \$('#mailpoet_smtp_method').trigger(\"change\");
      }
    }

    function renderHostsSelect() {
      var method = \$(this).find('option:selected').first();
      var val = method.val();

      if(val === \"server\") {
        \$('#mailpoet_sending_method_host').show();
        \$('#mta_group').val('website');
      } else {
        \$('#mailpoet_sending_method_host').hide();
      }
      if(val === \"manual\") {
        \$('.mailpoet_smtp_field').show();
        \$('#mta_group').val('smtp');
        \$('#mailpoet_smtp_provider').val('manual');
      } else {
        \$('.mailpoet_smtp_field').hide();
      }
      if(val === \"AmazonSES\") {
        \$('.mailpoet_aws_field').show();
        \$('#mta_group').val('smtp');
        \$('#mailpoet_smtp_provider').val('AmazonSES');
      } else {
        \$('.mailpoet_aws_field').hide();
      }
      if(val === \"SendGrid\") {
        \$('.mailpoet_sendgrid_field').show();
        \$('#mta_group').val('smtp');
        \$('#mailpoet_smtp_provider').val('SendGrid');
      } else {
        \$('.mailpoet_sendgrid_field').hide();
      }
      var emails = method.data('emails');
      var interval = method.data('interval');
      if(val === \"server\") {
        emails = \$('#mailpoet_web_host').find('option:selected').first().data('emails');
        interval = \$('#mailpoet_web_host').find('option:selected').first().data('interval');
      }
      const frequencyMethod = \$('#mailpoet_sending_frequency').find('option:selected').first().val();
      if(frequencyMethod === \"manual\") {
        \$('#mailpoet_recommended_daily_emails').hide();
        emails = \$('#other_frequency_emails').val();
        interval = \$('#other_frequency_interval').val();
      } else {
        \$('#mailpoet_recommended_daily_emails').show();
      }
      setSendingFrequency({
        output: '#mailpoet_recommended_daily_emails',
        only_daily: false,
        emails: emails,
        interval: interval
      });
      \$('#mta_frequency_emails').val(emails);
      \$('#mta_frequency_interval').val(interval);
    }

    function renderHostSendingFrequency() {
      var host = \$(this).find('option:selected').first();
      var frequencyType = \$(\"#mailpoet_sending_frequency\").find('option:selected').first().val();

      var emails =
        host.data('emails') || ";
        // line 1029
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["default_frequency"] ?? null), "website", []), "emails", []), "html", null, true);
        echo ";
      var interval =
        host.data('interval') || ";
        // line 1031
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["default_frequency"] ?? null), "website", []), "interval", []), "html", null, true);
        echo ";
      var fields =
        host.data('fields') || '';

      if (frequencyType === \"manual\") {
        return;
      } else {
        setSendingFrequency({
          output: '#mailpoet_recommended_daily_emails',
          only_daily: false,
          emails: emails,
          interval: interval
        });
      }

      \$('#mta_frequency_emails').val(emails);
      \$('#mta_frequency_interval').val(interval);
    }

    function updateSendingFrequency(method) {
      // get emails
      var options = {
        only_daily: true,
        emails: \$('#'+method+'_frequency_emails').val(),
        interval: \$('#'+method+'_frequency_interval').val()
      };

      var MINUTES_PER_DAY = 1440;
      var SECONDS_PER_DAY = 86400;

      options.daily_emails = ~~(
        (MINUTES_PER_DAY / options.interval) * options.emails
      );

      options.emails_per_second = (~~(
        ((options.daily_emails) / 86400) * 10)
      ) / 10;


      // format daily emails number according to locale
      options.daily_emails = options.daily_emails.toLocaleString();

      \$('#mailpoet_'+method+'_daily_emails').html(
        sending_frequency_template(options)
      );

      // update actual sending frequency values
      \$('#mta_frequency_emails').val(options.emails);
      \$('#mta_frequency_interval').val(options.interval);
    }

    function setSendingFrequency(options) {
      options.daily_emails = ~~((1440 / options.interval) * options.emails);

      // format daily emails number according to locale
      options.daily_emails = options.daily_emails.toLocaleString();
      \$(options.output).html(
        sending_frequency_template(options)
      );
    }

    Handlebars.registerHelper('format_time', function(value, block) {
      var label = null;
      var labels = {
        minute: \"";
        // line 1095
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("every minute");
        echo "\",
        minutes: \"";
        // line 1096
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("every %1\$d minutes");
        echo "\",
        hour: \"";
        // line 1097
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("every hour");
        echo "\",
        hours: \"";
        // line 1098
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("every %1\$d hours");
        echo "\"
      };

      // cast time as int
      value = ~~(value);

      // format time depending on the value
      if(value >= 60) {
        // we're dealing with hours
        if(value === 60) {
          label = labels.hour;
        } else {
          label = labels.hours;
        }
        value /= 60;
      } else {
        // we're dealing with minutes
        if(value === 1) {
          label = labels.minute;
        } else {
          label = labels.minutes;
        }
      }

      if(label !== null) {
        return label.replace('%1\$d', value);
      } else {
        return value;
      }
    });
  });

  // enable/disable MSS method activate button and notice
  function updateMSSActivationUI() {
    var \$ = jQuery;
    var group = \$('.mailpoet_sending_methods .mailpoet_active').data('group');
    var key_valid = !!\$('.mailpoet_mss_key_valid');

    if (group !== 'mailpoet') {
      \$('.mailpoet_actions .mailpoet_invalid_key').toggleClass('mailpoet_hidden', key_valid);
      \$('.mailpoet_actions .mailpoet_valid_key').toggleClass('mailpoet_hidden', !key_valid);
      \$('.mailpoet_other_sending_method_action').removeClass('button-primary').addClass('button-secondary').text('";
        // line 1139
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Configure");
        echo "');
    } else {
      \$('.mailpoet_actions .mailpoet_valid_key').addClass('mailpoet_hidden');
      \$('.mailpoet_activated').toggleClass('mailpoet_hidden', !key_valid);
      \$('.mailpoet_other_sending_method_action').removeClass('button-secondary').addClass('button-primary').text('";
        // line 1143
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activate");
        echo "');
      \$('.mailpoet_invalid_key').toggleClass('mailpoet_hidden', key_valid);
      \$('.mailpoet_sending_methods li[data-group=\"'+group+'\"], .mailpoet_sending_methods li[data-group=\"'+group+'\"] > .mailpoet_status').toggleClass('mailpoet_invalid_key', !key_valid)
    }

    if (key_valid) {
        \$('.mailpoet_mss_activate_notice').toggle(group !== 'mailpoet');
      }
  };
</script>

";
        // line 1154
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "mailpoet_sending_frequency_template", "settings/templates/sending_frequency.hbs");
        // line 1157
        echo "
";
    }

    public function getTemplateName()
    {
        return "settings/mta.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1669 => 1157,  1667 => 1154,  1653 => 1143,  1646 => 1139,  1602 => 1098,  1598 => 1097,  1594 => 1096,  1590 => 1095,  1523 => 1031,  1518 => 1029,  1273 => 787,  1266 => 782,  1261 => 779,  1259 => 778,  1206 => 728,  1194 => 719,  1190 => 718,  1185 => 716,  1169 => 703,  1131 => 667,  1129 => 665,  1114 => 653,  1106 => 648,  1090 => 635,  1082 => 630,  1070 => 621,  1059 => 613,  1051 => 608,  1045 => 605,  1028 => 592,  1024 => 590,  1022 => 589,  1010 => 581,  1006 => 579,  1004 => 578,  1003 => 577,  991 => 567,  985 => 564,  980 => 561,  976 => 559,  974 => 557,  966 => 550,  962 => 548,  960 => 547,  955 => 544,  951 => 542,  949 => 541,  943 => 538,  935 => 533,  930 => 530,  926 => 528,  924 => 526,  915 => 519,  903 => 510,  898 => 507,  894 => 505,  892 => 503,  883 => 496,  871 => 487,  866 => 484,  862 => 482,  860 => 480,  850 => 472,  838 => 463,  833 => 460,  829 => 458,  827 => 456,  818 => 448,  815 => 447,  813 => 446,  800 => 436,  795 => 433,  791 => 431,  789 => 429,  780 => 421,  777 => 420,  775 => 419,  762 => 409,  757 => 406,  753 => 404,  751 => 402,  743 => 395,  734 => 392,  731 => 391,  727 => 389,  725 => 388,  721 => 387,  718 => 386,  714 => 385,  710 => 383,  707 => 382,  705 => 381,  695 => 374,  690 => 371,  686 => 369,  684 => 367,  674 => 359,  659 => 347,  654 => 344,  650 => 342,  648 => 340,  640 => 334,  628 => 325,  622 => 322,  617 => 319,  613 => 317,  611 => 315,  602 => 308,  595 => 303,  588 => 301,  582 => 299,  580 => 298,  576 => 297,  573 => 296,  569 => 294,  566 => 293,  562 => 291,  560 => 289,  559 => 288,  555 => 286,  552 => 285,  548 => 284,  543 => 282,  540 => 281,  534 => 279,  528 => 277,  526 => 276,  517 => 269,  513 => 267,  511 => 265,  502 => 258,  499 => 257,  495 => 255,  493 => 253,  487 => 249,  473 => 238,  463 => 230,  454 => 228,  450 => 226,  448 => 225,  444 => 224,  440 => 223,  436 => 222,  433 => 221,  429 => 220,  424 => 218,  405 => 202,  400 => 199,  396 => 197,  394 => 195,  387 => 189,  378 => 187,  374 => 185,  372 => 184,  368 => 183,  364 => 182,  360 => 181,  356 => 180,  353 => 179,  349 => 178,  345 => 177,  339 => 174,  336 => 173,  332 => 171,  330 => 169,  324 => 165,  311 => 155,  296 => 142,  290 => 140,  284 => 138,  282 => 137,  277 => 135,  269 => 129,  267 => 125,  263 => 124,  259 => 123,  255 => 122,  250 => 120,  245 => 118,  241 => 116,  237 => 115,  228 => 109,  222 => 108,  218 => 106,  216 => 102,  212 => 101,  206 => 100,  200 => 99,  194 => 96,  188 => 95,  182 => 94,  176 => 90,  174 => 88,  172 => 86,  170 => 85,  163 => 81,  159 => 80,  155 => 79,  151 => 78,  147 => 77,  140 => 73,  134 => 72,  128 => 69,  122 => 68,  115 => 64,  102 => 60,  92 => 53,  81 => 45,  72 => 39,  61 => 31,  51 => 24,  42 => 18,  34 => 12,  32 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "settings/mta.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/settings/mta.html");
    }
}
