<html>
 <head>
  <title>How to Upload a File using Dropzone.js with PHP</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
 </head>
 <body>
  <div class="container">
   <br />
   <h3 align="center">How to Upload a File using Dropzone.js with PHP</h3>
   <br />
   
   <form id="my-awesome-dropzone" class="dropzone">
	  <div class="dropzone-previews"></div> <!-- this is were the previews should be shown. -->
	  
	  <!-- Now setup your input fields -->
	  <input type="email" name="username" />
	  <input type="password" name="password" />

	  <button type="submit">Submit data and files!</button>
	</form>

   <br />
   <br />
   <div align="center">
    <button type="button" class="btn btn-info" id="submit-all">Upload</button>
   </div>
   <br />
   <br />
   <div id="preview"></div>
   <br />
   <br />
  </div>
 </body>
</html>

<script>
	autoProcessQueue: false,
	uploadMultiple: true,
	parallelUploads: 100,
	maxFiles: 100,

	// The setting up of the dropzone

	init: function() {
		var myDropzone = this;

    // First change the button to actually tell Dropzone to process the queue.
    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
      // Make sure that the form isn't actually being sent.
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue();
    });

    // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
    // of the sending event because uploadMultiple is set to true.
    this.on("sendingmultiple", function() {
      // Gets triggered when the form is actually being sent.
      // Hide the success button or the complete form.
    });
    this.on("successmultiple", function(files, response) {
      // Gets triggered when the files have successfully been sent.
      // Redirect user or notify of success.
    });
    this.on("errormultiple", function(files, response) {
      // Gets triggered when there was an error sending the files.
      // Maybe show form again, and notify user of error
    });
  }
</script>
