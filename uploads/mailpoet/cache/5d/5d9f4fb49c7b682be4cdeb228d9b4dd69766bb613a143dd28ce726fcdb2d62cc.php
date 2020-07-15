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

/* newsletter/templates/blocks/woocommerceContent/processing_order.hbs */
class __TwigTemplate_9ff7c7d61ca439d1ccaefccccf39a8431285e04b11101c5282407d49f7171db6 extends \MailPoetVendor\Twig\Template
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
        echo sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("Just to let you know &mdash; we've received your order #%s, and it is now being processed:", "woocommerce"), "0001");
        echo "</p>

<h2
\tstyle=\"display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">
\t";
        // line 15
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("[Order #0001]", "woocommerce");
        echo "</h2>

<div style=\"margin-bottom:40px\">
\t<table class=\"m_3180768237544866075td\" cellspacing=\"0\" cellpadding=\"6\" border=\"1\"
\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t<thead>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 23
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Product", "woocommerce");
        echo "</th>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 25
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Quantity", "woocommerce");
        echo "
\t\t\t\t</th>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 28
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Price", "woocommerce");
        echo "</th>
\t\t\t</tr>
\t\t</thead>
\t\t<tbody>
\t\t\t<tr class=\"m_3180768237544866075order_item\">
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word\">
\t\t\t\t\tMy First Product </td>
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t\t\t\t1 </td>
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t\t\t\t<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">10,00<span
\t\t\t\t\t\t\tclass=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> </td>
\t\t\t</tr>

\t\t</tbody>
\t\t<tfoot>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px\">
\t\t\t\t\t";
        // line 50
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subtotal:", "woocommerce");
        echo "</th>
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px\">
\t\t\t\t\t<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">10,00<span
\t\t\t\t\t\t\tclass=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span></td>
\t\t\t</tr>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 58
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Shipping:", "woocommerce");
        echo "
\t\t\t\t</th>
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
\t\t\t\t\t<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">4,90<span
\t\t\t\t\t\t\tclass=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span>
\t\t\t\t</td>
\t\t\t</tr>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
\t\t\t\t\t";
        // line 69
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Payment method:", "woocommerce");
        echo "</th>
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">Paypal</td>
\t\t\t</tr>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 75
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Total:", "woocommerce");
        echo "</th>
\t\t\t\t<td class=\"m_3180768237544866075td\"
\t\t\t\t\tstyle=\"color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
\t\t\t\t\t<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">14,90<span
\t\t\t\t\t\t\tclass=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> <small
\t\t\t\t\t\tclass=\"m_3180768237544866075includes_tax\">(includes <span
\t\t\t\t\t\t\tclass=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">0,91<span
\t\t\t\t\t\t\t\tclass=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> VAT)</small>
\t\t\t\t</td>
\t\t\t</tr>
\t\t</tfoot>
\t</table>
</div>

<table id=\"m_3180768237544866075addresses\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"
\tstyle=\"width:100%;vertical-align:top;margin-bottom:40px;padding:0\">
\t<tbody>
\t\t<tr>
\t\t\t<td valign=\"top\" width=\"50%\"
\t\t\t\tstyle=\"text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;border:0;padding:0\">
\t\t\t\t<h2
\t\t\t\t\tstyle=\"display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">
\t\t\t\t\t";
        // line 97
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Billing address", "woocommerce");
        echo "</h2>

\t\t\t\t<address class=\"m_3180768237544866075address\" style=\"padding:12px;color:#737373;border:1px solid #e4e4e4\">Elon
\t\t\t\t\tMusk<br>42 rue Blue Origin<br>75000 Paris<br>France</address>
\t\t\t</td>
\t\t\t<td valign=\"top\" width=\"50%\"
\t\t\t\tstyle=\"text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;padding:0\">
\t\t\t\t<h2
\t\t\t\t\tstyle=\"display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">
\t\t\t\t\t";
        // line 106
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Shipping address", "woocommerce");
        echo "</h2>

\t\t\t\t<address class=\"m_3180768237544866075address\" style=\"padding:12px;color:#737373;border:1px solid #e4e4e4\">Elon
\t\t\t\t\tMusk<br>42 rue Blue Origin<br>75000 Paris<br>France</address>
\t\t\t</td>
\t\t</tr>
\t</tbody>
</table>
<p style=\"margin:0 0 16px\">";
        // line 114
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Thanks for shopping with us.", "woocommerce");
        echo "</p>
</div>
<div class=\"mailpoet_block_highlight\"></div>";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/woocommerceContent/processing_order.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  181 => 114,  170 => 106,  158 => 97,  133 => 75,  124 => 69,  110 => 58,  99 => 50,  74 => 28,  68 => 25,  63 => 23,  52 => 15,  45 => 11,  41 => 10,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/woocommerceContent/processing_order.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/woocommerceContent/processing_order.hbs");
    }
}
