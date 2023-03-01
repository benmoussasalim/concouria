function authMeReturned(data){
	$("#logMeContainerMsg").html(data['msg']);
	$("#logMeContainerMsg").show('slow');
	
	setTimeout(function(){
		$("#logMeContainerMsg").hide('slow');
		if(data['username'] != null){
			document.location = './admin';
		}
	}, 3000);
}