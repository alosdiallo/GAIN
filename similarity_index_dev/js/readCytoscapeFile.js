var geneList1;
var geneList2;
var interactions;
		
function readCytoscapeFile(div, project, fileBase, symmetrical, cutoff){
	$.ajax({
		url : 'php/readCytoscapeFile_ajax_server.php',
		type : 'post',
		data : {
			project: project,
			fileBase: fileBase,
			cutoff: cutoff,
			csi: "false"
		},
		success : function(answer){
			response = eval( "(" + answer + ")" );
			if(!response || response == "false"){
				// Response stuff?
			} else {
				geneList1 = response['geneList1'];
				geneList2 = response['geneList2'];
				interactions = response['interactions'];

				// Response stuff?
				
				setupNetwork(div, symmetrical);
			}
		}
	});
}

function readCytoscapeFileCSI(div, project, fileBase, symmetrical, cutoff){
	$.ajax({
		url : 'php/readCytoscapeFile_ajax_server.php',
		type : 'post',
		data : {
			project: project,
			fileBase: fileBase,
			cutoff: cutoff,
			csi: "true"
		},
		success : function(answer){
			response = eval( "(" + answer + ")" );
			if(!response || response == "false"){
				// Response stuff?
			} else {
				geneList1 = response['geneList1'];
				geneList2 = response['geneList2'];
				interactions = response['interactions'];

				// Response stuff?
				
				setupNetwork(div, symmetrical);
			}
		}
	});
}


function setupNetwork(div, symmetrical){
	// id of Cytoscape Web container div
	var div_id = "interactionNetwork";

	var network_style = {
		nodes: {
			shape: { passthroughMapper: { attrName: "shape" } },
			color: {
				discreteMapper: {
					attrName: "color",
					entries: [
						{ attrValue: "BLUE", value: "#55C3DC" },
						{ attrValue: "ORANGE", value: "#FFA500" }
					]
				}
			}
		}
	}; 	

	// you could also use other formats (e.g. GraphML) or grab the network data via AJAX
	var networ_json = {
		dataSchema: {
			nodes: [ { name: "label", type: "string" },
					 { name: "shape", type: "string" },
					 { name: "color", type: "string" },]
		},
		data: {
			nodes: getNodes(symmetrical),
			edges: getEdges()
		}
	};

	// initialization options
	var options = {
		// where you have the Cytoscape Web SWF
		swfPath: baseurl+"swf/CytoscapeWeb",
		// where you have the Flash installer SWF
		flashInstallerPath: baseurl+"swf/playerProductInstall"
	};

	// init and draw
	var vis = new org.cytoscapeweb.Visualization(div, options);
	vis.draw({visualStyle: network_style, network: networ_json});
};

function getNodes(symmetrical){
	var nodes = new Array();
	for(x in geneList1){
		nodes.push({id: geneList1[x], color:"BLUE", label: geneList1[x]});
	}
	if(!symmetrical){
		for(y in geneList2){
			nodes.push({id: geneList2[y], color:"ORANGE", label: geneList2[y]});
		}
	}
	return nodes;
}
function getEdges(){
	var edges = new Array();
	for(x in geneList1){
		for(y in interactions[geneList1[x]]){
			edges.push({id: geneList1[x] + interactions[geneList1[x]][y], source: geneList1[x], target: interactions[geneList1[x]][y]});
		}
	}
	return edges;
}
