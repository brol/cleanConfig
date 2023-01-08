<?php 
# ***** BEGIN LICENSE BLOCK *****
#
# This file is part of clean:config, a plugin for Dotclear 2
# Copyright (C) 2007-2016 Moe (http://gniark.net/)
#
# clean:config is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License v2.0
# as published by the Free Software Foundation.
#
# clean:config is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public
# License along with this program. If not, see
# <http://www.gnu.org/licenses/>.
#
# Icon (icon.png) and images are from Silk Icons :
# <http://www.famfamfam.com/lab/icons/silk/>
#
# ***** END LICENSE BLOCK *****

if (!defined('DC_CONTEXT_ADMIN')) {exit;}

dcCore::app()->menu[dcAdmin::MENU_SYSTEM]->addItem(
    __('clean:config'),
    dcCore::app()->adminurl->get('admin.plugin.cleanConfig'),
    dcPage::getPF('cleanConfig/icon.png'),
    preg_match('/' . preg_quote(dcCore::app()->adminurl->get('admin.plugin.cleanConfig')) . '(&.*)?$/', $_SERVER['REQUEST_URI']),
    dcCore::app()->auth->isSuperAdmin()
);

dcCore::app()->addBehavior('adminDashboardFavoritesV2', ['errorloggerDashboard','dashboardFavs']);

class errorloggerDashboard
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
