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

/* form/custom_fields_legacy.html */
class __TwigTemplate_3a02d129614de1a9f8e0ec3bb1b38b652371d096c3bc75e358500ea655534c22 extends \MailPoetVendor\Twig\Template
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
        echo "<!-- date settings and block templates -->
";
        // line 2
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "form_template_date_years", "form/templatesLegacy/blocks/date_years.hbs", "_settings_date_years");
        // line 5
        echo "
";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "form_template_date_months", "form/templatesLegacy/blocks/date_months.hbs", "_settings_date_months");
        // line 9
        echo "
";
        // line 10
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "form_template_date_days", "form/templatesLegacy/blocks/date_days.hbs", "_settings_date_days");
        // line 13
        echo "
";
        // line 14
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "form_template_date", "form/templatesLegacy/blocks/date.hbs");
        echo "

<!-- field settings -->
";
        // line 17
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "form_template_field_settings", "form/templatesLegacy/settings/field.hbs");
        echo "

";
        // line 19
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_label", "form/templatesLegacy/settings/label.hbs", "_settings_label");
        // line 22
        echo "
";
        // line 23
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_label_within", "form/templatesLegacy/settings/label_within.hbs", "_settings_label_within");
        // line 26
        echo "
";
        // line 27
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_required", "form/templatesLegacy/settings/required.hbs", "_settings_required");
        // line 30
        echo "
";
        // line 31
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_validate", "form/templatesLegacy/settings/validate.hbs", "_settings_validate");
        // line 34
        echo "
";
        // line 35
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_values", "form/templatesLegacy/settings/values.hbs", "_settings_values");
        // line 38
        echo "
";
        // line 39
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_date_default", "form/templatesLegacy/settings/date_default.hbs", "_settings_date_default");
        // line 42
        echo "
";
        // line 43
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_submit", "form/templatesLegacy/settings/submit.hbs", "_settings_submit");
        // line 46
        echo "

";
        // line 48
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_values_item", "form/templatesLegacy/settings/values_item.hbs");
        // line 49
        echo "
";
        // line 50
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_date_format", "form/templatesLegacy/settings/date_formats.hbs", "_settings_date_format");
        // line 54
        echo "
";
        // line 55
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_date_type", "form/templatesLegacy/settings/date_types.hbs", "_settings_date_type");
        // line 59
        echo "
";
        // line 60
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_segment_selection_item", "form/templatesLegacy/settings/segment_selection_item.hbs");
        // line 62
        echo "
";
        // line 63
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "field_settings_segment_selection", "form/templatesLegacy/settings/segment_selection.hbs", "_settings_segment_selection");
        // line 66
        echo "

<!-- custom field: new -->
";
        // line 69
        echo $this->env->getExtension('MailPoet\Twig\Handlebars')->generatePartial($this->env, $context, "form_template_field_form", "form/templatesLegacy/settings/field_form.hbs");
        // line 71
        echo "

<!-- field settings depending on field type -->
<script id=\"form_template_field_text\" type=\"text/x-handlebars-template\">
  {{> _settings_required }}
  {{> _settings_validate }}
</script>

<script id=\"form_template_field_textarea\" type=\"text/x-handlebars-template\">
  {{> _settings_required }}
  {{> _settings_validate }}
</script>

<script id=\"form_template_field_radio\" type=\"text/x-handlebars-template\">
  {{> _settings_values }}
  {{> _settings_required }}
</script>

<script id=\"form_template_field_checkbox\" type=\"text/x-handlebars-template\">
  {{> _settings_values }}
  {{> _settings_required }}
</script>

<script id=\"form_template_field_select\" type=\"text/x-handlebars-template\">
  {{> _settings_values }}
  {{> _settings_required }}
</script>

<script id=\"form_template_field_date\" type=\"text/x-handlebars-template\">
  {{> _settings_required }}
  {{> _settings_date_type }}
</script>
";
    }

    public function getTemplateName()
    {
        return "form/custom_fields_legacy.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 71,  122 => 69,  117 => 66,  115 => 63,  112 => 62,  110 => 60,  107 => 59,  105 => 55,  102 => 54,  100 => 50,  97 => 49,  95 => 48,  91 => 46,  89 => 43,  86 => 42,  84 => 39,  81 => 38,  79 => 35,  76 => 34,  74 => 31,  71 => 30,  69 => 27,  66 => 26,  64 => 23,  61 => 22,  59 => 19,  54 => 17,  48 => 14,  45 => 13,  43 => 10,  40 => 9,  38 => 6,  35 => 5,  33 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/custom_fields_legacy.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/custom_fields_legacy.html");
    }
}
