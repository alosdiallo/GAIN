a <- read.table("pear_result.txt",sep='\t');
result <- round(a,10);
write.table(result, file="pear_result_round.txt",sep = " \t",col.names = T, row.names = T);