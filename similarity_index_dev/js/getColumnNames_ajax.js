var column_names = new Array();

function getColumnNames_ajax(){
	$.ajax({
		url : 'php/getColumnNames_ajax_server.php',
		type : 'post',
		data : {},
		success : function(answer){
			if(answer != "FAILED_OPEN"){
				response = eval( "(" + answer + ")" );
			
				column_names = response;
				//afterColumnNames();
				if(column_names[0] == undefined){
					column_names[0] = "Column 1";
				}
				if(column_names[1] == undefined){
					column_names[1] = "Column 2";
				}
				setColumns(column_names[0],column_names[1]);
			} else {
				setColumns("Column 1","Column 2");
			}
		}
	});
}
/*
$("#project").change(function(){
	getColumnNames_ajax();
});
*/
function afterProjectChange(){
	getColumnNames_ajax();
	populateLists();
}

function populateLists(){};
//document.onload = goDoStuff();
//getColumnNames_ajax();
$(document).ready(function(){
	getColumnNames_ajax();
})

function setColumns(col1, col2){
	
	str = "";
	str = str + "<option value=''>"+col1+"</option>";
	str = str + "<option value='true'>"+col2+"</option>";
	$("#column_select").html(str);
}

function afterColumnNames(){
	setColumns(column_names[0],column_names[1]);
}