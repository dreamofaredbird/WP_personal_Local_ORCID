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

/* dynamicSegments.html */
class __TwigTemplate_a79fbfbcedf201f83ee96a2faeed0ca4dcff6d0867f1e3e2a07a1eac8c654dd3 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "dynamicSegments.html", 1);
        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "  <div id=\"dynamic_segments_container\"></div>

  <script type=\"text/javascript\">
    var mailpoet_listing_per_page = ";
        // line 7
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["items_per_page"] ?? null), "html", null, true);
        echo ";
    var wordpress_editable_roles_list = ";
        // line 8
        echo json_encode(($context["wordpress_editable_roles_list"] ?? null));
        echo ";
    var mailpoet_newsletters_list = ";
        // line 9
        echo json_encode(($context["newsletters_list"] ?? null));
        echo ";
    var mailpoet_product_categories = ";
        // line 10
        echo json_encode(($context["product_categories"] ?? null));
        echo ";
    mailpoet_product_categories = mailpoet_product_categories.map(function(category) {
      category.id = category.cat_ID;
      return category;
    });
    var mailpoet_products = ";
        // line 15
        echo json_encode(($context["products"] ?? null));
        echo ";
    mailpoet_products = mailpoet_products.map(function(product) {
      product.id = product.ID;
      return product;
    });
    var is_woocommerce_active = ";
        // line 20
        echo json_encode(($context["is_woocommerce_active"] ?? null));
        echo ";
    var mailpoet_beacon_articles = ['5a574bd92c7d3a194368233e'];
  </script>
";
    }

    // line 25
    public function block_translations($context, array $blocks = [])
    {
        // line 26
        echo "  ";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["pageTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Segments"), "formPageTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Segment"), "formSegmentTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Segment"), "new" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Add New"), "backToList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Back"), "name" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Name"), "description" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Description"), "descriptionTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This text box is for your own use and is never shown to your subscribers."), "segmentUpdated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Segment successfully updated!"), "segmentAdded" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Segment successfully added!"), "save" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Save"), "segmentType" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Type"), "wpUserRole" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("WordPress user roles"), "email" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email"), "nameColumn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Name"), "subscribersCountColumn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Number of subscribers"), "updatedAtColumn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Modified on"), "loadingDynamicSegmentItems" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Loading data…"), "noDynamicSegmentItemsFound" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No segments found"), "numberOfItemsSingular" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 item"), "numberOfItemsMultiple" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d items"), "previousPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Previous page"), "firstPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("First page"), "nextPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Next page"), "lastPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Last page"), "currentPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Current page"), "pageOutOf" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("of", "Page X of Y"), "edit" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Edit"), "viewSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("View Subscribers"), "notSentYet" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Not sent yet"), "selectLinkPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select link"), "selectNewsletterPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select email"), "selectActionPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select action"), "selectUserRolePlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select user role"), "emailActionOpened" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("opened", "Dynamic segment creation: when newsletter was opened"), "emailActionNotOpened" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("not opened", "Dynamic segment creation: when newsletter was not opened"), "emailActionClicked" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("clicked", "Dynamic segment creation: when a newsletter link was clicked"), "emailActionNotClicked" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("not clicked", "Dynamic segment creation: when a newsletter link was not clicked"), "searchLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Search"), "segmentsTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Tip", "A note about dynamic segments usage"), "segmentsTipText" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("segments allow you to group your subscribers by other criteria, such as events and actions."), "segmentsTipLink" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read more."), "oneSegmentTrashed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 segment was moved to the trash."), "multipleSegmentsTrashed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d segments were moved to the trash."), "oneSegmentRestored" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 segment has been restored from the Trash."), "multipleSegmentsRestored" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d segments have been restored from the Trash."), "trash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Trash"), "moveToTrash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Move to trash"), "emptyTrash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Empty Trash"), "restore" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Restore"), "deletePermanently" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Delete permanently"), "oneSegmentDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 segment was permanently deleted."), "multipleSegmentsDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d segments were permanently deleted."), "permanentlyDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%d segments were permanently deleted."), "wooPurchasedCategory" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Customers who have purchased in this category…"), "wooPurchasedProduct" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Customers who have purchased this product…"), "selectWooPurchasedCategory" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Search category"), "selectWooPurchasedProduct" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Search products"), "woocommerce" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("WooCommerce", "Dynamic segment creation: User selects this to use any woocommerce filters")]);
        // line 87
        echo "
";
    }

    public function getTemplateName()
    {
        return "dynamicSegments.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 87,  87 => 26,  84 => 25,  76 => 20,  68 => 15,  60 => 10,  56 => 9,  52 => 8,  48 => 7,  43 => 4,  40 => 3,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "dynamicSegments.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/dynamicSegments.html");
    }
}
