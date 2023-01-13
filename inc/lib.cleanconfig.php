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
if (!defined('DC_RC_PATH')) {return;}

class cleanconfig
{
	public static function delete($namespace,$setting,$limit)
	{
		$set =& dcCore::app()->blog->settings;

		if ($limit == 'blog')
		{
			$set->{$namespace}->drop($setting);
		}
		elseif ($limit == 'global')
		{
			# inspired by drop() function in /dotclear/inc/core/class.dc.settings.php
			$strReq = 'DELETE FROM '.dcCore::app()->prefix.'setting'.' ';
			$strReq .= 'WHERE blog_id IS NULL ';
			$strReq .= "AND setting_id = '".dcCore::app()->con->escape($setting)."' ";
	
			dcCore::app()->con->execute($strReq);
		}
		else
		{
			throw new Exception('no limit');
		}
	}

	public static function settings($limit)
	{
		$set =& dcCore::app()->blog->settings;

		$str = '<p>'.__('Use carefully. Only settings related to plugins can be deleted.').'</p>'."\n";
		$str .= '<form method="post" action="'.http::getSelfURI().'">'."\n";
		$table = new table('class="clear" summary="'.__('Settings').'"');
		$table->part('head');
		$table->row();
		$table->header(__('Setting'),'colspan="2"');
		$table->header(__('Value'),'class="nowrap"');
		$table->header(__('Type'),'class="nowrap"');
		$table->header(__('Description'),'class="maximal"');
		
		$table->part('body');
		
		$namespaces = $set->dumpNamespaces();
		
		# number of settings
		$i = 0;
		
		# Parse all the namespaces
		foreach (array_keys($namespaces) as $null => $ns)
		{
			# only settings related to plugins
			if (($ns == 'system') OR ($ns == 'widgets')) {continue;}
			
			# limit to blog
			if ($limit == 'blog')
			{
				$dump = $set->{$ns}->dumpSettings();
			}
			# global
			else
			{
				$dump = $set->{$ns}->dumpGlobalSettings();
			}
			
			# echo namespace
			$echo_ns = false;
			
			foreach ($dump as $name => $v)
			{
				# hide global settings on blog settings
				if ((($limit == 'global') AND ($v['global']))
					OR (($limit == 'blog') AND (!$v['global'])))
				{
					# echo namespace 
					if (!$echo_ns)
					{
						$table->row();
						$table->cell(__('namespace:').
							' <strong>'.$v['ns'].'</strong>',
							'class="ns-name" colspan="5"');
						$echo_ns = true;
					}
					
					$id = html::escapeHTML($v['ns'].'|'.$name);
					$table->row('class="line"');
					$table->cell(form::checkbox(array('settings[]',$id),
						$id,false,$v['ns']));
					$table->cell('<label for="'.$id.'">'.$name.'</label>');
					# boolean
					if (($v['type']) == 'boolean')
					{
						$value = ($v['value']) ? 'true' : 'false';
					}
					# other types
					else
					{
						$value = form::field(html::escapeHTML($ns.'_field'),40,
							null,html::escapeHTML(($v['type'] == 'array' ? json_encode($v['value']) : $v['value'])),
							);
					}
					$table->cell($value);
					$table->cell($v['type']);
					$table->cell($v['label'],'class="maximal"');
					
					$i++;
				}
			}
		}
		# nothing to display
		if ($i == 0)
		{
			return('<p><strong>'.__('No setting.').'</strong></p>');
		}

		$str.= $table->get();

		if ($i > 0)
		{
			$str .= ('<p class="checkboxes-helpers"></p>'.
			'<p>'.form::hidden(array('limit',$limit),$limit).
			'<p>'.dcCore::app()->formNonce().'</p>'.
			'<input type="submit" name="delete" value="'.
				__('Delete selected settings').'" /></p>');
		}
		$str .= '</form>'."\n";

		return($str);
	}
}