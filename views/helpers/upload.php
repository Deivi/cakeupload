<?php
class UploadHelper extends AppHelper {

	var $helpers = array('Html');

	/**
	 * Shows upload button, including necesary scripts
	 * 
	 * @ $label   string, label of button
	 * @ $group   array with all types of variable, group of variable
	 * @ $div_id  string, div id to duplicate the buttons
	 * @ $folder  string
	 */
	function button($label 'button', $group = null, $div_id = 'cakeupload-uploader' $folder = 'files') {
		echo $this->Html->css('/cakeupload/css/fileuploader.css', null, array('inline' => false));
		echo $this->Html->script('/cakeupload/js/fileuploader.js', array('inline' => false, 'once' => true));
		echo "<div id='".$div_id."'>";
		echo "<noscript>";
		echo "<p>Please enable JavaScript to use file uploader.</p>";
		echo "<!-- or put a simple form for upload here -->";
		echo "</noscript>";
		echo "</div>";
		$id = uniqid();
		ob_start();
		?>

		function addOnloadEvent(fnc){
		  if ( typeof window.addEventListener != "undefined" )
		    window.addEventListener( "load", fnc, false );
		  else if ( typeof window.attachEvent != "undefined" ) {
		    window.attachEvent( "onload", fnc );
		  }
		  else {
		    if ( window.onload != null ) {
		      var oldOnload = window.onload;
		      window.onload = function ( e ) {
		        oldOnload( e );
		        window[fnc]();
	 	      };
		    }
		    else
		      window.onload = fnc;
		    }
		}
	
	        function createUploader<?php echo $id ?>(){            
	            var uploader = new qq.FileUploader({
	                element: document.getElementById('<?php echo $div_id; ?>'),
	                action: '<?php echo $this->Html->url(array('plugin' => 'cakeupload', 'controller' => 'cakeupload_files', 'action' => 'upload')); ?>',
	                params: { group: '<?php echo $group; ?>'},
	                debug: true
	            }, '<?php echo $label; ?>');           
	        }
	        
	        // in your app create uploader as soon as the DOM is ready
	        // don't wait for the window to load  
	        addOnloadEvent(createUploader<?php echo $id; ?>);    


		<?php
		$jscript = ob_get_contents(); //return output buffer to variable
		ob_end_clean(); //must clean buffer or javascript above will print TWICE (one inline, one in header)
		echo $this->Html->scriptBlock($jscript, array('inline' => false));
			
	}
}
?>