args   <- commandArgs(TRUE);
array <- read.table(args[1]);
array <- as.matrix(array);
arrayT <- t(array);
r <- array %*% arrayT
write.table(r, file="result.txt",sep = " \t",col.names = F, row.names = F)
