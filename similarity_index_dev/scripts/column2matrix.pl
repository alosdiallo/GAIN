#!usr/bin/perl -w
#!usr/bin/perl -w
#Bryan Lajoie
#8/20/2007

use English;
use DBI;
use POSIX qw(ceil floor);
use List::Util qw[min max];
use File::Path;
use Getopt::Long qw(:config no_ignore_case no_auto_abbrev pass_through);

sub check_options {
    my $opts = shift;
	
    my ($inputList);
 
	if( exists($opts->{'inputList'}) ) {
		$inputList = $opts->{'inputList'};
	} else {
		print "Option inputList|i is required.\n";
		exit;
	}
	
}

sub round($$) {
	my $num=shift;#the number to work on
	my $digs_to_cut=shift;# the number of digits after 
  
	if ($num=~/\d+\.(\d){$digs_to_cut,}/) {
		$num=sprintf("%.".($digs_to_cut-1)."f", $num);
	}		
	return $num;
}


my %options;
my $results = GetOptions( \%options,'inputList|i=s');

#user Inputs
my ($inputList);
($inputList)=check_options( \%options );

print "\n";
print "inputList\t$inputList\n";
print "\n";

my @inputListArr=split(/\//,$inputList);
my $inputListName=$inputListArr[(@inputListArr-1)];

my %col1s=();
my @col1sArr=();
my %col2s=();
my @col2sArr=();
my %matrix=();

my %encountered=();

my $line="";
my $lineNum=1;
my $nHits=0;

open(IN,$inputList);
while($line = <IN>) {
	chomp($line);
	next if(($line =~ m/^#/) or ($line eq ""));
	
	my @tmp=split(/\t/,$line);
	#exit if(@tmp != 3);
	
	my $col1=$tmp[0];
	my $col2=$tmp[1];
	my $score=1;
	$score=$tmp[2] if(defined($tmp[2]));
	$score = "NA" if($score !~ (/^([+-]?)(?=\d|\.\d)\d*(\.\d*)?([Ee]([+-]?\d+))?$/));
	
	my $key=$col1."|".$col2;
	if(exists($encountered{$key})) {
		print "found a duplicate!\t$lineNum\t$key\n";
		#exit;
	} else {
		$nHits++ if($score == 1);	
	}
	
	$encountered{$key}=1;
	
	if(!exists($col1s{$col1})) {
		push(@col1sArr,$col1);
		$col1s{$col1}=1;
	}
	if(!exists($col2s{$col2})) {
		push(@col2sArr,$col2);
		$col2s{$col2}=1;
	}
	
	$matrix{$col1}{$col2}=$score;
	
	$lineNum++;
	
}
close(IN);

print "found $nHits nHits...\n";

my $nCol1s=@col1sArr;
my $nCol2s=@col2sArr;

@col1sArr = sort(@col1sArr);
@col2sArr = sort(@col2sArr);

print "found $nCol1s col1s\n";
print "found $nCol2s col2s\n";

open(BINARY_MATRIX,">".$inputListName.".binary.matrix");
open(SCORE_MATRIX,">".$inputListName.".score.matrix");

print BINARY_MATRIX "\t";
print SCORE_MATRIX "\t";
for($i=0;$i<$nCol1s;$i++) {
	print BINARY_MATRIX $col1sArr[$i] . "\t";
	print SCORE_MATRIX $col1sArr[$i] . "\t";
}
print BINARY_MATRIX "\n";
print SCORE_MATRIX "\n";

for($y=0;$y<$nCol2s;$y++) { 
	$col2=$col2sArr[$y];
	print BINARY_MATRIX $col2sArr[$y] . "\t";
	print SCORE_MATRIX $col2sArr[$y] . "\t";
	for($x=0;$x<$nCol1s;$x++) { 
		$col1=$col1sArr[$x];
		if(exists($matrix{$col1}{$col2})) { $score=$matrix{$col1}{$col2}; $binary=1; } else { $score=0; $binary=0; }
		print BINARY_MATRIX $binary;
		print SCORE_MATRIX $score;
		if($x !=($nCol1s-1)) { print BINARY_MATRIX "\t"; print SCORE_MATRIX "\t"; }
	}
	if($y != ($nCol2s-1)) { print BINARY_MATRIX "\n"; print SCORE_MATRIX "\n"; }
}
close(BINARY_MATRIX);
close(SCORE_MATRIX);