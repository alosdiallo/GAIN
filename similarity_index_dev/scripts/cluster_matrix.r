library(RColorBrewer);
library(gplots);
library(MASS);
args <- commandArgs(TRUE);
matrix_a <- read.table(args[1], sep='\t', header=T, row.names=1)
args[1]
#mtscaled <- as.matrix(scale(matrix_a))
mtscaled <- as.matrix(matrix_a)
pdf("result.pdf", pointsize = 15, width = 18, height = 18)
mycol <- c("blue","white","red")
my.breaks <- c(seq(-1, 0, length.out=6),seq(.000001, .02, length.out=4),seq(.03,1, length.out=7))
my.color <- c("#1616FF", "#2D2DFF", "#4343FF", "#5A5AFF", "#7070FF", "#8787FF", "#9D9DFF", "#B4B4FF", "#CACAFF", "#E1E1FF", "#F7F7FF", "#FFD9D9", "#FFA3A3", "#FF6C6C", "#FF3636", "#FF0000")
shift.BR <- colorRamp(c("blue","white","red"), bias=1.7)((1:20)/20)
tpal <- rgb(shift.BR, maxColorValue=255)

#generating the heatmap
result <- heatmap.2(mtscaled, Rowv=T, scale='none', dendrogram="row", symm = T, col=bluered(16), breaks = my.breaks)
dev.off() 

#printing out the dendogram
matrix_d <- dist(matrix_a)
pdf("dendrogram.pdf", pointsize = 15, width = 18, height = 18)
hc <- hclust(matrix_d,"average")
plot(hc)
dev.off()
#end of printing out the dendogram

new_matrix <- result$carpet
old_name <- colnames(new_matrix)

#generating the clustered matrix for matrix2png
sink("data_result4.txt");
cat(c("genes",old_name), "\n");
for (i in 1:nrow(new_matrix))
{
	cat (old_name[i], new_matrix[i,], "\n");
}
sink();
q();
#generating the clustered matrix for matrix2png


