var geneList1;
var geneList2;
var interactions;
		
function getInteractionData_ajax(project){
	$.ajax({
		url : 'php/readInteractionFile_ajax_server.php',
		type : 'post',
		data : {project: project},
		success : function(answer){
			response = eval( "(" + answer + ")" );
			if(!response || response == "false"){
				interactionDataResponseFailure();
			} else {
				geneList1 = response['geneList1'];
				geneList2 = response['geneList2'];
				interactions = response['interactions'];
			
				interactionDataResponseSuccess();
			}
		}
	});
}
