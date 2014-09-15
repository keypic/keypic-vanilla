<?php if (!defined('APPLICATION')) exit();
 
class KeypicCommentModule extends Gdn_Module {
 
  public function AssetTarget() {
    return 'Content';
  }
  public function ToString() {
		echo Keypic::getIt(C('Plugins.Keypic.CommentRequestType'), C('Plugins.Keypic.CommentWidthHeight'));
  }
}