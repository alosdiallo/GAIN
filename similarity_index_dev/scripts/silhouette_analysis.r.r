##### silhouette analysis on cluster data after similarity index has been applied #####
##### Alos Diallo, UMASS Medical School 4/26/2013                                 #####
##### The script takes 2 arguments a similarity matrix without a distance applied #####
##### and a similarity matrix after a distance measure has been applied. The      #####
##### script will then output the results of the silhouette analysis on those     #####
##### data.                                                                       #####


library(cluster)
args <- commandArgs(TRUE);
matrix_norm <- read.table(args[1], sep='\t', header=F)
matrix_dis <- read.table(args[2], sep='\t', header=F)
k_number <- args[3]
mtnonscaled <- as.matrix(matrix_norm)
mtscaled <- as.matrix(matrix_dis)

cluster_result <- pam(mtscaled,k = k_number, diss = FALSE)
silhouette_matrix_results <- silhouette(cluster_result$clustering,mtnonscaled)
file_name <- paste(args[1],".txt")
sink(file_name)
silhouette_matrix_results
sink();
q();


