<?php if (!defined('APPLICATION')) exit();
?>
<style type="text/css">
.Configuration {
   margin: 0 20px 20px;
   background: #f5f5f5;
   border: 1px solid #D5D2D2;
}
.ConfigurationForm {
   padding: 20px;
}
#Content form .ConfigurationForm ul {
   padding: 0;
}
#Content form .ConfigurationForm input.Button {
   margin: 0;
}
input.CopyInput {
   font-family: monospace;
   color: #000;
   width: 240px;
   font-size: 12px;
   padding: 4px 3px;
}

ol{
list-style: decimal;
margin: 20px 50px;
}

.ConfigurationForm li span{
display: inline;
}

.Errors li a {
color: #55F509;
}

</style>
<h1><?php echo $this->Data('Title'); ?></h1>
<?php
echo $this->Form->Open();
echo $this->Form->Errors();
?>
<div class="Info">
	<p>
		<a href="http://www.keypic.com/" target="_blank"><img width="143" height="59" src="http://keypic.com/img/logo.png" alt="Keypic"></a>
	</p>
	<p>
		For many people, <a href="http://www.keypic.com/" target="_blank">Keypic</a> is quite possibly the best way in the world to protect your blog from comment and trackback spam. It keeps your site protected from spam even while you sleep. To get started:
	</p>
	<ol>
		<li>Click the "Activate" link to the left of this description</li>
		<li><a href="http://www.keypic.com/?action=register" target="_blank">Sign up for a FormID</a>, and </li>
		<li>Go to your Keypic configuration page, and save FormID key.</li>
	</ol>
	
	<div class="Errors">
		<?php if ($this->Data('FormID') == ''){ ?>
			<ul>
				<li>Your FormID is empty, This plugin does not work without FormID, please <a href="http://keypic.com/?action=register" target="_blank">Get your FormID</a>.</li>
			</ul>
		<?php } ?>
	</div>
</div>

<div class="Configuration">
	<div class="ConfigurationForm">
		  <ul>
			 <li>
				<?php
				   echo $this->Form->Label('Form ID', 'FormID');
				   echo $this->Form->TextBox('FormID');
				?>
				<span><a href="http://keypic.com/?action=register" target="_blank">Get Registered</a> or if you are just logged in <a href="http://keypic.com/?action=forms" target="_blank">Create a new FormID</a></span>
			 </li>
		  </ul>
		   <?php echo $this->Form->Button('Update FormID', array('class' => 'Button SliceSubmit')); ?>
	 </div>
</div>

 <div class="Configuration">
   <div class="ConfigurationForm">	  
	  <h2>SignIn Form Settings</h2>
	  <ul>
		<li>
			<?php
               echo $this->Form->Label('Enabled', 'SigninEnabled');
               echo $this->Form->CheckBox('SigninEnabled');
            ?>
		</li>
		<li>
			<?php
               echo $this->Form->Label('Width Height', 'SigninWidthHeight');
			   echo $this->Form->DropDown('SigninWidthHeight', $this->Data('WidthHeight'));
			 ?>
		</li>
		<li>
			<?php
               echo $this->Form->Label('RequestType', 'SigninRequestType');
			   echo $this->Form->DropDown('SigninRequestType', $this->Data('RequestType'));
			 ?>
		</li>
	  </ul>
	  
      <?php echo $this->Form->Button('Save', array('class' => 'Button SliceSubmit')); ?>
   </div>
</div>


 <div class="Configuration">
   <div class="ConfigurationForm">	  
	  <h2>SignUp Form Settings</h2>
	  <ul>
		<li>
			<?php
               echo $this->Form->Label('Enabled', 'SignupEnabled');
               echo $this->Form->CheckBox('SignupEnabled');
            ?>
		</li>
		<li>
			<?php
               echo $this->Form->Label('Width Height', 'SignupWidthHeight');
			   echo $this->Form->DropDown('SignupWidthHeight', $this->Data('WidthHeight'));
			 ?>
		</li>
		<li>
			<?php
               echo $this->Form->Label('RequestType', 'SignupRequestType');
			   echo $this->Form->DropDown('SignupRequestType', $this->Data('RequestType'));
			 ?>
		</li>
	  </ul>
	  
      <?php echo $this->Form->Button('Save', array('class' => 'Button SliceSubmit')); ?>
   </div>
</div>
<?php 
   echo $this->Form->Close(); ?>