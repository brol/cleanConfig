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

dcCore::app()->menu[dcAdmin::MENU_SYSTEM]->addItem(
    __('clean:config'),
    dcCore::app()->adminurl->get('admin.plugin.cleanConfig'),
    dcPage::getPF('cleanConfig/icon.png'),
    preg_match('/' . preg_quote(dcCore::app()->adminurl->get('admin.plugin.cleanConfig')) . '(&.*)?$/', $_SERVER['REQUEST_URI']),
    dcCore::app()->auth->isSuperAdmin()
);

dcCore::app()->addBehavior('adminDashboardFavoritesV2', ['cleanConfigDashboard','dashboardFavs']);

class cleanConfigDashboard
{
    public static function dashboardFavs($favs)
    {
        $favs->register('cleanConfig', [
            'title'       => __('Error Logger'),
            'url'         => dcCore::app()->adminurl->get('admin.plugin.cleanConfig'),
            'small-icon'  => dcPage::getPF('cleanConfig/icon.png'),
            'large-icon'  => dcPage::getPF('cleanConfig/icon-big.png'),
            'permissions' => dcCore::app()->auth->makePermissions([
                dcAuth::PERMISSION_ADMIN,
            ]),
        ]);
    }
}
