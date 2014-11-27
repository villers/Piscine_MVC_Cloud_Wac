if ($('#my-dropzone').length  ) {
	Dropzone.autoDiscover = false;

	var myDropzone = new Dropzone("#my-dropzone");
	myDropzone.on("success", function(file) {
		file = JSON.parse(file.xhr.responseText);
		if(file.error){
			//$("#my-dropzone").children().last().remove();
			alert(file.error);
			return false;
		}

		$('#upload').append(file.html);
		$('#totalSize').text(file.totalSize);
		console.log(file);
	});
}

$('.fancybox').fancybox();

$('.deleteshare').click(function(e){

	$.ajax({
		url: baseUrl+'/upload/share/delete/'+e.currentTarget.id,
	}).done(function(data) {
		if(data.length)
			alert(data);
	});
})