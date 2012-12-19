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
chdir $location_m;
if (-d "unclustered") {
	system("cp $txt_un_name ./unclustered");
	system("cp $png_un_name ./unclustered");	

	system("zip -9 -r unclustered.zip unclustered");
	
	
}
elsif (-e "unclustered") {
  
	system("mkdir unclustered");
	system("cp $txt_un_name ./unclustered");
	system("cp $png_un_name ./unclustered");	

	system("zip -9 -r unclustered.zip unclustered");	
}
else {
	system("mkdir unclustered");
	system("cp $txt_un_name ./unclustered");
	system("cp $png_un_name ./unclustered");	
	system("zip -9 -r unclustered.zip unclustered");
	
}