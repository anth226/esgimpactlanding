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

$(".team-image-link").click(function() {	
	profileCard = $(this).closest(".profile-card");
	profileImage = $(profileCard).find("img");
	profileName = $(profileCard).find("h5");
	profileRole = $(profileCard).find(".role");
	profileBio = $(profileCard).find(".bio");
	profileLinkedIn = $(profileCard).find(".linked-in");
	
	$('#team-modal-image').attr("src", $(profileImage).attr("src"));
	$('#team-modal-name').text($(profileName).text());
	$('#team-modal-role').text($(profileRole).text());
	$('#team-modal-bio').text($(profileBio).text());
	$('#team-modal-linked-in').text($(profileLinkedIn).text());
	
	return false;
});