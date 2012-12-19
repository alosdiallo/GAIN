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
system("pwd");
print "\n";
my $download_file = "download.zip";
if (-d "download") {
	if (-e $download_file) {
		system("rm -rf download.zip");
		system("pwd");
	} 
	system("rm -rf download");
	system("pwd");
}

elsif (-e "download") {
	print "there is no folder named download there 1\n";
	system("pwd");
}
else {
	print "there is no folder named download there 2\n";
	system("pwd");
}

print "done\n";
