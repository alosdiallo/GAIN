args <- commandArgs(TRUE);

full_list <- scan(args[1]);
partial_list  <- scan(args[2]);
index_name <- args[3];
output <- args[4];
full_list <- density(full_list)
partial_list <- density(partial_list)

full_max = max(full_list$y)
partial_max = max(partial_list$y)

if(full_max > partial_max){
	setwd(output);
	pdf("density.pdf", pointsize = 15, width = 18, height = 18)
	plot(full_list , main= bquote("Density plot of " ~ .(index_name) ~ " index list of pairs vs all pairs"), col=rgb(1,0,0,0.8))
	polygon(full_list ,col=rgb(1,0,0,0.8))
	polygon(partial_list ,col=rgb(0,0,1,0.6))
	legend("topright", c("All Pairs","List of Pairs"),col=c("red","blue"),lty = c(1,1))
	dev.off() 

}
if(partial_max > full_max){
	setwd(output);
	pdf("density.pdf", pointsize = 15, width = 18, height = 18)
	plot(partial_list , main= bquote("Density plot of " ~ .(index_name) ~ " index list of pairs vs all pairs"), col=rgb(0,0,1,0.8))
	polygon(partial_list ,col=rgb(0,0,1,0.8))
	polygon(full_list ,col=rgb(1,0,0,0.6))
	legend("topright", c("All Pairs","List of Pairs"),col=c("red","blue"),lty = c(1,1))
	dev.off() 
}
