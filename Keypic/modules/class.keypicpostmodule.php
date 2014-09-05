<?php if (!defined('APPLICATION')) exit();
 
class KeypicPostModule extends Gdn_Module {
 
  public function AssetTarget() {
    return 'Foot';
  }
  public function ToString() {
		echo Keypic::getIt(C('Plugins.Keypic.PostRequestType'), C('Plugins.Keypic.PostWidthHeight'));
  }
}