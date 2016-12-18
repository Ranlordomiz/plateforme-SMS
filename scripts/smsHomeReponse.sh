#!/bin/sh

originalMessage=$1
from=$2

name=$(curl -Ss http://localhost/sms/php/readNameDatabase.php?number="$from")
rights=$(curl -Ss http://localhost/sms/php/readRightsDatabase.php?number="$from")

# Handle commands
case "$rights" in
    "0")

		reponse=$(sudo sh /home/lordroke/www/sms/scripts/smsRights0.sh "$originalMessage")

		if [ "$name" != "" ]; then
			reponse="$reponse $name-sama"
		else
			reponse="$reponse Maitre"
		fi

		reponse="$reponse."
		;;

    "1")

		reponse=$(sudo sh /home/lordroke/www/sms/scripts/smsRights1.sh "$originalMessage")

		if [ "$name" != "" ]; then
	        	reponse="$reponse $name-kun"
		fi

		reponse="$reponse."
		;;

    "2")

		reponse=$(sudo sh /home/lordroke/www/sms/scripts/smsRights2.sh "$originalMessage")

		if [ "$name" != "" ]; then
            		reponse="$reponse $name-baka"
        	fi

        	reponse="$reponse !"
        	;;

    *)
		reponse="Sensei ! Le numéro $from a tenté de contacter la plateforme à cette date `date +%Y-%m-%d:%H:%M:%S`. Le contenu de son message est le suivant : $originalMessage."
		sudo nodejs /home/lordroke/www/sms/scripts/websocketjs/websocket.js '{"type":"homeSended", "contenu":"'$( printf "%s" "$reponse" | sed 's/ /%20/g' )'", "userId":"'$(curl -Ss http://localhost/sms/php/readAdminIdDatabase.php)'"}'
		sudo sendSMS $(curl -Ss http://localhost/sms/php/readAdminNumberDatabase.php) "$reponse" "1"
		exit 0
		;;

esac

sudo nodejs /home/lordroke/www/sms/scripts/websocketjs/websocket.js '{"type":"homeSended", "contenu":"'$( printf "%s" "$reponse" | sed 's/ /%20/g' )'", "userId":"'$(curl -Ss http://localhost/sms/php/readUserIdDatabase.php?number="$from")'"}'
sudo sendSMS $from "$reponse" "1"
