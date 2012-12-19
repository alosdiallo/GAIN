args   <- commandArgs(TRUE);
q <- as.numeric(args[1]);
m <- as.numeric(args[2]);
n <- as.numeric(args[3]);
k <- as.numeric(args[4]);
p<- -log10(phyper(q,m,n,k,lower.tail = FALSE));
p