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

/* segments.html */
class __TwigTemplate_3d5b24882aa47d6762640bb1771dab4b3dcac73ea95692f4839c80e91b206556 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("layout.html", "segments.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "  <div id=\"segments_container\"></div>

  <script type=\"text/javascript\">
    var mailpoet_listing_per_page = ";
        // line 7
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["items_per_page"] ?? null), "html", null, true);
        echo ";
    var mailpoet_beacon_articles = [
      '5d92153a2c7d3a7e9ae1caaa',
      '57f47ca3c697914f21035256',
      '5d4beee42c7d3a330e3c4207',
    ];
  </script>
";
    }

    // line 16
    public function block_translations($context, array $blocks = [])
    {
        // line 17
        echo "  ";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["pageTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Lists"), "searchLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Search"), "loadingItems" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Loading lists..."), "noItemsFound" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No lists found"), "selectAllLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("All lists on this page are selected."), "selectedAllLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("All %d lists are selected."), "selectAllLink" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select all lists on all pages"), "clearSelection" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Clear selection"), "permanentlyDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%d lists were permanently deleted."), "selectBulkAction" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select bulk action"), "bulkActions" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Bulk Actions"), "apply" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Apply"), "name" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Name"), "description" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Description"), "segmentUpdated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("List successfully updated!"), "segmentAdded" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("List successfully added!"), "segment" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("List"), "subscribed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscribed"), "unconfirmed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Unconfirmed"), "unsubscribed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Unsubscribed"), "inactive" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Inactive"), "bounced" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Bounced"), "createdOn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Created on"), "oneSegmentTrashed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 list was moved to the trash. Note that deleting a list does not delete its subscribers."), "multipleSegmentsTrashed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d lists were moved to the trash. Note that deleting a list does not delete its subscribers."), "oneSegmentDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 list was permanently deleted. Note that deleting a list does not delete its subscribers."), "multipleSegmentsDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d lists were permanently deleted. Note that deleting a list does not delete its subscribers."), "oneSegmentRestored" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 list has been restored from the Trash."), "multipleSegmentsRestored" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d lists have been restored from the Trash."), "duplicate" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Duplicate"), "listDuplicated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("List \"%\$1s\" has been duplicated."), "update" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Update"), "forceSync" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Force Sync"), "readMore" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read More"), "listSynchronized" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("List \"%\$1s\" has been synchronized."), "viewSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("View Subscribers"), "new" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Add New"), "edit" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Edit"), "trash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Trash"), "moveToTrash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Move to trash"), "emptyTrash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Empty Trash"), "selectAll" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select All"), "restore" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Restore"), "deletePermanently" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Delete permanently"), "save" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Save"), "trashDisallowed" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("List cannot be deleted because it’s used for %\$1s email", "Alert shown when trying to delete segment, which is assigned to any automatic emails."), "previousPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Previous page"), "firstPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("First page"), "nextPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Next page"), "lastPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Last page"), "currentPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Current page"), "pageOutOf" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("of"), "numberOfItemsSingular" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 item"), "numberOfItemsMultiple" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d items"), "segmentDescriptionTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This text box is for your own use and is never shown to your subscribers."), "backToList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Back")]);
        // line 76
        echo "
";
    }

    public function getTemplateName()
    {
        return "segments.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 76,  63 => 17,  60 => 16,  48 => 7,  43 => 4,  40 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "segments.html", "/nas/content/live/orcidaboutdev/wp-content/plugins/mailpoet/views/segments.html");
    }
}
