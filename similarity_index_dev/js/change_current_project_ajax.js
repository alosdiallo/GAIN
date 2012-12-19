$(document).ready(function(){
	$("#project").change(function () {
		changeProject();
	});
});

function changeProject(){
	project = $("select#project option:selected").val();
	$.ajax({
		url : 'php/changeCurrentProject_ajax_server.php',
		type : 'post',
		data : {project: project},
		success : function(answer){afterProjectChange();}
	});
}

function afterProjectChange(){}
