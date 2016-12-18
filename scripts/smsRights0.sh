#!/bin/sh

originalMessage=$1
lowerMessage=$(echo "$originalMessage" | tr '[:upper:]' '[:lower:]')

case "$lowerMessage" in

	*"portail"*)
                reponse="Le portail s'ouvre actuellement"
		cd /home/lordroke/arduino/portail
		sudo platformio run -e uno -t upload > data.txt &
                ;;

	*"coucou"*)
	        reponse="Bonjour"
	        ;;

	*"salut"*)
	        reponse="Je vous salue"
	        ;;

	*"merci"*)
	        reponse="C'est le moins que je puisse faire pour vous"
	        ;;

	*"maitre"*)
	        reponse="Vous êtes mon Maître ô grand"
	        ;;

	*" exec "*)
		reponse="L'ordre ($(echo $originalMessage | cut -c 6-)) a bien été lancé"
		$(echo $originalMessage | cut -c 6-)
		;;

	*"shell_exec "*)
	    	reponse="L'ordre ($(echo $originalMessage | cut -c 12-)) a bien été lancé. Voici la réponse obtenue : "
	    	cmdResult=`$(echo $originalMessage | cut -c 12-)`
		reponse="$reponse $cmdResult. J'espère que cela vous convient"
		;;

	*)
		reponse="Je n'ai pas compris votre phrase : '$originalMessage'"
		;;

esac

echo $reponse
