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

/* newsletter/templates/blocks/woocommerceContent/customer_note.hbs */
class __TwigTemplate_02eee114d1f87da587878fe8f641ec726f75ec5228310ddd67d2b344819c0ab7 extends \MailPoetVendor\Twig\Template
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
    .mailpoet_editor_view_{{ viewCid }} .mailpoet_content h1,
    .mailpoet_editor_view_{{ viewCid }} .mailpoet_content h2,
    .mailpoet_editor_view_{{ viewCid }} .mailpoet_content h3 {
        color: {{ styles.titleColor }};
    }
</style>
<div class=\"mailpoet_content mailpoet_woocommerce_content\" data-automation-id=\"woocommerce_content\">
<p style=\"margin:0 0 16px\">";
        // line 10
        echo \MailPoetVendor\twig_escape_filter($this->env, sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("Hi %s,", "woocommerce"), "Elon"), "html", null, true);
        echo "</p>
<p style=\"margin:0 0 16px\">";
        // line 11
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("The following note has been added to your order:", "woocommerce");
        echo "</p>
<blockquote>
<p style=\"margin:0 0 16px\">Hi Elon, welcome to MailPoet!</p>
</blockquote>
<p style=\"margin:0 0 16px\">";
        // line 15
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("As a reminder, here are your order details:", "woocommerce");
        echo "</p>
<h2 style=\"display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">
\t";
        // line 17
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("[Order #0001]", "woocommerce");
        echo "</h2>

<div style=\"margin-bottom:40px\">
\t<table class=\"m_3180768237544866075td\" cellspacing=\"0\" cellpadding=\"6\" border=\"1\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t<thead>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 23
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Product", "woocommerce");
        echo "</th>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 24
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Quantity", "woocommerce");
        echo "</th>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 25
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Price", "woocommerce");
        echo "</th>
\t\t\t</tr>
\t\t</thead>
\t\t<tbody>
\t\t\t\t<tr class=\"m_3180768237544866075order_item\">
\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word\">
\t\tMy First Product\t\t</td>
\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t\t1\t\t</td>
\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t\t<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">10,00<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span>\t\t</td>
\t</tr>

\t\t</tbody>
\t\t<tfoot>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px\">";
        // line 41
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subtotal:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px\"><span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">10,00<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span></td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 45
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Shipping:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">4,90<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span>
</td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 51
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Payment method:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">Paypal</td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 55
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Total:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">14,90<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> <small class=\"m_3180768237544866075includes_tax\">(includes <span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">0,91<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> VAT)</small>
</td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</tfoot>
\t</table>
</div>

<table id=\"m_3180768237544866075addresses\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width:100%;vertical-align:top;margin-bottom:40px;padding:0\">
\t<tbody><tr>
\t\t<td valign=\"top\" width=\"50%\" style=\"text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;border:0;padding:0\">
\t\t\t<h2 style=\"display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">";
        // line 67
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Billing address", "woocommerce");
        echo "</h2>

\t\t\t<address class=\"m_3180768237544866075address\" style=\"padding:12px;color:#737373;border:1px solid #e4e4e4\">Elon Musk<br>42 rue Blue Origin<br>75000 Paris<br>France</address>
\t\t</td>
\t\t\t\t\t<td valign=\"top\" width=\"50%\" style=\"text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;padding:0\">
\t\t\t\t<h2 style=\"display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">";
        // line 72
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Shipping address", "woocommerce");
        echo "</h2>

\t\t\t\t<address class=\"m_3180768237544866075address\" style=\"padding:12px;color:#737373;border:1px solid #e4e4e4\">Elon Musk<br>42 rue Blue Origin<br>75000 Paris<br>France</address>
\t\t\t</td>
\t\t\t</tr>
</tbody></table>
<p style=\"margin:0 0 16px\">";
        // line 78
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Thanks for reading.", "woocommerce");
        echo "</p>
</div>
<div class=\"mailpoet_block_highlight\"></div>";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/woocommerceContent/customer_note.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  148 => 78,  139 => 72,  131 => 67,  116 => 55,  109 => 51,  100 => 45,  93 => 41,  74 => 25,  70 => 24,  66 => 23,  57 => 17,  52 => 15,  45 => 11,  41 => 10,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/woocommerceContent/customer_note.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/woocommerceContent/customer_note.hbs");
    }
}
