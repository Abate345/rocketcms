    </div><!--/.container-->
<?
/*    
    <footer class="footer">
    	<div class="container">
	        <?php if (ENVIRONMENT == 'development') :?>
				<p style="float: right; margin-right: 80px;">Page rendered in {elapsed_time} seconds, using {memory_usage}.</p>
			<?php endif; ?>
	
			<p>Powered Proudly by <a href="http://rocketphp.com" target="_blank">RocketPHP <?php echo ROCKETPHP_VERSION ?></a></p>
		</div>
	</footer>
*/
?>	
	<?php echo theme_view('parts/modal_login'); ?>

	<div id="debug"></div>
	
	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-upload fade">
			<td class="preview"><span class="fade"></span></td>
			<td class="name"><span>{%=file.name%}</span></td>
			<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			{% if (file.error) { %}
				<td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
			{% } else if (o.files.valid && !i) { %}
				<td>
					<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
				</td>
				<td>{% if (!o.options.autoUpload) { %}
					<button class="btn btn-primary start">
						<i class="icon-upload icon-white"></i>
						<span>Start</span>
					</button>
				{% } %}</td>
			{% } else { %}
				<td colspan="2"></td>
			{% } %}
			<td>{% if (!i) { %}
				<button class="btn btn-primary btn-warning cancel">
					<i class="icon-ban-circle icon-white"></i>
					<span>Cancel</span>
				</button>
			{% } %}</td>
		</tr>
	{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-download fade">
			{% if (file.error) { %}
				<td></td>
				<td class="name"><span>{%=file.name%}</span></td>
				<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
				<td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
				<td>
					<button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
						<i class="icon-trash icon-white"></i>
						<span>Delete</span>
					</button>
				</td>
			{% } else { %}
				<td class="preview">
					<div class='thumbnail-container'>
						<a class='thumbnail' href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}">
							<img src="{%=file.thumbnail_url%}">
							<span>
								<img src="{%=file.url%}" />
							</span>
						</a>
					</div>
				</td>
				<td class="name">
					{%=file.name%} <span class='size'>({%=o.formatFileSize(file.size)%})</span>
					<div class='options'>
						<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}">Download</a> 
						or 
						<a href="{%=file.page_url%}" title="{%=file.name%}">Go to image and discussion</a> 
						or 
						<button class="delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
							<i class="icon-trash icon-white"></i>
							<span>Delete</span>
						</button>
					</div>
				</td>
			{% } %}
		</tr>
	{% } %}
	</script>
	
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.autosize.js"></script>
	
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="/assets/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="/assets/js/load-image.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="/assets/js/canvas-to-blob.min.js"></script>
	<!-- jQuery Image Gallery -->
	<script src="/assets/js/jquery.image-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="/assets/js/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script src="/assets/js/jquery.fileupload.js"></script>
	<!-- The File Upload file processing plugin -->
	<script src="/assets/js/jquery.fileupload-fp.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="/assets/js/jquery.fileupload-ui.js"></script>
	<!-- The File Upload jQuery UI plugin -->
	<script src="/assets/js/jquery.fileupload-jui.js"></script>
	
	<?php echo Assets::js(); ?>
	<script>
	$(document).ready(function(){
		$('textarea').autosize();
	});
	</script>

</body>
</html>
