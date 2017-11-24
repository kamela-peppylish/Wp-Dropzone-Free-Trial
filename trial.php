<?php 
/**
 * Plugin Name: ImageEditing Free Trial
 * Plugin URI: https://github.com/kamela-peppylish/drop-trial/new/master
 * Description: This plugin adds a free trial form which allows user to upload images and submit to try services provided. The image uploading and handling is done using Uploadcare. Enjoy this plugin! 
 * Version: 2.0.0
 * Author: Kamela Chowdhury
 * Author URI: metrodesk.com.bd
 * License: GPL2
 */

// Start plugin function
function trial_form(){
?>

<script src="<?php echo plugin_dir_url(__FILE__);?>/dropzone.min.js" type="text/javascript" defer></script>
<script type="text/javascript">
var $ = jQuery.noConflict();
$('#submit').attr('disabled', true);
// Step: 1 configure the dropzone to show uploader
$(function(){
	  Dropzone.autoDiscover = false;
      var dropzone = new Dropzone ("#myAwesomeDropzone", { // Dropzone configuration
		maxFiles: 3,
		paramName: "file",
		url: '<?php echo plugin_dir_url(__FILE__);?>/upload.php',
		maxFilesize: 5000,
      	previewsContainer: '#dropzonePreview',
      	dictDefaultMessage: "CHOOSE 3 FILES",
        autoProcessQueue: true,
        addRemoveLinks: true // Don't show remove links on dropzone itself.
      });
	  dropzone.on("maxfilesexceeded", function(file) { this.removeFile(file); }); // Remove any files more than MaxFile
// Step 2: once user select file  hide the uploader
      dropzone.on("addedfile", function(file){
        	$('.dz-default').css({ display: "none" }); 
	});
// Step 3: Upload the files in given address and display full form
      dropzone.on("queuecomplete", function (file) {
            $('.form-show').css({ display: "block" });  
		$('.form-head').css({ display: "none" });
		$('.dz-default').css({ display: "none" }); 
        });
});      
</script>
<style type="text/css">
  .trial-block{
    width: 670px;
    height: auto;
    background: #fff;
    border: 2px solid rgba(203, 192, 192, 0.50);
    margin: 0 auto;
    padding: 60px;
    position: absolute;
    left: 0;
    right: 0;
    max-height: 100%;
    max-height: 100vh;
    overflow: auto;
    box-shadow: 0px 28px 73.72px 17.28px rgba(0, 0, 0, 0.10);
}
    .form-title{font-size: 62px;color: #000;text-align: center;}
    .dropzone {
    min-height: auto !important;
    border: 0 !important;
    background: white !important;
    padding: 20px 20px !important;
}
.dz-default{
   width: 295px;
    height: 75px;
    background: #f9ba06;
    color: #000000;
    font-size: 20px;
    text-align: center !important;
    border: 1px solid rgba(0, 0, 0, 0.05);
    font-weight: bold;
    text-transform: capitalize;
    padding: 24px 10px;
}
.form-show{display: none;}
.dz-preview ~ .form-show{
   display:block;
   padding: 0
}
.dropzone .dz-message {
    margin: 20px auto !important;
    margin-bottom: 0 !important;}
.form-txt{text-align: center;color: #000;font-size: 18px;}
@media only screen and (max-width : 767px){
.trial-block {
    width: 70%;
    padding: 20px;
}
.dz-default{
	    width: 100%;
}
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__);?>/dropzone.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__);?>/trial-styles.css">
<?php
$token = uniqid();
$output .='<div class="trial-block">  
<div class="form-body"><div class="trial-form">
<h1 class="form-title">Try Us Free</h1>
<p class="form-txt form-head">Let&apos;s upload maximum <strong> 3 images/files </strong>here to submit the trial.  </p>
<form id="myAwesomeDropzone" action="'.plugin_dir_url(__FILE__).'upload.php'.'" class="dropzone" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="'.uniqid().'">
<input type="hidden" value="" id="Files" name="Files" />
<ul class="form-show">
<p class="form-txt">Fill this form and submit to complete your Free Trial.</p>
<li class="trial-form-item">
<label class="trial-form-lbl" for="fname">Full Name <span class="trial-must">*</span></label>
<input type="text" name="fname" id="fname" class="trial-form-input" required>
</li>
</li>
<li class="trial-form-item">
<label class="trial-form-lbl" for="email">Email <span class="trial-must">*</span></label>
<input type="email" name="email" id="email" class="trial-form-input" required>
</li>
<li class="trial-form-item">
<label class="trial-form-lbl" for="phone">Telephone <span class="trial-must">*</span></label>
<input type="tel" name="phone" id="telephone" class="trial-form-input" required>
</li>
<div class="clear"></div>
<li class="trial-form-item trial-form-item-full">
<label class="trial-form-lbl" for="description">Brief Instruction <span class="trial-must">*</span></label>
<textarea id="description" name="description" class="trial-form-txtbox trial-form-input" required></textarea>
</li>
<div class="dropzone-previews"></div>

<div class="fallback">
    <input name="file" type="file" />
  </div>
<li>
<input type="submit" id="submit" class="submit-trial" value="Send My Free Trial Order">
<p>By submitting this Free Trial you agree to our <a href="https://imageediting.com/terms-and-conditions/" target="_blank"><span class="theme-txt-color">Terms</span></a> and <a href="https://imageediting.com/privacy-policy/" target="_blank"><span class="theme-txt-color">Privacy Policy.</span> </a> </p>
</li>
</ul>
    <div id="dropzonePreview"></div>

    </form>
</div></div>
</div>';
return $output;
}
add_shortcode('trial_form', 'trial_form');
?>
