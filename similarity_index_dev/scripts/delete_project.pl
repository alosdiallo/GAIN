#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;
use File::Copy;

my $location_m = $ARGV[0];
my $full_path_name = $ARGV[1];
my $project = $ARGV[2];
chdir $location_m;
my $total_path = $location_m.$project;
print "in the script\n";
print "$total_path\n";
system("ls -la");
move("$total_path","/heap/lab_website/similarity_index_dev/trash/$project");

system("ls -la");
#system("cd /heap/lab_website/similarity_index_dev/users/newtest/projects/");
#system("ls -la");
