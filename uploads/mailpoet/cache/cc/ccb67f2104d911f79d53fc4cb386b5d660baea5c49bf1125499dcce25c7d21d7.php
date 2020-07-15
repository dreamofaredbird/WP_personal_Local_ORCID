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

/* newsletter/templates/blocks/woocommerceHeading/settings.hbs */
class __TwigTemplate_cc5f8bbc9dbc2cb019e6afc53b31d50cbd91006aaffd482a4840ab9e85fb3103 extends \MailPoetVendor\Twig\Template
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
        echo "<h3>";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("WooCommerce Email Heading", "Name of a widget in the email editor. This widget is used to display WooCommerce messages (like ”Thanks for your order!”)");
        echo "</h3>

<div class=\"mailpoet_form_field\">
    <div class=\"mailpoet_form_field_input_option\">
        <input type=\"text\" name=\"font-color\" class=\"mailpoet_field_wc_heading_font_color mailpoet_color\" value=\"{{ styles.fontColor }}\" />
    </div>
    <div class=\"mailpoet_form_field_title mailpoet_form_field_title_inline\">";
        // line 7
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Font color");
        echo "</div>
</div>

<div class=\"mailpoet_form_field\">
    <div class=\"mailpoet_form_field_input_option\">
        <input type=\"text\" name=\"background-color\" class=\"mailpoet_field_wc_heading_background_color mailpoet_color\" value=\"{{ styles.backgroundColor }}\" />
    </div>
    <div class=\"mailpoet_form_field_title mailpoet_form_field_title_inline\">";
        // line 14
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Background color");
        echo "</div>
</div>

<a href=\"?page=wc-settings&tab=email\" target=\"_blank\">";
        // line 17
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Customize WooCommerce email headings.");
        echo "</a>

<div class=\"mailpoet_form_field\">
    <input type=\"button\" class=\"button button-primary mailpoet_done_editing\" data-automation-id=\"spacer_done_button\" value=\"";
        // line 20
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("Done"), "html_attr");
        echo "\" />
</div>";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/woocommerceHeading/settings.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 20,  56 => 17,  50 => 14,  40 => 7,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/woocommerceHeading/settings.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/woocommerceHeading/settings.hbs");
    }
}
