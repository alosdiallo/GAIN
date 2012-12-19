#!/opt/csw/bin/perl
use lib "/opt/csw/lib/perl/csw";

#*********************************************************************************************
#
#Written by Alos Diallo, Walhout Lab
#This program will take in a matrix an generate a csi matrix as a result.
#For any position on the matrix Aij where i = rows and j= columns 
#evaluate the following: Aij -c <= max value of (Ait, Atj) until t = k.  
#For example if Ait = .5 and Atj = .8 the max value is .8
#If the evaluation is true add 1 to value positive then evaluate Cij = 1 - (positive/k).
#Once you have done that greate a new matrix filled with Cij values.  
#
#*********************************************************************************************
use strict;
use warnings;
use POSIX;
use Data::Dumper;
use List::Util qw(min max);

sub csi_matrix ($) {
my $input_matrix = $ARGV[0];
my $constant = $ARGV[1];
my $location_m = $ARGV[2];

#print "$location_m\n";
chdir $location_m;
open (MATRIX, $input_matrix) or die $!;
my ($i,$j,$m,$l,$size,$w,$max_value,$value,$score,$line,@main_2D_array,@row_array,@csi_score,@value);
$i=$j=$m=$l=$size=$w=$max_value=$value=$score=$line = 0;
 
open(OUT,">"."csi_matrix_results.txt");
while($line = <MATRIX>){               
    chomp($line); 
    @row_array = split(/\t/, $line);
    $j=0;
    foreach my $element (@row_array){
		$main_2D_array[$i][$j++] = $element;
    }
    $i++;
}
$size = scalar @row_array;

for($l=0; $l<$size; $l++){
	for($m=0; $m<$size; $m++){
		$score = 0;
		for($w =0; $w <$size; $w++){
			my $column_walk = $main_2D_array[$l][$w];
			my $row_walk = $main_2D_array[$w][$m];
			$value[0] = $column_walk;
			$value[1] = $row_walk;
			$max_value = max(@value);
			if(($main_2D_array[$l][$m] - $constant) <= $max_value){
				$score++;
			}
		}
		$csi_score[$l][$m] = 1 - ($score/$size);
		$csi_score[$l][$m] = sprintf("%.8f", $csi_score[$l][$m]); 
		$csi_score[$l][$m] = sprintf("%g", $csi_score[$l][$m]);
	}
}

for($l=0; $l<$size; $l++){
	for($m=0; $m<$size; $m++){
			if($m eq ($size-1)){
				print OUT "$csi_score[$l][$m]"; 
			}
			else{
				print OUT "$csi_score[$l][$m]\t";
			}		

	}
	print OUT "\n";
}
	
close (MATRIX);
close (OUT);
}

&csi_matrix;