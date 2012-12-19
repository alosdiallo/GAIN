#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;

my $file_name = $ARGV[0];
my $location_m = $ARGV[1];
my @temp = split(/\_/,$file_name);
my $index = $temp[0];

my $txt_un_name = $location_m.$index."_headered.txt";
my $png_un_name = $location_m.$index."_headered.png";
my $png_den_name = $location_m.$index."_dendrogram.png";
my $clus_png_name = $location_m.$index."_clustered_headered".".png";



chdir $location_m;
if (-d "clustered") {
	system("cp $txt_un_name ./clustered");
	system("cp $png_den_name ./clustered");
	system("cp $clus_png_name ./clustered");	

	system("zip -9 -r clustered.zip clustered");
	
	
}
elsif (-e "clustered") {
  
	system("mkdir clustered");
	system("cp $txt_un_name ./clustered");
	system("cp $png_den_name ./clustered");
	system("cp $clus_png_name ./clustered");	

	system("zip -9 -r clustered.zip clustered");	
}
else {
	system("mkdir clustered");
	system("cp $txt_un_name ./clustered");
	system("cp $png_den_name ./clustered");
	system("cp $clus_png_name ./clustered");	

	system("zip -9 -r clustered.zip clustered");
	
}