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

/* form/templatesLegacy/settings/segment_selection_item.hbs */
class __TwigTemplate_e452ddcbbf612c60f94fa278d70c8facf67f252d9108f15febf6c083c7c5c6f0 extends \MailPoetVendor\Twig\Template
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
        echo "{{#each segments}}
<li data-segment=\"{{ id }}\">
  <label>
    <input class=\"mailpoet_segment_id\" type=\"hidden\" value=\"{{ id }}\" />
    <input class=\"mailpoet_is_checked\" type=\"checkbox\" value=\"1\"
      {{#ifCond is_checked '>' 0}}checked=\"checked\"{{/ifCond}} />
    <input class=\"mailpoet_segment_name\" type=\"hidden\" value=\"{{ name }}\" />
    {{ name }}
  </label>
  <a class=\"remove\" href=\"javascript:;\">";
        // line 10
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Remove");
        echo "</a>
  <a class=\"handle\" href=\"javascript:;\">";
        // line 11
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Move");
        echo "</a>
</li>
{{/each}}";
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/settings/segment_selection_item.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 11,  41 => 10,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/settings/segment_selection_item.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/templatesLegacy/settings/segment_selection_item.hbs");
    }
}
