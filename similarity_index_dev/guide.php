<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	// If the user is not logged on, redirect to login page.
	// if(!isset($_SESSION['logged_on'])){
		// header('Location: '.$GLOBALS['url'].'login.php');
	// }
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require($GLOBALS['directory']."html/title.html");?>
		
		<link rel="stylesheet" type="text/css" href="css/universal.css" media="screen" />
	</head>
	<body>
<div class="margin50"><img src="img/menu/top_guide.jpg" width="1016" height="80" border="0" usemap="#MapMapMap">
  <map name="MapMapMap">
    <area shape="rect" coords="826,15,894,33" href="contact.php">
    <area shape="rect" coords="768,16,804,34" href="help.php">
    <area shape="rect" coords="532,17,681,35" href="compareMetrics.php">
    <area shape="rect" coords="405,16,512,34" href="visualize_similarity_matrix.php">
    <area shape="rect" coords="129,14,247,36" href="createNewProject.php">
    <area shape="rect" coords="12,3,97,51" href="index.php">
    <area shape="rect" coords="913,14,999,34" href="php/logout_server.php">
    <area shape="rect" coords="271,18,389,36" href="visualize_interactions.php">
  </map>
  <br>

  <map name="MapMap">
    <area shape="rect" coords="150,14,250,42" href="createNewProject.php">
  </map>
</div>
<hr>
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<div id="guide_master">
		<p><strong>Introduction</strong></p>
        <p>Biological processes  are orchestrated through complex interaction networks that dictate how  organisms respond to environmental cues, maintain homeostasis, develop and  reproduce. Networks are modeled into graphs that depict interactions (&lsquo;edges&rsquo;)  between biological entities such as genes, tissues, proteins and metabolites  (&lsquo;nodes&rsquo;). If only one type of node is involved, as in protein-protein or  genetic interaction networks, the graph is defined as monopartite. Bipartite  graphs, on the other hand, describe interactions between two different types of  nodes (X-type and Y-type). These include gene regulatory networks connecting  transcription factors and target genes, phenotypic networks connecting genes and  phenotypes, and expression networks connecting genes and tissues. </p>
        <p><img src="img/guide_clip_image001.png" alt="1" width="413" height="141"> <br>
          <br>
          Networks have  provided powerful tools for gene function annotation. For instance, the  &lsquo;guilt-by-association&rsquo; principle postulates that if a gene with unknown  function has similar interaction partners (hereafter referred to as  &lsquo;interaction profile&rsquo;) as a gene with a known function, the first gene may have  that function as well. <br>
  <img src="img/guide_clip_image003.png" alt="2" width="335" height="259"></p>
        <p>A major challenge is  how to best capture interaction profile similarity between two (or more) genes.  Association indices are mathematical tools that can be used to define similarity,  for instance in interaction profile. However, there are many association  indices and it can be daunting to select the most appropriate one for a  particular goal as different indices can provide very different results. Here  we provide an overview of association indices that are commonly used in  genomics and systems biology, and provide a set of guidelines for association  index selection based on different applications. </p>
        <p><strong>&nbsp;</strong></p>
        <p><strong>Types of association indices</strong></p>
        <p>This guide and GAIN  are focused on bipartite networks where association indices measure shared  Y-type nodes between two X-type nodes, A and B (|N(A)ÇN(B)|), in relation to their total number of  interactions (&lsquo;node degree&rsquo;), |N(A)| and |N(B)|, and the total number of Y-type  nodes in the network (ny). </p>
        <p><img src="img/guide_clip_image005.png" alt="3" width="541" height="153"></p>
        <p>There are three main  types of indices that are available in GAIN, each of which utilizes these  variables in a different way.</p>
        <p><strong>Similarity indices </strong><br>
          Similarity indices  reflect the proportion of overlap and only consider the number of shared  interactions between two X-type nodes A and B, and their individual degrees,  and do not take the total number of Y-type nodes in the network into account. The  value for the indices mentioned below range from 0 (no overlap) to 1 (perfect  overlap).<br>
          The <strong>Jaccard</strong> index is the proportion of  shared nodes between A and B relative to the total number of nodes connected to  A and B.<br>
  <img src="img/guide_clip_image007.jpg" alt="4" width="141" height="50"></p>
        <p>The <strong>Simpson</strong> index is the proportion of  shared nodes relative to the degree of the least connected node.<br>
          <img src="img/guide_clip_image009.jpg" alt="5" width="179" height="49"></p>
        <p>The <strong>Geometric</strong> index corresponds to the  product of the proportion of shared nodes between A and B.<br>
          <img src="img/guide_clip_image011.jpg" alt="6" width="148" height="48"></p>
        <p>The <strong>Cosine</strong> index is the geometric mean of  the proportions of shared nodes between A and B.<br>
          <strong><img src="img/guide_clip_image012.jpg" alt="7" width="163" height="58"></strong><strong> </strong></p>
        <p><strong>Statistic-based indices</strong> <br>
          Statistic-based  indices are based on probability distributions (Chi-square, Fisher&rsquo;s exact  test, <em>etc</em>.) and consider the  likelihood of observing certain overlap between the interaction profiles of two  X-type nodes given their degree and the total number of Y-type nodes in the  network.<br>
          The <strong>Pearson correlation coefficient</strong> is the  correlation between the interaction profiles of A and B. The values range from  -1 (perfect anti-correlation) to 1 (perfect correlation).<br>
  <img src="img/guide_clip_image014.jpg" alt="8" width="354" height="70"></p>
        <p>The <strong>Hypergeometric</strong> index measures the  probability of having an equal or greater interaction overlap than the one  observed between A and B. The values for this index range from 0 (no overlap)  to a number that depends on ny (it can be greater than 1). <br>
          <img src="img/guide_clip_image016.jpg" alt="9" width="399" height="106"> <br>
          <br>
  <strong>Connection Specificity Index</strong> <br>
          The indices mentioned  above only consider the similarity in interacting partners between two defined  X-type nodes (A and B) without taking the connectivity of other X-type nodes in  the network into account. In other words, the indices do not consider the  specificity of the interactions. For instance, two X-type nodes may have a high  similarity because they both interact with a Y-type node that is also bound by  many other X-type nodes. When disproportionately highly connected, such Y-type  nodes are referred to as hubs. Since interactions with hubs are not specific,  they are much less informative than shared interactions with lowly connected  partners. The connectivity specificity index (CSI) provides a context-dependent  measure that mitigates the effect of network hubs (Cell. 2011 Apr  29;145(3):470-82). CSI is equivalent to the fraction of X-type nodes in the  dataset that are less similar to A and B than the interaction profile similarity  between A and B.<br>
  <img src="img/guide_clip_image018.jpg" alt="10" width="437" height="62"></p>
        <p>A constant is used by  CSI to define the stringency of node-pair similarity; the formula includes the constant  (0.05) used in the original paper. When the constant is increased, CSI provides  a more stringent measure.<strong> </strong>Although CSI was first combined with PCC, it is important to note that it  can also be used with other association indices.<strong></strong></p>
        <p><strong>Finding modules using association  indices </strong></p>
        <p>Genes and proteins  function in modules that together comprise networks. Modules can be identified  by calculating association indices for all pairwise combinations of one type of  node in the &lsquo;Find Modules&rsquo; section, followed by clustering the indices into a  heatmap or association network. Such a network only consists of one type of node  that is connected by an edge when their interaction profile similarity exceeds  a selected threshold. This threshold can be determined by the user. </p>
        <p><img src="img/guide_clip_image020.png" alt="11" width="470" height="210"></p>
        <p>The different indices  have different performance in finding modules. For example, in a <em>C. elegans</em> gene-to-phenotype network  that connects genes to phenotypic features (Cell. 2011 Apr 29;145(3):470-82) the  association indices were calculated for each pair of genes according to the  shared phenotypic features and then clustered into heatmaps and association  networks. Visual inspection of the heatmaps and association networks shows that  the Simpson index is least suitable for the  identification of the four clusters, while CSI performs best as only two genes are not assigned to any cluster in the  association network, and because only one gene is placed into a different  cluster than the manual classification performed by the authors of the original  paper. <br>
          <img src="img/guide_clip_image022.png" alt="12" width="685" height="335"></p>
        <p>In general, applying  CSI greatly improves the identification of modules as it weights the  connectivity of the entire network in a context-dependent manner, reduces the  impact of hubs in node similarity, produces a good separation between intra-  and inter-module similarities and allows a single threshold to uncover  relationships with similar level of resolution. Nevertheless, for some datasets  other indices may also be applicable. <br>
          In any case, it  is important to bear in mind that the only way to determine which index is most  suitable is by benchmarking based on external information. <br>
          <br>
  <strong>Comparing node-pair similarity using  association indices</strong></p>
        <p>To gain insight into  the coordinate regulation of biological processes, the interaction profile  similarity between nodes can be compared between different groups of node-pairs.  For instance, the DNA interaction profile similarity can be compared between  transcription factors pairs that physically interact with each other to the  similarity of non-interacting proteins. <br>
          This type of analysis  can be performed in the &lsquo;Compare Similarity&rsquo; section where you can compare the  distribution of index values between a selected list of node-pairs and all  possible pairs (multiple lists can be analyzed and downloaded individually to  compare them using statistical analysis programs). </p>
        <p><img src="img/guide_clip_image024.png" alt="13" width="274" height="260"></p>
        <p>When  the main goal is to compare the biological similarity between groups of  node-pairs, context-independent indices are more appropriate than CSI. The  index to select will mostly depend on the type of biological question and what  the researcher considers as similar, and this should be the primary guide. For  instance, the Simpson index should be employed when the main interest is to  highlight overlapping interactions as the maximum similarity is expected when  the interactors of one node are included in the set of interactors of the other  node. Jaccard, Cosine, Geometric and PCC, on the other hand, give a maximum  overlap only if the interaction profiles of the two nodes are identical so are  better suited to capture non-overlapping interactions. The Jaccard and Cosine  index have a more intuitive formula and do not repress low overlaps as much as  the Geometric index. If a researcher is interested in identifying  anti-correlation as well as similarity, the PCC should be employed.</p>
        <p><img src="img/guide_clip_image026.jpg" alt="14" width="576" height="188"></p>
        <p>In  general, we do not recommend using the Hypergeometric index to measure  interaction profile similarity, as it does not scale with the proportion of  overlap (additionally it may require extensive computational time).  Nevertheless, it may be useful to calculate the significance of overlap between  the interactors of two nodes, rather than the magnitude. However, it is  important to bear in mind that the Hypergeometric test assumes that all the Y-type  nodes are equally likely to occur which is far from true as most networks have asymmetrical  degree distributions.</p>
        <p>GAIN provides  assistance for index selection to compare similarity through a questionnaire that  can be accesse<a name="_GoBack"></a>d by clicking on &ldquo;Help for choosing index&rdquo;.</p>
</div>        
<script>
			$(document).ready(function(){ 
				setupAjaxForm('form');
			})
			
			function setupAjaxForm(identifier){
				$(identifier).ajaxForm({
					beforeSubmit: function() {},
					success: showResponse
				});
			}

			function showResponse(answer){
				if(answer != "SUCCESS" && answer != ""){
					alert(answer);
				} else if(answer == "SUCCESS"){
					alert("Project Created!");
					// Since we were successful let's empty text boxes to make sure we don't make any stupid mistakes.
					$("#project").val("");
					$("#fileToBeUploaded").val("");
					$("#col1label").val("");
					$("#col2label").val("");
			
				}
			}
		</script>
	</body>
</html>
