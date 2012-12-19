#!/opt/csw/bin/perl
use lib "/opt/csw/lib/perl/csw";

#*********************************************************************************************
#
# Written by Alos Diallo, Walhout Lab
# This program will take in a matrix an generate a hypergeometric matrix as a result.
# For any matrix Aij where i = rows and j= columns 
# the program will transpose matrix A then multiply matrix A with At.  
# The new resulting matrix matrix R will pass Rij, Rii, and Rjj to 
# the R package phyper in the following form:
# phyper(q, m, n, k, lower.tail = TRUE, log.p = FALSE) 
# The result of phyper is then subtracted from 1 and multiplied by -log(10).  
# Usage is as follows: perl hypergeomrtic.pl matrix_file_name.txt
#
# Requirments 
#	Perl, R,  
#	Perl packages warnings, strict	
#	R packages Hypergeometric {stats}
#
# References
# 	http://stat.ethz.ch/R-manual/R-patched/library/stats/html/Hypergeometric.html
#	http://stat.ethz.ch/R-manual/R-patched/library/base/html/matmult.html
#*********************************************************************************************
use warnings;
use strict;

my $matrix_name = $ARGV[0];
my $location_m = 0;
$location_m = $ARGV[1];
my $output_location = $ARGV[2];
chdir $location_m;
my $new_loc = $location_m.$matrix_name;
my $myPval = `/heap/opt/bin/Rscript /heap/lab_website/similarity_index_dev/scripts/trans.r $new_loc`;
chomp $myPval;


sub toy_matrix(){
	open TOY, "$matrix_name" or die $!;
	
	my ($line,$i,$k,$j,$element);
	my (@main_2D_array,@row_array);
	$line=$i=$k=$j=$element = 0;
	while($line = <TOY>){ 
		# Chop off new line character, skip the comments and empty lines.                 
		chomp($line); 
		@row_array = split(/\t/, $line);
	   $j=0;
		foreach $element (@row_array){
			$main_2D_array[$i][$j++] =$element;
		}
		$i++;
	}
	
	
	close (TOY);
	return(\@main_2D_array,\@row_array,$i);
}

my ($matrixTwoD,$row_array,$i);
($matrixTwoD,$row_array,$i)=&toy_matrix();
my @main_2D_array = @$matrixTwoD;
my @row_array = @$row_array;

sub result_matrix(){
	open RESULTS, "result.txt" or die $!;
	
	my ($line,$i,$k,$j,$element);
	my (@main_2D_array,@row_array);
	$line=$i=$k=$j=$element = 0;
	while($line = <RESULTS>){ 
		# Chop off new line character, skip the comments and empty lines.                 
		chomp($line); 
		@row_array = split(/\t/, $line);
	   $j=0;
		foreach $element (@row_array){
			$main_2D_array[$i][$j++] =$element;			
		}
		$i++;
	}
	
	
	close (RESULTS);
	return(\@main_2D_array,\@row_array,$i);
}

my ($matrixTwoD_result,$row_array_result,$i_r);
($matrixTwoD_result,$row_array_result,$i_r)=&result_matrix();
my @main_2D_array_result = @$matrixTwoD_result;
my @row_array_result = @$row_array_result;

sub hyper($$$$){


# Usage for Hypergeometric 
# phyper(q, m, n, k, lower.tail = TRUE, log.p = FALSE)
# x, q vector of quantiles representing the number of white balls drawn without replacement 
# from an urn which contains both black and white balls.
# m the number of white balls in the urn.
# n	the number of black balls in the urn
# k	the number of balls drawn from the urn.
# log, log.p logical; if TRUE, probabilities p are given as log(p).	
# lower.tail logical; if TRUE (default), probabilities are P[X ≤ x], otherwise, P[X > x].
	
	system("rm -rf result.txt");
	
	my $main_2D_array_ref = shift;	
	my $main_2D_array_result_ref = shift;
	my $row_array_ref = shift;
	my $i = shift;
	my $output_location = shift;
	my @main_2D_array = @$main_2D_array_ref;
	my @main_2D_array_result= @$main_2D_array_result_ref;
	my @row_array = @$row_array_ref;
	my ($l,$w,$q,$m,$n,$k,$other);
	$l=$w=$q=$m=$n=$k=$other=0;
	my @spot=[];
	my $temp = length(@row_array);
	my @hyper = [];
	chdir $output_location;
	open(OUT,">"."hyper_results.txt");
	for($l=0; $l<$i; $l++){
		for($w=0; $w<$i; $w++){

			$q = ($main_2D_array_result[$l][$w] - 1);
			$m = $main_2D_array_result[$l][$l];
			$n = ($i + 1) - $main_2D_array_result[$l][$l];
			$k = $main_2D_array_result[$w][$w];
			my $myPval = `/heap/opt/bin/Rscript /heap/lab_website/similarity_index_dev/scripts/HyG.R $q $m $n $k`;
			chomp $myPval;
			$hyper[$l][$w] = (split(/\s+/, $myPval))[1];
			$hyper[$l][$w] = sprintf("%.8f", $hyper[$l][$w]); 

			if($w eq ($i-1)){
				print OUT "$hyper[$l][$w]"; 
			}
			else{
				print OUT "$hyper[$l][$w]\t";
			}	
		}
		#print"\n";
		print OUT "\n";
	}	


	print "Your done. \n";
}


()=&hyper(\@main_2D_array,\@main_2D_array_result,\@row_array_result,$i,$output_location);
close(OUT);