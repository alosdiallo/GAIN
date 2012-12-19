function setupQuestionnaire(){
	setupQuestion1();
}

function backQuestion(answers, num){
	answers.pop();
	lastAnswer = answers.pop();
	switch (num){
		case 1:
			setupQuestion1();
			break;
		case 2:
			setupQuestion2(answers, lastAnswer);
			break;
		case 3:
			setupQuestion3(answers, lastAnswer);
			break;
		case 4:
			setupQuestion4(answers, lastAnswer);
			break;
		case 5:
			setupQuestion5(answers, lastAnswer);
			break;
		case 6:
			setupQuestion6(answers, lastAnswer);
			break;
		case 7:
			setupQuestion7(answers, lastAnswer);
			break;
		default:
			break;
	}
}
function setupQuestion1(){
	answers = new Array();

	$("#question").html("The following 6 questions will help you select the most appropriate index for your particular application.  When using this questionnaire, please keep your biological problem in mind.<br><br><br>"+
	"1) According to your biological question, would you consider that the association index value between A and B in example 2 should be greater than the index value in example 1?");
	$("#picture").html("<img src='img/question1.png' />");
	$("#answers").html(	"<button type=\"button\" onClick=\"setupQuestion2(answers, 'a')\">Yes</button>"+
						"<button type=\"button\" onClick=\"setupQuestion2(answers, 'b')\">No</button>");
}
function setupQuestion2(answers, lastAnswer){
	answers.push(lastAnswer);
	$("#question").html("2) According to your biological question, which of the following examples would you consider to have a very high overlap?");
	$("#picture").html("<img src='img/question2.png' />");
	$("#answers").html(	"<button type=\"button\" onClick=\"setupQuestion3(answers, 'a')\">Example 3</button>"+
						"<button type=\"button\" onClick=\"setupQuestion3(answers, 'b')\">Examples 1 and 3</button>"+
						"<button type=\"button\" onClick=\"setupQuestion3(answers, 'c')\">All</button>"+
						"<button type=\"button\" onClick=\"backQuestion(answers, 1)\">Back</button>");
}
function setupQuestion3(answers, lastAnswer){
	answers.push(lastAnswer);
	$("#question").html("3) If the following examples came from your dataset, in which cases would you consider the overlap to be not meaningful?");
	$("#picture").html("<img src='img/question3.png' />");
	$("#answers").html(	"<button type=\"button\" onClick=\"setupQuestion4(answers, 'a')\">Example 3</button>"+
						"<button type=\"button\" onClick=\"setupQuestion4(answers, 'b')\">Examples 2 and 3</button>"+
						"<button type=\"button\" onClick=\"setupQuestion4(answers, 'c')\">All</button>"+
						"<button type=\"button\" onClick=\"backQuestion(answers, 2)\">Back</button>");
}
function setupQuestion4(answers, lastAnswer){
	answers.push(lastAnswer);
	$("#question").html("4) Are you specifically interested in determining if the overlap is statistically significant? If you are more interested in the statistical significance that in the proportion of overlap choose 'yes', otherwise choose 'no'.");
	$("#picture").html("");
	$("#answers").html(	"<button type=\"button\" onClick=\"setupQuestion5(answers, 'a')\">Yes</button>"+
						"<button type=\"button\" onClick=\"setupQuestion5(answers, 'b')\">No</button>"+
						"<button type=\"button\" onClick=\"backQuestion(answers, 3)\">Back</button>");
}
function setupQuestion5(answers, lastAnswer){
	answers.push(lastAnswer);
	$("#question").html("5) Is a low (non-zero) overlap still relevant to your biological question?");
	$("#picture").html("<img src='img/question5.png' />");
	$("#answers").html(	"<button type=\"button\" onClick=\"setupQuestion6(answers, 'a')\">Yes, I am interested in any overlap</button>"+
						"<button type=\"button\" onClick=\"setupQuestion6(answers, 'b')\">No, it is probably just by chance</button>"+
						"<button type=\"button\" onClick=\"backQuestion(answers, 4)\">Back</button>");
}
function setupQuestion6(answers, lastAnswer){
	answers.push(lastAnswer);
	$("#question").html("6) Besides looking for positive associations, are you also looking for anti-correlation in the interaction profiles?<br><br>Note: You may only find significant anti-correlation if your network has a high density of interactions. Unless this applies select No.");
	$("#picture").html("");
	$("#answers").html(	"<button type=\"button\" onClick=\"setupAnalysis(answers, 'a')\">Yes</button>"+
						"<button type=\"button\" onClick=\"setupAnalysis(answers, 'b')\">No</button>"+
						"<button type=\"button\" onClick=\"backQuestion(answers, 5)\">Back</button>");
}
function setupAnalysis(answers, lastAnswer){
	answers.push(lastAnswer);
	
	// Calculate and order the scores
	scores = calculateScores(answers);
	orderedScores = orderScores(scores);
	
	// Create an output string for the metrics
	orderedMetrics = "";
	for(i in orderedScores){
		orderedMetrics = orderedMetrics + (parseInt(i)+1) + ") " + orderedScores[i].name + ":" + orderedScores[i].score + "<br>"; 
	}
	$("#question").html(orderedMetrics);
	$("#picture").html("");
	$("#answers").html("<button type=\"button\" onClick=\"backQuestion(answers, 6)\">Back</button>");
}

function calculateScores(answers){
	// array("jaccard","cosine","simpson","geometric","PCC","hypergeometric")
	var metrics = [];
	metrics[0] ={name:"jaccard", score:0};
	metrics[1] ={name:"cosine", score:0};
	metrics[2] ={name:"simpson", score:0};
	metrics[3] ={name:"geometric", score:0};
	metrics[4] ={name:"pearson", score:0};
	metrics[5] ={name:"hypergeometric", score:0};
	
	// Question 1
	switch (answers[0]){
		case 'a':
			metrics[0].score = metrics[0].score + 1;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score + 1;
			metrics[4].score = metrics[4].score + 1;
			metrics[5].score = metrics[5].score + 1;
			break;
		case 'b':
			metrics[0].score = metrics[0].score + 2;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 0;
			metrics[3].score = metrics[3].score + 1;
			metrics[4].score = metrics[4].score + 1;
			metrics[5].score = metrics[5].score + 1;
			break;
		default:
			break;
	}
	
	// Question 2
	switch (answers[1]){
		case 'a':
			metrics[0].score = metrics[0].score + 2;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 0;
			metrics[3].score = metrics[3].score + 2;
			metrics[4].score = metrics[4].score + 2;
			metrics[5].score = metrics[5].score + 1;
			break;
		case 'b':
			metrics[0].score = metrics[0].score + 0;
			metrics[1].score = metrics[1].score + 0;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score + 0;
			metrics[4].score = metrics[4].score + 0;
			metrics[5].score = metrics[5].score + 1;
			break;
		case 'c':
			metrics[0].score = metrics[0].score + 1;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score + 0;
			metrics[4].score = metrics[4].score + 1;
			metrics[5].score = metrics[5].score + 1;
			break;
		default:
			break;
	}
	
	// Question 3
	switch (answers[2]){
		case 'a':
			metrics[0].score = metrics[0].score + 0;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score + 0;
			metrics[4].score = metrics[4].score + 0;
			metrics[5].score = metrics[5].score + 0;
			break;
		case 'b':
			metrics[0].score = metrics[0].score + 0;
			metrics[1].score = metrics[1].score + 1;
			metrics[2].score = metrics[2].score + 1;
			metrics[3].score = metrics[3].score + 0;
			metrics[4].score = metrics[4].score + 1;
			metrics[5].score = metrics[5].score + 1;
			break;
		case 'c':
			metrics[0].score = metrics[0].score + 2;
			metrics[1].score = metrics[1].score + 0;
			metrics[2].score = metrics[2].score - 1;
			metrics[3].score = metrics[3].score + 2;
			metrics[4].score = metrics[4].score + 2;
			metrics[5].score = metrics[5].score + 1;
			break;
		default:
			break;
	}
	
	// Question 4
	switch (answers[3]){
		case 'a':
			metrics[0].score = metrics[0].score + 0;
			metrics[1].score = metrics[1].score + 0;
			metrics[2].score = metrics[2].score + 0;
			metrics[3].score = metrics[3].score + 0;
			metrics[4].score = metrics[4].score + 0;
			metrics[5].score = metrics[5].score + 3;
			break;
		case 'b':
			metrics[0].score = metrics[0].score + 2;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score + 2;
			metrics[4].score = metrics[4].score + 2;
			metrics[5].score = metrics[5].score + 0;
			break;
		default:
			break;
	}
	
	// Question 5
	switch (answers[3]){
		case 'a':
			metrics[0].score = metrics[0].score + 0;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score - 1;
			metrics[4].score = metrics[4].score + 1;
			metrics[5].score = metrics[5].score - 1;
			break;
		case 'b':
			metrics[0].score = metrics[0].score + 2;
			metrics[1].score = metrics[1].score + 1;
			metrics[2].score = metrics[2].score + 1;
			metrics[3].score = metrics[3].score + 2;
			metrics[4].score = metrics[4].score + 1;
			metrics[5].score = metrics[5].score + 2;
			break;
		default:
			break;
	}
	
	// Question 5
	switch (answers[3]){
		case 'a':
			metrics[0].score = metrics[0].score + 0;
			metrics[1].score = metrics[1].score + 0;
			metrics[2].score = metrics[2].score + 0;
			metrics[3].score = metrics[3].score + 0;
			metrics[4].score = metrics[4].score + 2;
			metrics[5].score = metrics[5].score + 0;
			break;
		case 'b':
			metrics[0].score = metrics[0].score + 2;
			metrics[1].score = metrics[1].score + 2;
			metrics[2].score = metrics[2].score + 2;
			metrics[3].score = metrics[3].score + 2;
			metrics[4].score = metrics[4].score + 0;
			metrics[5].score = metrics[5].score + 2;
			break;
		default:
			break;
	}
	
	return metrics;
}

function orderScores(scores){
	scores.sort(function(a, b){return b.score-a.score})
	return scores;
}