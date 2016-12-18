#!/bin/sh

originalMessage=$1
lowerMessage=$(echo "$originalMessage" | tr '[:upper:]' '[:lower:]')

case "$lowerMessage" in

	*)
		reponse="Easy"
		;;
esac

echo $reponse