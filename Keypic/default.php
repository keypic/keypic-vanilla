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
   'Version' => '0.0.0.2',
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

require_once('Keypic.php');

class KeypicPlugin extends Gdn_Plugin {
	
	public function __construct() {
		parent::__construct();
		Keypic::setFormID(C('Plugins.Keypic.FormID'));
		Keypic::setUserAgent("User-Agent: Vanilla/".APPLICATION_VERSION." | Keypic/".$this->GetPluginKey('Version'));
	}
	
   // Run on install
   public function Setup() {
      $Error = '';
      if (!function_exists('curl_init'))
         $Error = ConcatSep("\n", $Error, 'This plugin requires curl.');
      if ($Error)
         throw new Gdn_UserException($Error, 400);
		
	   $this->defaultSettings();
   }
   
   // Set default config values
   private function defaultSettings()
   {
		$default_config = array(
             'Plugins.Keypic.SigninEnabled' => true,
			 'Plugins.Keypic.SignupEnabled' => true,
			 'Plugins.Keypic.SigninWidthHeight' => '1x1',
			 'Plugins.Keypic.SignupWidthHeight' => '1x1',
			 'Plugins.Keypic.PostWidthHeight' => '1x1',
			 'Plugins.Keypic.CommentWidthHeight' => '1x1',
			 'Plugins.Keypic.SignupRequestType' => 'getScript',
			 'Plugins.Keypic.SigninRequestType' => 'getScript',
			 'Plugins.Keypic.PostRequestType' => 'getScript',
			 'Plugins.Keypic.CommentRequestType' => 'getScript',
		 );
		 
		SaveToConfig($default_config);
   }
 
   // Run on disable
   public function OnDisable() {
   }
  
	public function SettingsController_Keypic_Create($Sender) {
      $Sender->Permission('Garden.Settings.Manage');
      if ($Sender->Form->IsPostBack()) {
         $Settings = array(
			 'Plugins.Keypic.SigninEnabled' => $Sender->Form->GetFormValue('SigninEnabled'),
			 'Plugins.Keypic.SigninWidthHeight' => $Sender->Form->GetFormValue('SigninWidthHeight'),
			 'Plugins.Keypic.SigninRequestType' => $Sender->Form->GetFormValue('SigninRequestType'),
			 
			 'Plugins.Keypic.SignupEnabled' => $Sender->Form->GetFormValue('SignupEnabled'),
			 'Plugins.Keypic.SignupWidthHeight' => $Sender->Form->GetFormValue('SignupWidthHeight'),
			 'Plugins.Keypic.SignupRequestType' => $Sender->Form->GetFormValue('SignupRequestType'),
			 
			 'Plugins.Keypic.PostEnabled' => $Sender->Form->GetFormValue('PostEnabled'),
			 'Plugins.Keypic.PostWidthHeight' => $Sender->Form->GetFormValue('PostWidthHeight'),
			 'Plugins.Keypic.PostRequestType' => $Sender->Form->GetFormValue('PostRequestType'),
			 
			 'Plugins.Keypic.CommentEnabled' => $Sender->Form->GetFormValue('CommentEnabled'),
			 'Plugins.Keypic.CommentWidthHeight' => $Sender->Form->GetFormValue('CommentWidthHeight'),
			 'Plugins.Keypic.CommentRequestType' => $Sender->Form->GetFormValue('CommentRequestType')
		 );

		 if (strcmp(Keypic::checkFormID($Sender->Form->GetFormValue('FormID'))["status"], "response") == 0)
		 {
			$Settings = array_merge($Settings, array('Plugins.Keypic.FormID' => $Sender->Form->GetFormValue('FormID')));
		 }
		 else
			$Sender->SetData('FormIDInvalid', 'trjbsdfjsbfdfbdsjue');
		
		 if (strlen($Sender->Form->GetFormValue('FormID')) == 0)
			SaveToConfig(array('Plugins.Keypic.FormID' => ""));

         SaveToConfig($Settings);
         $Sender->InformMessage(T("Your settings have been saved."));

      } else {
	  		
			$Sender->Form->SetValue('FormID', C('Plugins.Keypic.FormID'));
			
			 // Signin
			 $Sender->Form->SetValue('SigninEnabled', C('Plugins.Keypic.SigninEnabled'));
			 $Sender->Form->SetValue('SigninWidthHeight', C('Plugins.Keypic.SigninWidthHeight'));
			 $Sender->Form->SetValue('SigninRequestType', C('Plugins.Keypic.SigninRequestType'));
			 
			 // Signup
			 $Sender->Form->SetValue('SignupEnabled', C('Plugins.Keypic.SignupEnabled'));
			 $Sender->Form->SetValue('SignupWidthHeight', C('Plugins.Keypic.SignupWidthHeight'));
			 $Sender->Form->SetValue('SignupRequestType', C('Plugins.Keypic.SignupRequestType'));
			 
			 // Create post
			 $Sender->Form->SetValue('PostEnabled', C('Plugins.Keypic.PostEnabled'));
			 $Sender->Form->SetValue('PostWidthHeight', C('Plugins.Keypic.PostWidthHeight'));
			 $Sender->Form->SetValue('PostRequestType', C('Plugins.Keypic.PostRequestType'));
			 
			 // Create comment
			 $Sender->Form->SetValue('CommentEnabled', C('Plugins.Keypic.CommentEnabled'));
			 $Sender->Form->SetValue('CommentWidthHeight', C('Plugins.Keypic.CommentWidthHeight'));
			 $Sender->Form->SetValue('CommentRequestType', C('Plugins.Keypic.CommentRequestType'));
      }

      $Sender->AddSideMenu();
      $Sender->SetData('Title', T('Keypic Settings'));
	  $Sender->SetData('FormID', C('Plugins.Keypic.FormID'));
	  $Sender->SetData('WidthHeight', array(
			"1x1" => 'Lead square transparent 1x1 pixel',
			"336x280" => 'Large rectangle (336 x 280) (Most Common)',
			"300x250" => 'Medium Rectangle (300 x 250)',
			"728x90" => 'Leaderboard (728 x 90)',
			"160x600" => 'Wide Skyscraper (160 x 600)',
			"250x250" => 'Square Pop-Up (250 x 250)',
			"720x300" => 'Pop-under (720 x 300)',
			"468x60" => 'Full Banner (468 x 60)',
			"234x60" => 'Half Banner (234 x 60)',
			"120x600" => 'Skyscraper (120 x 600)',
			"300x600" => 'Half Page Ad (300 x 600)'
		));
		
		 $Sender->SetData('RequestType', array(
			'getScript' => 'getScript'
		 ));
      $Sender->Render('settings', '', 'plugins/Keypic');
   }
   
   
   public function EntryController_SignIn_Handler($Sender, $Args) {
		if (C('Plugins.Keypic.SigninEnabled'))
		{
			if ($Sender->Form->IsPostBack())
			{
				$Token = isset($_POST['Token']) ? $_POST['Token'] : '';
				$spam = Keypic::isSpam($Token, null, $Sender->Form->GetFormValue('Email'), $ClientMessage = '', $ClientFingerprint = '');

				if(!is_numeric($spam) || $spam > Keypic::getSpamPercentage())
				{
					if(is_numeric($spam))
					{
						$error = sprintf('This request has %s&#37; of spam', $spam);
					}
					else
					{
						$error = 'We are sorry, your Keypic token is not valid';
					}
					
					$Sender->Form->AddError('<strong>SPAM</strong>: ' . $error);
				}
			}

			$Token = isset($_POST['Token']) ? $_POST['Token'] : '';
			$Sender->Form->AddHidden('Token', Keypic::getToken($Token));
			
			$mod = new KeypicSigninModule($Sender);
			$Sender->AddModule($mod);
		}
   }
   
    public function EntryController_Register_Handler($Sender, $Args) {
		if (C('Plugins.Keypic.SignupEnabled'))
		{
			if ($Sender->Form->IsPostBack())
			{
				$Token = isset($_POST['Token']) ? $_POST['Token'] : '';
				$spam = Keypic::isSpam($Token, null, $Sender->Form->GetFormValue('Email'), $ClientMessage = '', $ClientFingerprint = '');

				if(!is_numeric($spam) || $spam > Keypic::getSpamPercentage())
				{
					if(is_numeric($spam))
					{
						$error = sprintf('This request has %s&#37; of spam', $spam);
					}
					else
					{
						$error = 'We are sorry, your Keypic token is not valid';
					}
					
					$Sender->Form->AddError('<strong>SPAM</strong>: ' . $error);
				}
			}
			
			$Token = isset($_POST['Token']) ? $_POST['Token'] : '';
			$Sender->Form->AddHidden('Token', Keypic::getToken($Token));

			$mod = new KeypicSignupModule($Sender);
			$Sender->AddModule($mod);
		}
   }
   
    public function PostController_BeforeDiscussionRender_Handler($Sender, $Args) {
		if (C('Plugins.Keypic.PostEnabled'))
		{
			$Sender->Form->AddHidden('Token', Keypic::getToken($Token));

			$mod = new KeypicPostModule($Sender);
			$Sender->AddModule($mod);
		}
	}
	
	 public function DiscussionModel_BeforeSaveDiscussion_Handler($Sender) {
		if (C('Plugins.Keypic.PostEnabled'))
		{
			$Token = isset($_POST['Token']) ? $_POST['Token'] : '';
			$spam = Keypic::isSpam($Token, null, Gdn::Session()->User->Name, $ClientMessage = '', $ClientFingerprint = '');

			if(!is_numeric($spam) || $spam > Keypic::getSpamPercentage())
			{
				if(is_numeric($spam))
				{
					$error = sprintf('This request has %s&#37; of spam', $spam);
				}
				else
				{
					$error = 'We are sorry, your Keypic token is not valid';
				}
				
				$Sender->Validation->AddValidationResult('Token', '<strong>SPAM</strong>: ' . $error);
			}
		}
	}
	
	public function DiscussionController_BeforeDiscussionRender_Handler($Sender) {
		if (C('Plugins.Keypic.CommentEnabled'))
		{
			$Sender->Form->AddHidden('Token', Keypic::getToken($Token));

			$mod = new KeypicCommentModule($Sender);
			$Sender->AddModule($mod);
		}
	}
	
	 public function CommentModel_BeforeSaveComment_Handler($Sender) {
		if (C('Plugins.Keypic.CommentEnabled'))
		{
			$Token = isset($_POST['Token']) ? $_POST['Token'] : '';
			$spam = Keypic::isSpam($Token, null, Gdn::Session()->User->Name, $ClientMessage = '', $ClientFingerprint = '');

			if(!is_numeric($spam) || $spam > Keypic::getSpamPercentage())
			{
				if(is_numeric($spam))
				{
					$error = sprintf('This request has %s&#37; of spam', $spam);
				}
				else
				{
					$error = 'We are sorry, your Keypic token is not valid';
				}
				
				$Sender->Validation->AddValidationResult('Token', '<strong>SPAM</strong>: ' . $error);
			}
		}
	 }
}