a <- read.table("pear_data.txt",header = TRUE, row.names=1,sep='\t');
result <- cor(a , y= NULL, method = "pearson");
write.table(result, file="pear_result.txt",sep = " \t",col.names = T, row.names = T);