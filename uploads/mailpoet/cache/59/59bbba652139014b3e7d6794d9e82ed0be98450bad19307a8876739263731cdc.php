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

/* form/templatesLegacy/settings/date_formats.hbs */
class __TwigTemplate_aa1672a7ac1c691614b1ab006ef69f5d6747349f2bbf7698a8ea6483e955b94d extends \MailPoetVendor\Twig\Template
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
        $context['_parent'] = $context;
        $context['_seq'] = \MailPoetVendor\twig_ensure_traversable(($context["date_formats"] ?? null));
        foreach ($context['_seq'] as $context["date_type"] => $context["formats"]) {
            // line 2
            echo "  {{#ifCond params.date_type \"===\" \"";
            echo \MailPoetVendor\twig_escape_filter($this->env, $context["date_type"], "html", null, true);
            echo "\"}}
    ";
            // line 3
            if ((\MailPoetVendor\twig_length_filter($this->env, $context["formats"]) == 1)) {
                // line 4
                echo "      <!-- display format as hidden value -->
      <input type=\"hidden\" name=\"params[date_format]\" value=\"";
                // line 5
                echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($context["formats"], 0, [], "array"), "html", null, true);
                echo "\" />
    ";
            } else {
                // line 7
                echo "      <!-- display label -->
      <p class=\"clearfix\">
        <label>";
                // line 9
                echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Order");
                echo "</label>
        <!-- display all possible date formats -->
        <select name=\"params[date_format]\">
          ";
                // line 12
                $context['_parent'] = $context;
                $context['_seq'] = \MailPoetVendor\twig_ensure_traversable($context["formats"]);
                foreach ($context['_seq'] as $context["_key"] => $context["format"]) {
                    // line 13
                    echo "            <option
              {{#ifCond params.date_format \"===\" \"";
                    // line 14
                    echo \MailPoetVendor\twig_escape_filter($this->env, $context["format"], "html", null, true);
                    echo "\"}}
                selected=\"selected\"
              {{/ifCond}}
              value=\"";
                    // line 17
                    echo \MailPoetVendor\twig_escape_filter($this->env, $context["format"], "html", null, true);
                    echo "\">";
                    echo \MailPoetVendor\twig_escape_filter($this->env, $context["format"], "html", null, true);
                    echo "</option>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['format'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 19
                echo "        </select>
      </p>
    ";
            }
            // line 22
            echo "  {{/ifCond}}
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['date_type'], $context['formats'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/settings/date_formats.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 22,  82 => 19,  72 => 17,  66 => 14,  63 => 13,  59 => 12,  53 => 9,  49 => 7,  44 => 5,  41 => 4,  39 => 3,  34 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/settings/date_formats.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/templatesLegacy/settings/date_formats.hbs");
    }
}
