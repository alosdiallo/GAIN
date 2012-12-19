#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;



#This program is meant to remove the old download folder.  

my $full_path = $ARGV[0];
chdir $full_path;
my $unclustered = "unclustered";
my $clustered = "clustered";
my $network = "network";
system("pwd");
print "\n";


if (-d "unclustered") {
	if (-e $unclustered) {
		system("rm -rf unclustered.zip");
		system("pwd");
		print "deleted unclustered.zip";
	} 
	system("rm -rf unclustered");
	system("pwd");
}
if (-d "clustered") {
	if (-e $clustered) {
		system("rm -rf clustered.zip");
		system("pwd");
		print "deleted clustered.zip";
	} 
	system("rm -rf clustered");
	system("pwd");
}
if (-d "network") {
	if (-e $network) {
		system("rm -rf network.zip");
		system("pwd");
		print "deleted network.zip";
	} 
	system("rm -rf network");
	system("pwd");
}



print "done\n";
