function setupInteractionTable(){
	// Create Table Headers from geneList2
	str = "";
	str = str + "<tr><td></td>";
	for(x in geneList2){
		str = str + "<td>" + geneList2[x] +"</td>"
	}
	str = str + "</tr>";
	//Create table from geneList1
	for(y in geneList1){
		str = str + "<tr><td>" + geneList1[y] + "</td>";
		
		for(x in geneList2){
			positiveInteraction = "false";
			for(z in interactions[geneList1[y]]){
				if(geneList2[x] == interactions[geneList1[y]][z]){
					positiveInteraction = "true";	
				}
			}
			str = str + "<td>" + (positiveInteraction=="true"?"1":"0") + "</td>"
		}
		str = str + "</tr>";
	}
	$("#interactionTable").html(str);
}

function setupInteractionTableString(matrix){
	// We simply want to display the matrix that was retrieved.. Let's do that
	str = "";
	for(x in matrix){
		str = str + "<tr>";
		for(y in matrix[x]){
			str = str + "<td>"+matrix[x][y]+"</td";
		}
		str = str + "<\tr>"+"\n";
	}
	
	return str;
}
