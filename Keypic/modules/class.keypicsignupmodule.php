<?php if (!defined('APPLICATION')) exit();
 
class KeypicSignupModule extends Gdn_Module {
 
  public function AssetTarget() {
    return 'Foot';
  }
  public function ToString() {
		echo Keypic::getIt(C('Plugins.Keypic.SignupRequestType'), C('Plugins.Keypic.SignupWidthHeight'));
  }
}