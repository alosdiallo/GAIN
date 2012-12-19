#!/opt/csw/bin/perluse lib "/opt/csw/lib/perl/csw";use strict;use warnings;use POSIX;
my $element = 0;
my $line = 0;
my @triangle;my @matrix;
my $z = 0;
my $y = 0;
my $matrix_name = $ARGV[0];my $location = $ARGV[1]; my $matrix_full = $location.$matrix_name;my $myPval = `/heap/opt/bin/Rscript  /heap/lab_website/similarity_index_dev/scripts/triangle_gen.r $matrix_full`;chomp $myPval;
open TRIANGLE, "triangle.txt" or die $!;

while($line = <TRIANGLE>){ 
	# Chop off new line character, skip the comments and empty lines.                 
	chomp($line); 
	my @row_array = split(/\t/, $line);
   $z=0;
	foreach $element (@row_array){
		$triangle[$y][$z++] =$element;
	}
	$y++;
}open MATRIX, "$matrix_name" or die $!;$y = 0;$z = 0;while($line = <MATRIX>){              	chomp($line); 	my @row_array = split(/\t/, $line);   $z=0;	foreach $element (@row_array){		$matrix[$y][$z++] =$element;	}	$y++;}

open(LIST,">"."trangle_list_".".txt");
for($l=0; $l<$y; $l++){
	for($m=0; $m<$z; $m++){
		my $place_holder = 'TRUE ';
		#print"$triangle[$l][$m]$place_holder";
		if($triangle[$l][$m] eq $place_holder){
			print LIST "$matrix[$l][$m]\n";
			
		}
		#print "\n";
	}
}
close LIST;