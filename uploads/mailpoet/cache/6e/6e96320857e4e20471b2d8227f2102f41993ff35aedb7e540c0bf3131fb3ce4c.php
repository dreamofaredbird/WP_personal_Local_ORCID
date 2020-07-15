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

/* form/templatesLegacy/settings/field_form.hbs */
class __TwigTemplate_442cced81b1329f8dca76502dcb6720a087016ca7103259cad528fbd7f704189 extends \MailPoetVendor\Twig\Template
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
        echo "
<form
  id=\"form_field_new\"
  name=\"form_field_new\"
  action=\"\"
  method=\"post\"
  data-parsley-validate=\"true\"
>
  {{#if id}}<input type=\"hidden\" id=\"field_id\" name=\"id\" value=\"{{ id }}\" />{{/if}}
  <p>
    <label for=\"field_type\">";
        // line 11
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select a field type:");
        echo "</label>
    <select
      id=\"field_type\"
      name=\"type\"
      data-parsley-required=\"true\"
      data-parsley-required-message=\"";
        // line 16
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please specify a type.");
        echo "\"
    >
      <option value=\"\">--</option>
      <option
        {{#ifCond type '==' 'text'}}selected=\"selected\"{{/ifCond}}
        value=\"text\">";
        // line 21
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Text Input");
        echo "
      </option>
      <option
        {{#ifCond type '==' 'textarea'}}selected=\"selected\"{{/ifCond}}
        value=\"textarea\">";
        // line 25
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Text Area");
        echo "
      </option>
      <option
        {{#ifCond type '==' 'radio'}}selected=\"selected\"{{/ifCond}}
        value=\"radio\">";
        // line 29
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Radio buttons");
        echo "
      </option>
      <option
        {{#ifCond type '==' 'checkbox'}}selected=\"selected\"{{/ifCond}}
        value=\"checkbox\">";
        // line 33
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Checkbox");
        echo "
      </option>
      <option
        {{#ifCond type '==' 'select'}}selected=\"selected\"{{/ifCond}}
        value=\"select\">";
        // line 37
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Select", "Form input type");
        echo "
      </option>
      <option
        {{#ifCond type '==' 'date'}}selected=\"selected\"{{/ifCond}}
        value=\"date\">";
        // line 41
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Date");
        echo "
      </option>
    </select>
  </p>
  <p>
    <label for=\"field_name\">";
        // line 46
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Field name:");
        echo "</label>
    <input
      id=\"field_name\"
      type=\"text\"
      name=\"name\"
      value=\"{{ name }}\"
      data-parsley-required=\"true\"
      data-parsley-required-message=\"";
        // line 53
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please specify a name.");
        echo "\"
    />
  </p>
  <hr />

  <div class=\"field_type_form\"></div>

  <p class=\"mailpoet_align_right\">
    <input type=\"submit\" value=\"";
        // line 61
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Done");
        echo "\" class=\"button-primary\" />
  </p>
</form>

<script type=\"text/javascript\">
  jQuery(function(\$) {

    \$(function() {
      loadFieldForm();

      \$('#form_field_new').parsley().on('form:submit', function(parsley) {
        // get data
        var data = \$(this.\$element).mailpoetSerializeObject();

        // save custom field
        MailPoet.Ajax.post({
          api_version: window.mailpoet_api_version,
          endpoint: 'customFields',
          action: 'save',
          data: data
        }).done(function(response) {
          // close popup
          MailPoet.Modal.close();

          MailPoet.trackEvent('Forms > Add new custom field', {
            'Field type': data.type,
            'MailPoet Free version': window.mailpoet_version
          });

          if(WysijaForm.updateBlock(response.data) === true) {
            // trigger save, if a block has been updated
            mailpoet_form_save(false);
          }

          mailpoet_form_fields();

          if(data.id) {
            MailPoet.Notice.success(
              \"";
        // line 99
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("Updated custom field %\$1s"), "js"), "html", null, true);
        echo "\".replace('%\$1s', '\"' + encodeHtmlValue(data.name) + '\"')
            );
          } else {
            MailPoet.Notice.success(
              \"";
        // line 103
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_escape_filter($this->env, $this->env->getExtension('MailPoet\Twig\I18n')->translate("Added custom field %\$1s"), "js"), "html", null, true);
        echo "\".replace('%\$1s', '\"' + encodeHtmlValue(data.name) + '\"')
            );
          }
        }).fail(function(response) {
          if(response.errors.length > 0) {
            MailPoet.Notice.error(
              response.errors.map(function(error) { return error.message; }),
              { positionAfter: '#field_name' }
            );
          }
        });
        return false;
      });
    });

    \$('#form_field_new #field_type').on('change', function() {
      loadFieldForm(\$(this).val());
    });

    function loadFieldForm(type) {
      type = (type === undefined) ? \$('#form_field_new #field_type').val() : type;
      if(type !== '') {
        var template = Handlebars.compile(\$('#form_template_field_'+type).html()),
            data = {type: type},
            field_id = \$('#form_field_new #field_id').val();

        if(field_id !== undefined && field_id.length > 0) {
          var params = \$('.mailpoet_form_field[wysija_id=\"'+field_id+'\"]').attr('wysija_params');
          if(params !== undefined) {
            data.params = JSON.parse(params);
          }
        }
        // render field template
        \$('#form_field_new .field_type_form').html(template(data));
      } else {
        \$('#form_field_new .field_type_form').html('');
      }
    }
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/settings/field_form.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  170 => 103,  163 => 99,  122 => 61,  111 => 53,  101 => 46,  93 => 41,  86 => 37,  79 => 33,  72 => 29,  65 => 25,  58 => 21,  50 => 16,  42 => 11,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/settings/field_form.hbs", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/form/templatesLegacy/settings/field_form.hbs");
    }
}
