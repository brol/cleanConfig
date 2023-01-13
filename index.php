<?php 
/**
 * @brief cleanConfig, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Moe, Pierre Van Glabeke and contributors
 *
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Icon (icon.png) and images are from Silk Icons :
 * <http://www.famfamfam.com/lab/icons/silk/>
 */
if (!defined('DC_CONTEXT_ADMIN')) {exit;}

l10n::set(__DIR__ . '/locales/' . dcCore::app()->lang . '/admin');

$page_title = __('clean:config');

require_once(dirname(__FILE__).'/php-xhtml-table/class.table.php');
require_once(dirname(__FILE__).'/inc/lib.cleanconfig.php');

$default_tab = 'blog_settings';

$msg = (string)'';

# actions
$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : '';

if ((isset($_POST['delete'])) AND (($limit == 'blog') OR ($limit == 'global')))
{
	if (count($_POST['settings']) == 0)
	{
		$msg = __('No setting deleted.');
		$default_tab = $limit.'_settings';
	}
	else
	{
		foreach ($_POST['settings'] as $setting)
		{
			$id = explode('|',$setting);
			cleanconfig::delete($id[0],$id[1],$limit);
		}
		$msg = '<div class="message"><p>'.
		
		http::redirect(dcCore::app()->admin->getPageURL().'&amp;settingsdeleted=1&amp;limit='.$limit);
	}
}

if (isset($_GET['settingsdeleted']))
{
	$msg = __('The selected settings have been deleted.');
	
	$default_tab = $limit.'_settings';
}

?>
<html>
<head>
  <title><?php echo $page_title; ?></title>
	<?php echo dcPage::jsPageTabs($default_tab); ?>
	<style type="text/css">
		.ns-name { background: #ccc; color: #000; padding-top: 0.3em; padding-bottom: 0.3em; font-size: 1.1em; }
	</style>
	<!-- from /dotclear/plugins/widgets -->
	<script type="text/javascript">
	//<![CDATA[
		<?php echo dcPage::jsVar('dotclear.msg.confirm_cleanconfig_delete',
		__('Are you sure you want to delete settings?')); ?>
		$(document).ready(function() {
			$('.checkboxes-helpers').each(function() {
				dotclear.checkboxesHelpers(this);
			});
			$('input[name="delete"]').click(function() {
				return window.confirm(dotclear.msg.confirm_cleanconfig_delete);
			});
			$('td[class="ns-name"]').css({ cursor:"pointer" });
			$('td[class="ns-name"]').click(function() {
				$("."+$(this).children().filter("strong").text()).toggleCheck();
				return false;
			});
		});
	//]]>
	</script>
</head>
<body>
<?php
	echo dcPage::breadcrumb(
		array(
			html::escapeHTML(dcCore::app()->blog->name) => '',
			'<span class="page-title">'.$page_title.'</span>' => ''
		));
if (!empty($msg)) {
  dcPage::success($msg);
}
?>
	
	<div class="multi-part" id="blog_settings" title="<?php echo __('Blog settings'); ?>">
		<?php echo(cleanconfig::settings('blog')); ?>
	</div>

	<div class="multi-part" id="global_settings" title="<?php echo __('Global settings'); ?>">
		<?php echo(cleanconfig::settings('global')); ?>
	</div>

	<div class="multi-part" id="versions" title="<?php echo __('Versions'); ?>">
		<p><?php printf(__('This function has been moved to the %s plugin.'),
			'<a href="http://plugins.dotaddict.org/dc2/details/versionsManager">'.
			__('Versions Manager').'</a>'); ?></p>
	</div>

</body>
</html>