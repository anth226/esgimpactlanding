// this is the id of the submit button
$("#mc-form-submit").click(function() {
    var url = "download.php"; // the script where you handle the form input.

	$.ajax({
	type: "POST",
		url: url,
		data: $("#mc-form").serialize(), // serializes the form's elements.,
    	dataType: "json",
		success: function(data) {			
			if (data["success"]) {
				alert(data["message"]);
			}
		}
     });

    return false; // avoid to execute the actual submit of the form.
});