cut --fields=3,4 --delim=' ' cities.txt | awk '{a[$1] += $2} END{for (i in a) print a[i],i}' | sort -r | sed -n '1,3 p'



#awk '{
#	items[$4]+=$3
#}
#END {
#	asorti(items, sorted)
#	for (i in sorted) 
#		print items[sorted[i]] " " sorted[i]
#}' < cities.txt

#< cities.txt sort -k4,4gr |uniq -c 
#sort -k3 -u
#-k3,3g -u
