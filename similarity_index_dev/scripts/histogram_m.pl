#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;

my $full_name = $ARGV[0];
my $partial_values = $ARGV[1];
my $index = $ARGV[2];
my $output_dir = $ARGV[3];
my $full_list_dir = $ARGV[4];
my $index_full_list_dir = $ARGV[5];

my $full_list = $index."_full_list_download.txt";
my $index_full_list_file = $index_full_list_dir.$index."_full_list_download.txt";
chdir $output_dir;
my $combined_list = $index."_combined_partial_list.txt";
my $partial_list_names = "list.txt";
my $density_pdf = "density.pdf";
system ("/heap/opt/bin/Rscript /heap/lab_website/similarity_index_dev/scripts/histogram_m.r $full_name $partial_values $index $output_dir");
$index = $index."_density.png";

#trying to get the values 
open MATRIX, "$partial_list_names" or die $!;
my ($line,@row_array,@matrix_values,$element,@matrix,$y,$z,$w,$x,$l,$m);
$line=$element=$y=$z=$w=$l=$m=$x=0;


while($line = <MATRIX>){              
	chomp($line); 
	@row_array = split(/\t/, $line);
	$matrix[$y] = $row_array[0]."\t".$row_array[1];
	$y++;
}


#trying to get the names
open MATRIXVALUES, "$partial_values" or die $!;
while($line = <MATRIXVALUES>){              
	chomp($line); 
	$matrix_values[$x] = $line;
	$x++;
}

close (MATRIX);
close (MATRIXVALUES);
my $count = 0;
# print "\n\n";
# print Dumper(@matrix_values);
# print "\n\n";

#putting the values and the names together
open(COMBINEDLIST,">".$combined_list);
for($l=0; $l<$y; $l++){
		if(exists $matrix[$l]){
			print COMBINEDLIST "$matrix[$l]\t";
			print "$matrix[$l]\t";
		}
		if(exists $matrix_values[$l]){
			print COMBINEDLIST "$matrix_values[$l]\n";
			print "$matrix_values[$l]\n";
		}
}


close (COMBINEDLIST);


if (-e $density_pdf) {

	system ("/opt/csw/bin/gs -sDEVICE=pngalpha -sOutputFile=$index -r144 density.pdf");

	print "\n\n result.pdf Exists!\n\n";
} 
system ("rm -rf density.pdf");
system("/opt/csw/bin/convert ".$index ." -resize 35% ".$index);

if (-d "download") {
	system("cp $index ./download");
	system("cp $full_list ./download");
	system("cp $combined_list ./download");	
	system("cp $index_full_list_file ./download");	
	system("zip -9 -r download.zip download");
}
elsif (-e "download") {
	system("mkdir download");
	system("cp $index ./download");
	system("cp $full_list ./download");
	system("cp $combined_list ./download");	
	system("cp $index_full_list_file ./download");		
	system("zip -9 -r download.zip download");
}
else {
    system("mkdir download");
	system("cp $index ./download");
	system("cp $full_list ./download");
	system("cp $combined_list ./download");
	system("cp $index_full_list_file ./download");		
	system("zip -9 -r download.zip download");
	
}