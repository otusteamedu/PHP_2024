sed '1d' cities.txt > c.txt
sed '/^$/d' c.txt > d.txt
cut --fields=3 --delim=' ' d.txt > e.txt
awk '{print 1,$0}' e.txt > f.txt
awk '{a[$2] += $1} END{for (i in a) print a[i],i}' f.txt | sort -r | sed -n '1,3 p'
rm c.txt
rm d.txt
rm e.txt
rm f.txt 

#sed '/^$/d' cities.txt
#awk '{a[$1] += $2} END{for (i in a) print a[i],i}' | sort -r | sed -n '1,3 p'



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
