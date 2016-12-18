#!/bin/sh
from=$SMS_1_NUMBER
originalMessage=$SMS_1_TEXT
reponse=""

originalMessage=$( printf "%s" "$originalMessage" | sed ':a;N;$!ba;s/\n/<br>/g' )
lowerMessage=$(echo "$originalMessage" | tr '[:upper:]' '[:lower:]')
echo "$originalMessage" > /home/lordroke/www/sms/scripts/data.txt

# Get user info OR create user
userId=$(curl -Ss http://localhost/sms/php/readUserIdDatabase.php?number="$from")
if [ "$userId" -eq "-1" ]; then
	curl -Ss http://localhost/sms/php/addUserDatabase.php?number="$from"\&rights="2"
	userId=$(curl -Ss http://localhost/sms/php/readUserIdDatabase.php?number="$from")
fi

# Add message received to database & draw in IHM
sudo sh /home/lordroke/www/sms/scripts/smsAddDatabase.sh "$originalMessage" "$userId"
sudo nodejs /home/lordroke/www/sms/scripts/websocketjs/websocket.js '{"type":"received", "contenu":"'$( printf "%s" "$originalMessage" | sed 's/ /%20/g' )'", "userId":"'$userId'"}'

# If @home deal with it
if [ "$(echo $lowerMessage | cut -c 1-6)" = "@home " ]; then
	sudo sh /home/lordroke/www/sms/scripts/smsHomeReponse.sh "$(echo $originalMessage | cut -c 7-)" "$from" "$rights"
fi
