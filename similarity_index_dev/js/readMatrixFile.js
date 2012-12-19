function readMatrixFile(div, project, fileBase, headered, showNumbers){
	showNumbers = typeof showNumbers !== 'undefined' ? showNumbers : false;

	$.ajax({
		url : 'php/readMatrixFile_ajax_server.php',
		type : 'post',
		data : {
			project: project,
			fileBase: fileBase,
			headered: headered
		},
		success : function(answer){
			matrix = eval(answer);
			matrixTableString = setupMatrixTableString(matrix, showNumbers);
			$("#"+div).html(matrixTableString);
		}
	});
}

function setupMatrixTableString(matrix, showNumbers){
	// We simply want to display the matrix that was retrieved.. Let's do that
	str = "";
	for(x in matrix){
		str = str + "<tr>";
		for(y in matrix[x]){
			if(isNaN(matrix[x][y]) || matrix[x][y] == ""){
				color = "#FFFFFF";
				value = matrix[x][y];
			} else {
				if(showNumbers){
					value = matrix[x][y];
				} else {
					value = "";
				}
				//color = "#"+RGBtoHex(255-(matrix[x][y] * 100),255,255);
				if(matrix[x][y] > 0){
					color = "#"+RGBtoHex(255,255-(matrix[x][y] * 255),255-(matrix[x][y] * 255));
					//color = "#"+RGBtoHex(255-(matrix[x][y] * 255),255-(matrix[x][y] * 255), 255);
				} else {
					color = "#"+RGBtoHex(255-(matrix[x][y] * 255),255-(matrix[x][y] * 255), 255);
					//color = "#000000";
				}
				
			}
			if(x==0 && y != 0){
				str = str + "<td bgcolor='"+color+"' class='topheader'><div class='verticalText'>"+value+"</div></td>";
			} else {
				str = str + "<td bgcolor='"+color+"'>"+value+"</td>";
			}
			
		}
		str = str + "<\tr>"+"\n";
	}
	
	return str;
}

function RGBtoHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
function toHex(N) {
 if (N==null) return "00";
 N=parseInt(N); if (N==0 || isNaN(N)) return "00";
 N=Math.max(0,N); N=Math.min(N,255); N=Math.round(N);
 return "0123456789ABCDEF".charAt((N-N%16)/16)
      + "0123456789ABCDEF".charAt(N%16);
}

/*
bgcolor="rgb(0, 0, 255)"
*/