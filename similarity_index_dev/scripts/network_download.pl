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


my $list_name = $location_m.$index."_list.txt";
#my $rev_name = $location_m.$index."_rev_list.txt";



chdir $location_m;
if (-d "network") {
	system("cp $list_name ./network");
	#system("cp $rev_name ./network");
	

	system("zip -9 -r network.zip network");
	
	
}
elsif (-e "network") {
  
	system("mkdir network");
	system("cp $list_name ./network");
	#system("cp $rev_name ./network");
	

	system("zip -9 -r network.zip network");	
}
else {
	system("mkdir network");
	system("cp $list_name ./network");
	#system("cp $rev_name ./network");
	

	system("zip -9 -r network.zip network");
	
}