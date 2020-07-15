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

/* settings/templates/sending_frequency.hbs */
class __TwigTemplate_a7bd94cf864bf55d8fe100ddb1f32ffe3bc6460df65193419e245d2937d503b3 extends \MailPoetVendor\Twig\Template
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
        echo "{{#unless only_daily}}
  <!-- number of emails & frequency  -->
  ";
        // line 3
        echo \MailPoetVendor\twig_escape_filter($this->env, sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s emails"), "{{ emails }}"), "html", null, true);
        // line 6
        echo " {{ format_time interval }}.
{{/unless}}

<!--  number of emails per day -->
";
        // line 10
        echo sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("That's <strong>%1\$s emails</strong> per day"), "{{ daily_emails }}");
        // line 14
        echo "

{{#ifCond emails_per_second \">\" \"1\"}}
  <br /><br />
  <span style=\"color: #d54e21;\">
    ";
        // line 19
        echo sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("That's %1\$s emails per second. <strong>We highly recommend to send 1 email per second, at the absolute maximum.</strong> MailPoet needs at least one second to process and send a single email (on most hosts.) <strong>Alternatively, send with MailPoet, which can be up to 50 times faster.</strong>"), "{{ emails_per_second }}");
        // line 23
        echo "
  </span>
{{/ifCond}}";
    }

    public function getTemplateName()
    {
        return "settings/templates/sending_frequency.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 23,  51 => 19,  44 => 14,  42 => 10,  36 => 6,  34 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "settings/templates/sending_frequency.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/settings/templates/sending_frequency.hbs");
    }
}
