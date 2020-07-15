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

/* settings/basics.html */
class __TwigTemplate_111005ba986a62aab9f38ba6b97ead715d7f2c41db089a768b4d64dc52983e2b extends \MailPoetVendor\Twig\Template
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
        echo "<table class=\"form-table\">
  <tbody>
    <tr>
      <th scope=\"row\">
        <label for=\"settings[from_name]\">
          ";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Default sender");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 9
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("These email addresses will be selected by default for each new email.");
        echo "
        </p>
      </th>
      <td>
        <div id=\"settings_sender_container\"></div>
      </td>
    </tr>
    <!-- email addresses receiving notifications -->
    <tr style=\"display:none\">
      <th scope=\"row\">
        <label for=\"settings[notification_email]\">
          ";
        // line 20
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email notifications");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 23
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("These email addresses will receive notifications (separate each address with a comma).");
        echo "
        </p>
      </th>
      <td>
        <p>
          <input type=\"text\"
            id=\"settings[notification_email]\"
            name=\"notification[address]\"
            value=\"";
        // line 31
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "notification", []), "address", []), "html", null, true);
        echo "\"
            placeholder=\"notification@mydomain.com\"
            class=\"regular-text\" />
        </p>
        <p>
          <label for=\"settings[notification_on_subscribe]\">
            <input type=\"checkbox\" id=\"settings[notification_on_subscribe]\"
            name=\"notification[on_subscribe]\"
            value=\"1\"
            ";
        // line 40
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "notification", []), "on_subscribe", [])) {
            echo "checked=\"checked\"";
        }
        echo " />
            ";
        // line 41
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("When someone subscribes");
        echo "
          </label>
        </p>
        <p>
          <label for=\"settings[notification_on_unsubscribe]\">
            <input type=\"checkbox\"
            id=\"settings[notification_on_unsubscribe]\"
            name=\"notification[on_unsubscribe]\"
            value=\"1\"
            ";
        // line 50
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "notification", []), "on_unsubscribe", [])) {
            echo "checked=\"checked\"";
        }
        echo " />
            ";
        // line 51
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("When someone unsubscribes");
        echo "
          </label>
        </p>
      </td>
    </tr>
    <!-- ability to subscribe in comments -->
    <tr>
      <th scope=\"row\">
        <label for=\"settings[subscribe_on_comment]\">
          ";
        // line 60
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscribe in comments");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 63
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Visitors that comment on a post can subscribe to your list via a checkbox.");
        echo "
        </p>
      </th>
      <td>
        <p>
          <input
            data-toggle=\"mailpoet_subscribe_on_comment\"
            type=\"checkbox\"
            value=\"1\"
            id=\"settings[subscribe_on_comment]\"
            name=\"subscribe[on_comment][enabled]\"
            ";
        // line 74
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_comment", []), "enabled", [])) {
            echo "checked=\"checked\"";
        }
        // line 75
        echo "          />
        </p>
        <div id=\"mailpoet_subscribe_on_comment\">
          <p>
            <input
              type=\"text\"
              id=\"settings[subscribe_on_comment_label]\"
              name=\"subscribe[on_comment][label]\"
              class=\"regular-text\"
              ";
        // line 84
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_comment", []), "label", [])) {
            // line 85
            echo "                  value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_comment", []), "label", []), "html", null, true);
            echo "\"
              ";
        } else {
            // line 87
            echo "                value=\"";
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes, add me to your mailing list");
            echo "\"
              ";
        }
        // line 89
        echo "            />
          </p>
          <p>
            <label>";
        // line 92
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Users will be subscribed to these lists:");
        echo "</label>
          </p>
          <p>
            <select
              id=\"mailpoet_subscribe_on_comment_segments\"
              name=\"subscribe[on_comment][segments][]\"
              data-placeholder=\"";
        // line 98
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Choose a list");
        echo "\"
              multiple
            >
              ";
        // line 101
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["segments"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
            // line 102
            echo "                <option
                  value=\"";
            // line 103
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "id", []), "html", null, true);
            echo "\"
                  ";
            // line 104
            if (\MailPoetVendor\twig_in_filter($this->getAttribute($context["segment"], "id", []), $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_comment", []), "segments", []))) {
                // line 105
                echo "                    selected=\"selected\"
                  ";
            }
            // line 107
            echo "                >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "name", []), "html", null, true);
            echo " (";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "subscribers", []), "html", null, true);
            echo ")</option>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 109
        echo "            </select>
          </p>
        </div>
      </td>
    </tr>
    <!-- ability to subscribe when registering -->
    <tr>
      <th scope=\"row\">
        <label for=\"settings[subscribe_on_register]\">
          ";
        // line 118
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscribe in registration form");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 121
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Allow users who register as a WordPress user on your website to subscribe to a MailPoet list (in addition to the \"WordPress Users\" list).");
        echo "
        </p>
      </th>
      <td>
        ";
        // line 125
        if (($this->getAttribute(($context["flags"] ?? null), "registration_enabled", []) == true)) {
            // line 126
            echo "          <p>
            <input
              data-toggle=\"mailpoet_subscribe_in_form\"
              type=\"checkbox\"
              value=\"1\"
              id=\"settings[subscribe_on_register]\"
              name=\"subscribe[on_register][enabled]\"
              ";
            // line 133
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_register", []), "enabled", [])) {
                // line 134
                echo "                checked=\"checked\"
              ";
            }
            // line 136
            echo "            />
          </p>

          <div id=\"mailpoet_subscribe_in_form\">
            <p>
              <input
                type=\"text\"
                id=\"settings[subscribe_on_register_label]\"
                name=\"subscribe[on_register][label]\"
                class=\"regular-text\"
                ";
            // line 146
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_register", []), "label", [])) {
                // line 147
                echo "                  value=\"";
                echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_register", []), "label", []), "html", null, true);
                echo "\"
                ";
            } else {
                // line 149
                echo "                  value=\"";
                echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes, add me to your mailing list");
                echo "\"
                ";
            }
            // line 151
            echo "              />
            </p>
            <p>
              <label>";
            // line 154
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Users will be subscribed to these lists:");
            echo "</label>
            </p>
            <p>
              <select
                id=\"mailpoet_subscribe_on_register_segments\"
                name=\"subscribe[on_register][segments][]\"
                data-placeholder=\"";
            // line 160
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Choose a list");
            echo "\"
                multiple
              >
                ";
            // line 163
            $context['_parent'] = $context;
            $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["segments"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
                // line 164
                echo "                  <option
                    value=\"";
                // line 165
                echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "id", []), "html", null, true);
                echo "\"
                    ";
                // line 166
                if (\MailPoetVendor\twig_in_filter($this->getAttribute($context["segment"], "id", []), $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscribe", []), "on_register", []), "segments", []))) {
                    // line 167
                    echo "                      selected=\"selected\"
                    ";
                }
                // line 169
                echo "                  >";
                echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "name", []), "html", null, true);
                echo " (";
                echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "subscribers", []), "html", null, true);
                echo ")</option>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 171
            echo "              </select>
            </p>
          </div>
        ";
        } else {
            // line 175
            echo "          <p>
            <em>";
            // line 176
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Registration is disabled on this site.");
            echo "</em>
          </p>
        ";
        }
        // line 179
        echo "      </td>
    </tr>
    <!-- edit subscription-->
    <tr>
      <th scope=\"row\">
        <label for=\"subscription_manage_page\">
          ";
        // line 185
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Manage Subscription page");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 188
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("When your subscribers click the \"Manage your subscription\" link, they will be directed to this page.");
        echo "
          <br />
          ";
        // line 190
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("If you want to use a custom Subscription page, simply paste this shortcode on to a WordPress page: [mailpoet_manage_subscription]");
        echo "
        </p>
      </th>
      <td>
        <p>
          <select
            class=\"mailpoet_page_selection\"
            id=\"subscription_manage_page\"
            name=\"subscription[pages][manage]\"
          >
            ";
        // line 200
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["pages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 201
            echo "              <option
                value=\"";
            // line 202
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["page"], "id", []), "html", null, true);
            echo "\"
                data-preview-url=\"";
            // line 203
            echo $this->getAttribute($this->getAttribute($context["page"], "url", []), "manage", []);
            echo "\"
                ";
            // line 204
            if (($this->getAttribute($context["page"], "id", []) == $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscription", []), "pages", []), "manage", []))) {
                // line 205
                echo "                  selected=\"selected\"
                ";
            }
            // line 207
            echo "              >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["page"], "title", []), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 209
        echo "          </select>
          <a
            class=\"mailpoet_page_preview\"
            href=\"javascript:;\"
            title=\"";
        // line 213
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview page");
        echo "\"
            data-automation-id=\"preview_manage_subscription_page_link\"
          >";
        // line 215
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview");
        echo "</a>
        </p>
        <p>
          <label>";
        // line 218
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscribers can choose from these lists:");
        echo "</label>
        </p>
        <p>
          <select
            id=\"mailpoet_subscription_edit_segments\"
            name=\"subscription[segments][]\"
            data-placeholder=\"";
        // line 224
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Leave this field empty to display all lists");
        echo "\"
            multiple
          >
            ";
        // line 227
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["segments"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
            // line 228
            echo "              <option
                value=\"";
            // line 229
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "id", []), "html", null, true);
            echo "\"
                ";
            // line 230
            if (\MailPoetVendor\twig_in_filter($this->getAttribute($context["segment"], "id", []), $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscription", []), "segments", []))) {
                // line 231
                echo "                  selected=\"selected\"
                ";
            }
            // line 233
            echo "              >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "name", []), "html", null, true);
            echo " (";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "subscribers", []), "html", null, true);
            echo ")</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 235
        echo "          </select>
        </p>
      </td>
    </tr>
    <!-- unsubscribe-->
    <tr>
      <th scope=\"row\">
        <label for=\"subscription_unsubscribe_page\">
          ";
        // line 243
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Unsubscribe page");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 246
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("When your subscribers click the \"Unsubscribe\" link, they will be directed to this page.");
        echo "
          <br />
          ";
        // line 248
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("If you want to use a custom Unsubscribe page, simply paste this shortcode on to a WordPress page: [mailpoet_manage text=\"Manage your subscription\"]");
        echo "
        </p>
      </th>
      <td>
        <p>
          <select
            class=\"mailpoet_page_selection\"
            id=\"subscription_unsubscribe_page\"
            name=\"subscription[pages][unsubscribe]\"
          >
            ";
        // line 258
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["pages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 259
            echo "              <option
                value=\"";
            // line 260
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["page"], "id", []), "html", null, true);
            echo "\"
                data-preview-url=\"";
            // line 261
            echo $this->getAttribute($this->getAttribute($context["page"], "url", []), "unsubscribe", []);
            echo "\"
                ";
            // line 262
            if (($this->getAttribute($context["page"], "id", []) == $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscription", []), "pages", []), "unsubscribe", []))) {
                // line 263
                echo "                  selected=\"selected\"
                ";
            }
            // line 265
            echo "              >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["page"], "title", []), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 267
        echo "          </select>
          <a
            class=\"mailpoet_page_preview\"
            href=\"javascript:;\"
            title=\"";
        // line 271
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview page");
        echo "\"
            data-automation-id=\"unsubscribe_page_preview_link\"
          >";
        // line 273
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview");
        echo "</a>
        </p>
      </td>
    </tr>

    <!-- Stats notifications -->
    <tr>
      <th scope=\"row\">
        <label for=\"subscription_unsubscribe_page\">
          ";
        // line 282
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Stats notifications", "name of a setting to automatically send statistics (newsletter open rate, click rate, etc) by email");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 285
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Enter the email address that should receive your newsletter’s stats 24 hours after it has been sent, or every first Monday of the month for Welcome Emails and WooCommerce emails.", "Please reuse the current translations of “Welcome Emails”");
        // line 288
        echo "
      <td>
        <p>
          <label>
            <input
              type=\"checkbox\"
              name=\"stats_notifications[enabled]\"
              value=\"1\"
              ";
        // line 296
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "stats_notifications", []), "enabled", [])) {
            // line 297
            echo "                checked
              ";
        }
        // line 299
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Newsletters and Post Notifications");
        echo "
          </label>
          <br>
          <label>
            <input
              type=\"checkbox\"
              name=\"stats_notifications[automated]\"
              value=\"1\"
              ";
        // line 307
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "stats_notifications", []), "automated", [])) {
            // line 308
            echo "                checked
              ";
        }
        // line 310
        echo "            >";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Welcome Emails and WooCommerce emails", "Please reuse the current translations of “Welcome Emails”");
        echo "
          </label>
          <br>
          <input type=\"email\"
            id=\"stats_notifications[address]\"
            name=\"stats_notifications[address]\"
            value=\"";
        // line 316
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "stats_notifications", []), "address", []), "html", null, true);
        echo "\"
            placeholder=\"me@mydomain.com\" >
          <br>
          <div id=\"settings_stats_notifications_error\" class=\"mailpoet_error_item mailpoet_error\">
            ";
        // line 320
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please fill the email address.");
        echo "
          </div>

    <!-- New subscriber emails notifications -->
    <tr>
      <th scope=\"row\">
        <label for=\"subscription_unsubscribe_page\">
          ";
        // line 327
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("New subscriber notifications");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 330
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Enter the email address that should receive notifications when someone subscribes.");
        echo "
      <td>
        <p>
          <label>
            <input
              type=\"radio\"
              name=\"subscriber_email_notification[enabled]\"
              value=\"1\"
            ";
        // line 338
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscriber_email_notification", []), "enabled", [])) {
            // line 339
            echo "            checked
            ";
        }
        // line 341
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes");
        echo "
          </label>
          &nbsp;
          <label>
            <input
              type=\"radio\"
              name=\"subscriber_email_notification[enabled]\"
              value=\"\"
            ";
        // line 349
        if ( !$this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscriber_email_notification", []), "enabled", [])) {
            // line 350
            echo "            checked
            ";
        }
        // line 352
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("No");
        echo "
          </label>
          <br>
          <input type=\"email\"
                 id=\"subscriber_email_notification[address]\"
                 name=\"subscriber_email_notification[address]\"
                 value=\"";
        // line 358
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscriber_email_notification", []), "address", []), "html", null, true);
        echo "\"
                 placeholder=\"me@mydomain.com\" />
          <br>
        <div id=\"settings_subscriber_email_notification_error\" class=\"mailpoet_error_item mailpoet_error\">
          ";
        // line 362
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please fill the email address.");
        echo "
        </div>

    <!-- shortcode: archive page  -->
    <tr>
      <th scope=\"row\">
        <label>
          ";
        // line 369
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Archive page shortcode");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 372
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Paste this shortcode on a page to display a list of past newsletters.");
        echo "
        </p>
      </th>
      <td>
        <p>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"mailpoet_shortcode_archives\"
            value=\"[mailpoet_archive]\"
            onClick=\"this.focus();this.select();\"
            readonly=\"readonly\"
          />
        </p>
        <p>
          <select
            id=\"mailpoet_shortcode_archives_list\"
            data-shortcode=\"mailpoet_archive\"
            data-output=\"mailpoet_shortcode_archives\"
            data-placeholder=\"";
        // line 391
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Leave this field empty to display all lists");
        echo "\"
            multiple
          >
            ";
        // line 394
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["segments"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
            // line 395
            echo "              <option value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "id", []), "html", null, true);
            echo "\">";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "name", []), "html", null, true);
            echo " (";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "subscribers", []), "html", null, true);
            echo ")</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 397
        echo "          </select>
        </p>
      </td>
    </tr>
    <!-- shortcode: total number of subscribers -->
    <tr>
      <th scope=\"row\">
        <label>
          ";
        // line 405
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Shortcode to display total number of subscribers");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 408
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Paste this shortcode on a post or page to display the total number of confirmed subscribers.");
        echo "
        </p>
      </th>
      <td>
        <p>
          <input
            type=\"text\"
            class=\"regular-text\"
            id=\"mailpoet_shortcode_subscribers\"
            value=\"[mailpoet_subscribers_count]\"
            onClick=\"this.focus();this.select();\"
            readonly=\"readonly\"
          />
        </p>
        <p>
          <select
            id=\"mailpoet_shortcode_subscribers_count\"
            data-shortcode=\"mailpoet_subscribers_count\"
            data-output=\"mailpoet_shortcode_subscribers\"
            data-placeholder=\"";
        // line 427
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Leave this field empty to display all lists");
        echo "\"
            multiple
          >
            ";
        // line 430
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["segments"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
            // line 431
            echo "              <option value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "id", []), "html", null, true);
            echo "\">";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "name", []), "html", null, true);
            echo " (";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["segment"], "subscribers", []), "html", null, true);
            echo ")</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 433
        echo "          </select>
        </p>
      </td>
    </tr>
    <!-- gdpr compliant  -->
    <tr>
      <th scope=\"row\">
        <label>
          ";
        // line 441
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Be GDPR compliant");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 444
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("You need to comply with European law in regards to data privacy if you have European subscribers. Rest assured, it’s easy!");
        echo "
        </p>
      </th>
      <td>
        <p>
          <a
            href=\"https://kb.mailpoet.com/article/246-guide-to-conform-to-gdpr\"
            data-beacon-article=\"5a9e8cdd04286374f7089a8c\"
            title=\"";
        // line 452
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read our guide");
        echo "\"
            target=\"_blank\"
          >";
        // line 454
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read our guide");
        echo "</a>
        </p>
      </td>
    </tr>
  </tbody>
</table>

<script type=\"text/javascript\">
  jQuery(function(\$) {
    // on dom loaded
    \$(function() {
      // select2 instances
      \$('#mailpoet_subscribe_on_comment_segments').select2();
      \$('#mailpoet_subscribe_on_register_segments').select2();
      \$('#mailpoet_subscription_edit_segments').select2();
      \$('#mailpoet_shortcode_archives_list').select2();
      \$('#mailpoet_shortcode_subscribers_count').select2();
      // fix lengthy placeholder from being cut off by select 2
      \$('.select2-search__field').each(function() {
        \$(this).css('width', (\$(this).attr('placeholder').length * 0.75) + 'em');
      });

      // shortcodes
      \$('#mailpoet_shortcode_archives_list, #mailpoet_shortcode_subscribers_count')
      .on('change', function() {
        var shortcode = \$(this).data('shortcode'),
          values = \$(this).val() || [];

        if (values.length > 0) {
          shortcode += ' segments=\"';
          shortcode += values.join(',');
          shortcode += '\"';
        }

        \$('#' + \$(this).data('output'))
          .val('[' + shortcode + ']');
      });
    });
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "settings/basics.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  839 => 454,  834 => 452,  823 => 444,  817 => 441,  807 => 433,  794 => 431,  790 => 430,  784 => 427,  762 => 408,  756 => 405,  746 => 397,  733 => 395,  729 => 394,  723 => 391,  701 => 372,  695 => 369,  685 => 362,  678 => 358,  668 => 352,  664 => 350,  662 => 349,  650 => 341,  646 => 339,  644 => 338,  633 => 330,  627 => 327,  617 => 320,  610 => 316,  600 => 310,  596 => 308,  594 => 307,  582 => 299,  578 => 297,  576 => 296,  566 => 288,  564 => 285,  558 => 282,  546 => 273,  541 => 271,  535 => 267,  526 => 265,  522 => 263,  520 => 262,  516 => 261,  512 => 260,  509 => 259,  505 => 258,  492 => 248,  487 => 246,  481 => 243,  471 => 235,  460 => 233,  456 => 231,  454 => 230,  450 => 229,  447 => 228,  443 => 227,  437 => 224,  428 => 218,  422 => 215,  417 => 213,  411 => 209,  402 => 207,  398 => 205,  396 => 204,  392 => 203,  388 => 202,  385 => 201,  381 => 200,  368 => 190,  363 => 188,  357 => 185,  349 => 179,  343 => 176,  340 => 175,  334 => 171,  323 => 169,  319 => 167,  317 => 166,  313 => 165,  310 => 164,  306 => 163,  300 => 160,  291 => 154,  286 => 151,  280 => 149,  274 => 147,  272 => 146,  260 => 136,  256 => 134,  254 => 133,  245 => 126,  243 => 125,  236 => 121,  230 => 118,  219 => 109,  208 => 107,  204 => 105,  202 => 104,  198 => 103,  195 => 102,  191 => 101,  185 => 98,  176 => 92,  171 => 89,  165 => 87,  159 => 85,  157 => 84,  146 => 75,  142 => 74,  128 => 63,  122 => 60,  110 => 51,  104 => 50,  92 => 41,  86 => 40,  74 => 31,  63 => 23,  57 => 20,  43 => 9,  37 => 6,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "settings/basics.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/settings/basics.html");
    }
}
