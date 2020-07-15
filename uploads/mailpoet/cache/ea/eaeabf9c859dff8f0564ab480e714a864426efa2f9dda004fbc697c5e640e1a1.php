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

/* form/templatesLegacy/blocks/container.hbs */
class __TwigTemplate_c6b076a37a279bec5fce0eb5e85533ead78c98a5f74fc179a287b6b0a801de7f extends \MailPoetVendor\Twig\Template
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
        echo "<div class=\"mailpoet_form_block\"
  wysija_type=\"{{ type }}\"
  {{#if id}}wysija_id=\"{{ id }}\"{{/if}}
  wysija_name=\"{{ name }}\"
  wysija_unique=\"{{ unique }}\"
  wysija_static=\"{{#ifCond static '==' 1}}1{{else}}0{{/ifCond}}\"
  wysija_params=\"{{#if params}}{{ json_encode params }}{{/if}}\">
  {{#ifCond type '!==' 'divider'}}
    <div class=\"wysija_settings\" style=\"display:none;\">
      <a class=\"settings\" href=\"javascript:;\"><span></span>";
        // line 10
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Edit display");
        echo "</a>
    </div>
  {{/ifCond}}
  <ul class=\"wysija_controls clearfix\" style=\"display: none;\">
    <li class=\"handle_container\"><a class=\"handle\" href=\"javascript:;\"><span></span></a></li>
    {{#ifCond static '==' '0'}}
      <li><a class=\"remove\" href=\"javascript:;\"><span></span></a></li>
    {{/ifCond}}
  </ul>
  {{{ template }}}
</div>";
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/blocks/container.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 10,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/blocks/container.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/templatesLegacy/blocks/container.hbs");
    }
}
