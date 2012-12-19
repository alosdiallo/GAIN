#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;


my($new_long_name,$pdf_loc_name,$file_name,$location_m,$png_loc_name,$pdf_den_name,$png_den_name,@temp,$index,$txt_un_name,$png_un_name);
$file_name = $location_m = $new_long_name = $pdf_loc_name = $png_loc_name = $pdf_den_name = $png_den_name = $index = $txt_un_name = $png_un_name = 0;
 
$file_name = $ARGV[0];
$location_m = $ARGV[1];
chdir $location_m;
#system("rm -rf /heap/lab_website/similarity_index_dev/users/newtest/projects/AJ2");
@temp = split(/\_/,$file_name);
$index = $temp[0];
$png_un_name = $location_m.$index."_headered";
my $filename = "interactions_headered.png";
 if (-e $filename) {
 print "\n\n interactions_headered.png Exists!\n\n";
 } 
else{
system("/usr/local/bin/matrix2png -data interactions_headered.txt -bkgcolor white -mincolor white -maxcolor red -missingcolor grey -s -d -r -c -size 8:8 -g -u > interactions_headered.png");
}
print "$location_m\n";
# if (-d "download") {
	# system("cp interactions_headered.png ./download");
	# system("cp interactions_headered.txt ./download");
	# system("cp interactions.txt ./download");
	# system("zip -9 -r download.zip download");
	# print"here";
	
	
# }
# elsif (-e "download") {
  
	# system("mkdir download");
	# system("cp interactions_headered.png ./download");
	# system("cp interactions_headered.txt ./download");
	# system("cp interactions.txt ./download");
	# system("zip -9 -r download.zip download");	
		# print"here2";
# }
# else {
    # system("mkdir download");
	# system("cp interactions_headered.png ./download");
	# system("cp interactions_headered.txt ./download");
	# system("cp interactions.txt ./download");
	# system("zip -9 -r download.zip download");
		# print"here3";
	
# }


