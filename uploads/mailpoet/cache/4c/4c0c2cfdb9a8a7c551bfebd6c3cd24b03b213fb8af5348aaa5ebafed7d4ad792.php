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

/* form/templatesLegacy/toolbar/fields.hbs */
class __TwigTemplate_bce16c81056676d00d4395e55ca25f40d279225a70037a670e9f9ba9a9f60edd extends \MailPoetVendor\Twig\Template
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
        echo "{{#each fields}}
  <li>
    <a class=\"mailpoet_form_field\"
      wysija_name=\"{{ name }}\"
      {{#if id }}wysija_id=\"{{ id }}\"{{/if}}
      wysija_unique=\"{{#if multiple}}0{{else}}1{{/if}}\"
      wysija_type=\"{{ type }}\"
      {{#if params}}wysija_params=\"{{ json_encode params }}\"{{/if}}>
      {{ name }}
    </a>

  {{#unless readonly}}
    <a class=\"mailpoet_form_field_edit settings\"
      title=\"";
        // line 14
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Edit field");
        echo "\"
      href=\"javascript:;\"
      data-id=\"{{ id }}\">
      <span class=\"dashicons dashicons-admin-generic\"></span>
    </a>
    <a class=\"mailpoet_form_field_delete delete\"
      title=\"";
        // line 20
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Delete field");
        echo "\"
      href=\"javascript:;\"
      data-id=\"{{ id }}\">
      <span class=\"dashicons dashicons-dismiss\"></span>
    </a>
  {{/unless}}
  </li>
{{/each}}";
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/toolbar/fields.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 20,  45 => 14,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/toolbar/fields.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/templatesLegacy/toolbar/fields.hbs");
    }
}
