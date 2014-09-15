<?php if (!defined('APPLICATION')) exit();
 
class KeypicSigninModule extends Gdn_Module {
 
  public function AssetTarget() {
    return 'Content';
  }
  public function ToString() {
		echo Keypic::getIt(C('Plugins.Keypic.SigninRequestType'), C('Plugins.Keypic.SigninWidthHeight'));
  }
}