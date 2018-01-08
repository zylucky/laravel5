#!/usr/bin/expect -f
set timeout 3                       
spawn ssh root@47.92.138.25 
expect "*password:*"                
send "YS@admin\r"                
send "sudo -s\r"
expect "*]#"
send "./liyuequn.sh\r"
send "exit\r"              
interact   
