<?php 
// Plugin Name: Wp Dropzone Free Trial
// Start plugin function
function trial_form(){
?>
<script src="dropzone.min.js" type="text/javascript" defer></script>
<script type="text/javascript">
var $ = jQuery.noConflict();
// Step: 1 configure the dropzone to show uploader
$(function(){
	Dropzone.autoDiscover = false;
      var dropzone = new Dropzone ("#myAwesomeDropzone", { // Dropzone configuration
	maxFiles: 3,
        paramName: "file",
        url: '<?php echo plugin_dir_url(__FILE__);?>upload.php',
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
    // Step 3: Upload the files in given address and display full form. Dropzone disabled to provent further uploads.
    dropzone.on("queuecomplete", function (file) {
        $('.form-show').css({ display: "block" });  
		$('.form-head').css({ display: "none" });
		$('.dz-default').css({ display: "none" }); 
		dropzone.disable();
    });
    // Step 4: Append the filename in hidden input to send with form data
    dropzone.on("success", function(file,response) {
        file.myCustomName = file.name;
        console.log(file.myCustomName);
        $("#myAwesomeDropzone").append($('<input type="hidden" ' +'name="files[]" ' +'value="' + file.myCustomName+ '">'));
    });
}); 
</script>
<style type="text/css">
.form-show{display: none;}
.sec-trial{
    position: absolute;
    left: 0;
    right: 0;
    width: 570px;
    max-height: 100%;
    max-height: 100vh;
    height: auto;
    overflow: auto;
    margin: 0 auto;
    padding: 60px;
    background: #fff;
}
.form-title{font-size: 62px;color: #000;text-align: center;}
.dropzone {
    min-height: auto !important;
    border: 0 !important;
    background: white !important;
    padding: 20px 20px !important;
}
.form-txt{text-align: center;color: #000;font-size: 18px;}
@media only screen and (max-width : 767px){
.sec-trial {
    width: 70%;
    padding: 20px;
    }
.dz-default{ width: 100%;}
}
</style>
<link rel="stylesheet" type="text/css" href="dropzone.min.css">
<link rel="stylesheet" type="text/css" href="trial-styles.css">
<?php
$token = uniqid();
$output = null;
$output .='<div class="sec-trial">  
<div class="form-body"><div class="trial-form">
<h1 class="form-title">Try Us Free</h1>
<p class="form-txt form-head">Upload maximum <strong> 3 images/files </strong> here.  </p>
<form id="myAwesomeDropzone" action="'.plugin_dir_url(__FILE__).'mailer.php'.'" class="dropzone" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="'.$token.'">
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
<textarea id="description" name="description" class="trial-form-txtbox trial-form-input" pattern="[a-zA-Z0-9-]" required></textarea>
</li>
<div class="dropzone-previews"></div>
<div class="fallback"><input name="file" type="file" /></div>
<li>
<input type="submit" id="submit" class="submit-trial" value="Send My Free Trial Order">
<p>By submitting this Free Trial you agree to our <a href="https://imageediting.com/terms-and-conditions/" target="_blank"><span class="theme-txt-color">Terms</span></a> and <a href="https://imageediting.com/privacy-policy/" target="_blank"><span class="theme-txt-color">Privacy Policy.</span> </a> </p>
</li>
</ul>
<div id="dropzonePreview"></div>
</form></div></div></div>';
return $output;
}
add_shortcode('trial_form', 'trial_form');
?>
