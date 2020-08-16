BEGIN {
   FS=","
}
{
   if(NR > 1)
   {
      for(i=1; i <= NF; i++)
      {
         if(length($i) > collen[i])
         {  
            collen[i]=length($i);
            coltext[i]=$i;
         }
      }
   }
}
END {
   for(len in collen)
   {
      printf("Column %d = %d (%s)\n", len, collen[len], coltext[len]);
   }
}
