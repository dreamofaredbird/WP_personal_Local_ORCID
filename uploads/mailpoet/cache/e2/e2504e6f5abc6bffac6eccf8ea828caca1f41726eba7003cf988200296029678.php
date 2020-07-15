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

/* settings/premium.html */
class __TwigTemplate_9cacf1b29092b27ee676feb2435787f7ce93384769cbf7f35a868cc5acac9c28 extends \MailPoetVendor\Twig\Template
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
        echo "<script type=\"text/javascript\">
  ";
        // line 3
        echo "    var mailpoet_activation_key = ";
        echo json_encode((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "premium", []), "premium_key", [])) ? ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "premium", []), "premium_key", [])) : ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "mailpoet_api_key", []))));
        echo ";
    var mailpoet_premium_key_valid = ";
        // line 4
        echo json_encode(($context["premium_key_valid"] ?? null));
        echo ";
    var mailpoet_premium_plugin_installed = ";
        // line 5
        echo json_encode(($context["premium_plugin_installed"] ?? null));
        echo ";
    var mailpoet_mss_key_valid = ";
        // line 6
        echo json_encode(($context["mss_key_valid"] ?? null));
        echo ";
    var mailpoet_mss_active = ";
        // line 7
        echo json_encode(($context["mss_active"] ?? null));
        echo ";
  ";
        // line 9
        echo "</script>

<div id=\"settings-premium-tab\"></div>
";
    }

    public function getTemplateName()
    {
        return "settings/premium.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 9,  50 => 7,  46 => 6,  42 => 5,  38 => 4,  33 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "settings/premium.html", "/Users/rob/Local Sites/local-orcidaboutdev/app/public/wp-content/plugins/mailpoet/views/settings/premium.html");
    }
}
