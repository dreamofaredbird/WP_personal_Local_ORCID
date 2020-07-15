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

/* newsletter/templates/blocks/woocommerceHeading/block.hbs */
class __TwigTemplate_de73b63d201874855d3e31beaf72f4851c85754fe0fab911f6b50f6d7e5cef35 extends \MailPoetVendor\Twig\Template
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
        echo "<div class=\"mailpoet_tools\"></div>
<style type=\"text/css\">
\t.mailpoet_editor_view_{{ viewCid }} .mailpoet_content {
\t\tpadding: 30px 20px;
\t\tbackground: {{ styles.backgroundColor }};
\t}
\t.mailpoet_editor_view_{{ viewCid }} .mailpoet_content h1 {
\t\tline-height: 1.2em;
\t\tfont-family: 'Source Sans Pro';
\t\tfont-size: 36px;
\t\tcolor: {{ styles.fontColor }};
\t}
</style>
<div class=\"mailpoet_content mailpoet_woocommerce_heading\" data-automation-id=\"woocommerce_heading\">
\t<h1>{{ content }}</h1>
</div>
<div class=\"mailpoet_block_highlight\"></div>";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/woocommerceHeading/block.hbs";
    }

    public function getDebugInfo()
    {
        return array (  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/woocommerceHeading/block.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/woocommerceHeading/block.hbs");
    }
}
