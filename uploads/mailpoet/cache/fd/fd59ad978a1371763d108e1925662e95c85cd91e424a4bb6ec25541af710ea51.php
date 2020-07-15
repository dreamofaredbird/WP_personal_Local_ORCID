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

/* settings/signup.html */
class __TwigTemplate_10e8f229e1230b183993ccb53c487a4c0fd3893499fba5b101c1b88af68f9500 extends \MailPoetVendor\Twig\Template
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
    <!-- enable sign-up confirmation -->
    <tr>
      <th scope=\"row\">
        <label>
          ";
        // line 7
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Enable sign-up confirmation");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 10
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("If you enable this option, your subscribers will first receive a confirmation email after they subscribe. Once they confirm their subscription (via this email), they will be marked as 'confirmed' and will begin to receive your email newsletters.");
        echo "
          <a href=\"https://kb.mailpoet.com/article/128-why-you-should-use-signup-confirmation-double-opt-in\" data-beacon-article=\"57ce097f903360649f6e5700\" target=\"_blank\">";
        // line 11
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read more about Double Opt-in confirmation.");
        echo "</a>
        </p>
      </th>
      <td>
        <p
          id=\"mailpoet_signup_confirmation_notice\"
          ";
        // line 17
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) != "mailpoet")) {
            echo "style=\"display:none;\"";
        }
        // line 18
        echo "        >";
        // line 19
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sign-up confirmation is mandatory when using the MailPoet Sending Service.");
        // line 20
        echo "</p>
        <p
          id=\"mailpoet_signup_confirmation_input\"
          ";
        // line 23
        if (($this->getAttribute(($context["settings"] ?? null), "mta_group", []) == "mailpoet")) {
            echo "style=\"display:none;\"";
        }
        // line 24
        echo "        >
          <label>
            <input
              type=\"radio\"
              class=\"mailpoet_signup_confirmation\"
              data-automation-id=\"enable_signup_confirmation\"
              name=\"signup_confirmation[enabled]\"
              value=\"1\"
              ";
        // line 32
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "enabled", [])) {
            // line 33
            echo "                checked=\"checked\"
              ";
        }
        // line 35
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes");
        echo "
          </label>
          &nbsp;
          <label>
            <input
              type=\"radio\"
              class=\"mailpoet_signup_confirmation\"
              data-automation-id=\"disable_signup_confirmation\"
              name=\"signup_confirmation[enabled]\"
              value=\"\"
              ";
        // line 45
        if ( !$this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "enabled", [])) {
            // line 46
            echo "                checked=\"checked\"
              ";
        }
        // line 48
        echo "            />";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("No");
        echo "
          </label>
        </p>
      </td>
    </tr>
  </tbody>
</table>
<table id=\"mailpoet_signup_options\" class=\"form-table\">
  <tbody>
    <!-- confirmation email: title -->
    <tr>
      <th scope=\"row\">
        <label for=\"settings[signup_confirmation_email_subject]\">
        ";
        // line 61
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email subject");
        echo "
        </label>
      </th>
      <td>
        <input
          size=\"52\"
          type=\"text\"
          id=\"settings[signup_confirmation_email_subject]\"
          data-automation-id=\"signup_confirmation_email_subject\"
          name=\"signup_confirmation[subject]\"
          ";
        // line 71
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "subject", [])) {
            // line 72
            echo "            value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "subject", []), "html", null, true);
            echo "\"
          ";
        }
        // line 74
        echo "        />
      </td>
    </tr>
    <!-- confirmation email: body -->
    <tr>
      <th scope=\"row\">
        <label for=\"settings[signup_confirmation_email_body]\">
          ";
        // line 81
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email content");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 84
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Don't forget to include:<br /><br />[activation_link]Confirm your subscription.[/activation_link]<br /><br />Optional: [lists_to_confirm].");
        echo "
        </p>
      </th>
      <td>
        <textarea
          cols=\"50\"
          rows=\"15\"
          id=\"settings[signup_confirmation_email_body]\"
          data-automation-id=\"signup_confirmation_email_body\"
          name=\"signup_confirmation[body]\"
        >";
        // line 94
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "body", [])) {
            // line 95
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "signup_confirmation", []), "body", []), "html", null, true);
        }
        // line 96
        echo "</textarea>
      </td>
    </tr>
    <!-- sign-up confirmation: confirmation page -->
    <tr>
      <th scope=\"row\">
        <label>
          ";
        // line 103
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Confirmation page");
        echo "
        </label>
        <p class=\"description\">
          ";
        // line 106
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("When subscribers click on the activation link, they will be redirected to this page.");
        echo "
        </p>
      </th>
      <td>
        <p>
          <select
            class=\"mailpoet_page_selection\"
            data-automation-id=\"page_selection\"
            name=\"subscription[pages][confirmation]\"
          >
            ";
        // line 116
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["pages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 117
            echo "              <option
                value=\"";
            // line 118
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["page"], "id", []), "html", null, true);
            echo "\"
                data-preview-url=\"";
            // line 119
            echo $this->getAttribute($this->getAttribute($context["page"], "url", []), "confirm", []);
            echo "\"
                ";
            // line 120
            if (($this->getAttribute($context["page"], "id", []) == $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "subscription", []), "pages", []), "confirmation", []))) {
                // line 121
                echo "                  selected=\"selected\"
                ";
            }
            // line 123
            echo "              >";
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["page"], "title", []), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 125
        echo "          </select>
          <a
            class=\"mailpoet_page_preview\"
            data-automation-id=\"preview_page_link\"
            href=\"javascript:;\"
            title=\"";
        // line 130
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview page");
        echo "\"
          >";
        // line 131
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview");
        echo "</a>
        </p>
      </td>
    </tr>
  </tbody>
</table>

<script type=\"text/javascript\">
  jQuery(function(\$) {
    // om dom loaded
    \$(function() {
      // double optin toggling
      toggleSignupOptions();

      \$('.mailpoet_signup_confirmation').on('click', function() {
        var result = false;

        if(~~(\$(this).val()) === 1) {
          result = confirm(\"";
        // line 149
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscribers will need to activate their subscription via email in order to receive your newsletters. This is highly recommended!"), "js"), "html", null, true);
        echo "\");
        } else {
          result = confirm(\"";
        // line 151
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("New subscribers will be automatically confirmed, without having to confirm their subscription. This is not recommended!"), "js"), "html", null, true);
        echo "\");
        }
        // if the user confirmed changing the sign-up confirmation (yes/no)
        if(result === true) {
          // toggle signup options depending on the currently selected value
          toggleSignupOptions();
        }
        return result;
      });

      function toggleSignupOptions() {
        var is_enabled =
          (~~(\$('.mailpoet_signup_confirmation:checked').val()) === 1);
        \$('#mailpoet_signup_options')[(is_enabled) ? 'show' : 'hide']();
      }
    });
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "settings/signup.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  276 => 151,  271 => 149,  250 => 131,  246 => 130,  239 => 125,  230 => 123,  226 => 121,  224 => 120,  220 => 119,  216 => 118,  213 => 117,  209 => 116,  196 => 106,  190 => 103,  181 => 96,  178 => 95,  176 => 94,  163 => 84,  157 => 81,  148 => 74,  142 => 72,  140 => 71,  127 => 61,  110 => 48,  106 => 46,  104 => 45,  90 => 35,  86 => 33,  84 => 32,  74 => 24,  70 => 23,  65 => 20,  63 => 19,  61 => 18,  57 => 17,  48 => 11,  44 => 10,  38 => 7,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "settings/signup.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/settings/signup.html");
    }
}
