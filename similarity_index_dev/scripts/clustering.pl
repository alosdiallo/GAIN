#!/opt/csw/bin/perl
#!/opt/csw/bin/gs
use Env qw(PATH);
use strict;
use warnings;
use POSIX;
use Data::Dumper;

my($new_long_name,$pdf_loc_name,$file_name,$location_m,$png_loc_name,$pdf_den_name,$png_den_name,@temp,$index,$txt_un_name,$png_un_name);
$file_name = $location_m = $new_long_name = $pdf_loc_name = $png_loc_name = $pdf_den_name = $png_den_name = $index = $txt_un_name = $png_un_name = 0;
my $countx = 0;
my $county = 0;
#added later
my ($j,$line,$i,$y,$z,$x,$w,$size,$t,$s,@row_array,@matrixBad,@mainHeadGood,$m,$l,@main_2D_array);
$j=$line=$i=$size=$m=$l=$y=$z=$x=$w=$t=$s=0;
#added later
$file_name = $ARGV[0];
$location_m = $ARGV[1];
my $min_val = $ARGV[2];
my $max_val = $ARGV[3];
#$location_m =  "/heap/lab_website/similarity_index/users/tester/projects/arda/";


@temp = split(/\_/,$file_name);
$index = $temp[0];
my $file_name_only = $index."_headered.txt";

chdir $location_m;
my $data_result = 0;

$new_long_name = $location_m.$file_name;
$pdf_loc_name = $location_m."result.pdf";
$png_loc_name = $location_m."result.png";
$data_result = $location_m."data_result4.txt";
$pdf_den_name = $location_m."dendrogram.pdf";
$png_den_name = $location_m.$index."_dendrogram.png";
$txt_un_name = $location_m.$index."_headered.txt";
$png_un_name = $location_m.$index."_headered.png";
my $png_clustered_image = $location_m.$index."_clustered_headered.png";


my $input_matrix = $data_result;
#Fixing headered for CSI
my @tempL = split(/\//,$location_m);
my $array_size = scalar(@tempL);
$array_size = $array_size - 1;
my $matrix_sup = $tempL[$array_size]."_headered.txt";
my $matrix_supTwo = $tempL[$array_size]."_headered.txt";

my $file_nameR = "csi_matrix_results.txt";
if(($file_name =~ /csi/) and ($file_name =~ /rev/)){

	open (MATRIXM, $file_nameR) or die $!;
	while($line = <MATRIXM>){               
		chomp($line); 
		if(length($line) == 0){ next; }
		@row_array = split(" ", $line);
		
		$y=0;
		foreach my $element (@row_array){
			$matrixBad[$z][$y++] = $element;
		}
		$z++;
	}

close(MATRIXM);
	open (MATRIXS, $matrix_sup) or die $!;
	while($line = <MATRIXS>){               
		chomp($line); 
		if(length($line) == 0){ next; }
		@row_array = split(" ", $line);
		
		$x=0;
		foreach my $element (@row_array){
			$mainHeadGood[$w][$x++] = $element;
		}
		$w++;
	}



	close(MATRIXS);
	open(OUTNOW,">"."$file_name");
	my (@main_2D_array_new);
	for ($m=0; $m<$x; $m++) { $main_2D_array_new[0][$m] = $mainHeadGood[0][$m];}
	# for ($l=1; $l<$w; $l++) { $main_2D_array_new[$l][1] = $mainHeadGood[$l][1];}

	for($l=1; $l<$w; $l++){
		for($m=0; $m<$x; $m++){
			if($m == 0){
				$main_2D_array_new[$l][$m] = $mainHeadGood[$l][$m];
			}

			else{
				$main_2D_array_new[$l][$m] = $matrixBad[$l-1][$m-1];
				#print "$matrixBad[$county][$countx]\n";
				#$countx++;
				
			}
			
		}
			#$county++;

	}
	#print Dumper(@main_2D_array_new);
	for($l=0; $l<$w; $l++){
		for($m=0; $m<$x; $m++){
			if($m eq ($x-1)){print OUTNOW "$main_2D_array_new[$l][$m]";}
			else{print OUTNOW "$main_2D_array_new[$l][$m]\t";}
		}
		print OUTNOW "\n";
	}
	#print Dumper(@main_2D_array_new);

	#Fixing headered for CSI
	# system("rm -rf $file_name");
	# system("cp csi_special.txt $file_name");
	system("rm -rf $matrix_supTwo");
	system("cp $matrix_sup $matrix_supTwo");
	
	system ("/heap/opt/bin/Rscript /heap/lab_website/similarity_index_dev/scripts/cluster_matrix.r $file_name");
	system ("chmod 777 result.pdf");
	system ("chmod 777 dendrogram.pdf");
	
	
	

}
else{

	system ("/heap/opt/bin/Rscript /heap/lab_website/similarity_index_dev/scripts/cluster_matrix.r $file_name");
	system ("chmod 777 result.pdf");
	system ("chmod 777 dendrogram.pdf");
}

# generating the heatmap png image
my $filename = $location_m."result.pdf";
 if (-e $filename) {
 print "\n\n $filename Exists!\n\n";
 } 
system ("/opt/csw/bin/gs -sDEVICE=pngalpha -sOutputFile=$png_loc_name -r144 $pdf_loc_name");

system("/opt/csw/bin/convert ".$png_loc_name ." -resize 25% ".$png_loc_name);
# generating the heatmap png image

# generating the dendrogram png image
my $filename_den =  $location_m."dendrogram.pdf";
 if (-e $filename_den) {
 print "\n\n dendrogram.pdf Exists!\n\n";
 } 
system ("/opt/csw/bin/gs -sDEVICE=pngalpha -sOutputFile=$png_den_name -r144 $pdf_den_name");

system("/opt/csw/bin/convert ".$png_den_name ." -resize 25% ".$png_den_name);
# generating the dendrogram png image

# Generating the text file that can be used to make the heatmap image
open(OUT,">"."data_final.txt") or die "Couldn't open: $!";;
print "$pdf_loc_name\n$pdf_den_name\n";

open (MATRIX, $input_matrix) or die $!;
while($line = <MATRIX>){               
    chomp($line); 
	if(length($line) == 0){ next; }
    @row_array = split(" ", $line);
	
    $j=0;
    foreach my $element (@row_array){
		$main_2D_array[$i][$j++] = $element;
    }
    $i++;
}

$size = scalar @row_array;
close (MATRIX);
my $count = 1;

# for($l=0; $l< 1; $l++){print OUT "$main_2D_array[$l][0]\n"; }
# print OUT "\t";
for ($m=0; $m<$j; $m++) { print OUT "$main_2D_array[0][$m]\t"; }
print OUT "\n";

for($l=$i-1; $l>0; $l--){
	for($m=0; $m<$j; $m++){
		if($m==0){
			print OUT "$main_2D_array[$count][$m]\t";
			$count ++;
		}
		else{
			print OUT "$main_2D_array[$l][$m]\t";
		}

	}
	print OUT "\n";
}


if(($index eq 'pearson') ||($index eq 'pearsonrev')){
	print "\nHey LOOK ****** $min_val\t$max_val\n";
	# Generating the text file that can be used to make the heatmap image
	system("/usr/local/bin/matrix2png -data data_final.txt -bkgcolor white -mincolor darkblue -midcolor white -maxcolor darkred -missingcolor grey -s -d -r -c -size 8:8 -range $min_val:$max_val -g -u > $png_clustered_image");
	system("/usr/local/bin/matrix2png -data $txt_un_name -bkgcolor white -mincolor darkblue -midcolor white -maxcolor darkred -missingcolor grey -s -d -r -c -size 8:8 -range $min_val:$max_val -g -u > $png_un_name");

}
else{
	print "\nHey LOOK ****** $min_val\t$max_val\n";
	# Generating the text file that can be used to make the heatmap image
	system("/usr/local/bin/matrix2png -data data_final.txt -bkgcolor white -mincolor white -maxcolor darkred -missingcolor grey -s -d -r -c -size 8:8 -range $min_val:$max_val -g -u > $png_clustered_image");
	system("/usr/local/bin/matrix2png -data $txt_un_name -bkgcolor white -mincolor white -maxcolor darkred -missingcolor grey -s -d -r -c -size 8:8 -range $min_val:$max_val -g -u > $png_un_name");

}



close (OUT);

system("perl /heap/lab_website/similarity_index_dev/scripts/unclustered_download.pl $file_name_only $location_m");
system("perl /heap/lab_website/similarity_index_dev/scripts/clustered_download.pl $file_name_only $location_m");
system("perl /heap/lab_website/similarity_index_dev/scripts/network_download.pl $file_name_only $location_m");











	
	
	