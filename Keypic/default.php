<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

// Define the plugin:
$PluginInfo['Keypic'] = array(
	'Name' => 'Keypic',
   'Description' => 'For many people, Keypic is quite possibly the best way in the world to protect your forum from comment and trackback spam. It keeps your site protected from spam even while you sleep.',
   'Version' => '0.0.0.1',
   'RequiredApplications' => array('Vanilla' => '>=2'),
   'RequiredTheme' => FALSE,
   'RequiredPlugins' => FALSE,
   'MobileFriendly' => TRUE,
   'SettingsUrl' => '/dashboard/settings/keypic',
   'SettingsPermission' => 'Garden.Settings.Manage',
   'HasLocale' => TRUE,
   'RegisterPermissions' => FALSE,
   'Author' => "Keypic",
   'AuthorEmail' => 'info@keypic.com',
   'AuthorUrl' => 'http://www.keypic.com/'
);

class KeypicPlugin extends Gdn_Plugin {

   // Run on install
   public function Setup() {
      $Error = '';
      if (!function_exists('curl_init'))
         $Error = ConcatSep("\n", $Error, 'This plugin requires curl.');
      if ($Error)
         throw new Gdn_UserException($Error, 400);
   }
   
   // Run on disable
   public function OnDisable() {
   }
   
   public function Base_Form_Close_Before($Sender, $Args) {
	echo 'sfsdfsfsdfsjbsf';
   }
}