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

/* form/templatesLegacy/settings/date_types.hbs */
class __TwigTemplate_f2c4d9b006cfca60f45e53f2a564241ef95390b6713afc07f405eabaea5e3f93 extends \MailPoetVendor\Twig\Template
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
        echo "<p class=\"clearfix\">
  <label>";
        // line 2
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Type of date");
        echo "</label>
  <select name=\"params[date_type]\">
    ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["date_types"] ?? null));
        foreach ($context['_seq'] as $context["type"] => $context["label"]) {
            // line 5
            echo "      <option
        {{#ifCond params.date_type \"==\" \"";
            // line 6
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["type"], "html", null, true);
            echo "\"}}
          selected=\"selected\"
        {{/ifCond}}
        data-format=\"";
            // line 9
            echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["date_formats"] ?? null), $context["type"], [], "array"), 0, [], "array"), "html", null, true);
            echo "\" value=\"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["type"], "html", null, true);
            echo "\"
      >";
            // line 10
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["label"], "html", null, true);
            echo "</option>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['label'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "  </select>
  <input type=\"hidden\" name=\"params[date_format]\" value=\"\" />
</p>

<script type=\"text/javascript\">
  jQuery(function(\$) {
    \$('select[name=\"params[date_type]\"]').on('change', function() {
      // set default date format depending on date type
      \$('input[name=\"params[date_format]\"]')
        .val(\$(this)
        .find('option:selected')
        .data('format'));
    });
    // set default format
    \$('select[name=\"params[date_type]\"]').trigger('change');
  });
<{{!}}/script>";
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/settings/date_types.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 12,  57 => 10,  51 => 9,  45 => 6,  42 => 5,  38 => 4,  33 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/settings/date_types.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/templatesLegacy/settings/date_types.hbs");
    }
}
