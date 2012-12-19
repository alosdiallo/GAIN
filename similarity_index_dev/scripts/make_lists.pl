#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;


my $headered = $ARGV[0];
my $non_headered = $ARGV[1];
my $location_m = $ARGV[2];
my $index = $ARGV[3];
my $m = 0;
my $l = 0;
my $element = 0;
my $line = 0;
my @triangle;
my @matrix;
my @matrixL;
my $z = 0;
my $y = 0;

my @tempL = split(/\//,$location_m);
my $array_size = scalar(@tempL);
$array_size = $array_size - 1;
chdir $location_m;

system("pwd");

my $myPval = `/heap/opt/bin/Rscript  /heap/lab_website/similarity_index_dev/scripts/triangle_gen.r $headered`;
chomp $myPval;

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
}
open MATRIX, "$non_headered" or die $!;
$y = 0;
$z = 0;

while($line = <MATRIX>){              
	chomp($line); 
	my @row_array = split(/\t/, $line);
   $z=0;
	foreach $element (@row_array){
		$matrix[$y][$z++] =$element;
	}
	$y++;
}
open MATRIXH, "$headered" or die $!;
my $w = 0;
my $x = 0;

while($line = <MATRIXH>){              
	chomp($line); 
	my @row_arrayL = split(/\t/, $line);
   $x=0;
	foreach $element (@row_arrayL){
		$matrixL[$w][$x++] =$element;
	}
	$w++;
}


open(LIST,">".$index."_full_list.txt");
open(LISTD,">".$index."_full_list_download.txt");


for($l=0; $l<$y; $l++){
	for($m=0; $m<$z; $m++){
		my $place_holder = 'TRUE ';
		if(($l!=0) || ($m!=0)){
			if($l != $m){
				if($triangle[$l][$m] eq $place_holder){
					
						print LIST "$matrix[$l][$m]\n";
						print LISTD "$matrixL[$l +1][0]\t$matrixL[0][$m +1]\t$matrix[$l][$m]\n";	
				}
			}
		}

	}
}
close LIST;
close LISTD;






