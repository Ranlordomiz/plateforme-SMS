#!/bin/sh

originalMessage=$1
lowerMessage=$(echo "$originalMessage" | tr '[:upper:]' '[:lower:]')

case "$lowerMessage" in

   	*"merci"*)
        reponse="Easy"
        ;;

	*"maitre"*)
        reponse="Mon seul maitre est Adrien"
        ;;

	*" oris"*)
        reponse="Stargate c'est un peu nul"
        ;;

	*)
		reponse="J'ai pas compris"
		;;
esac

echo $reponse