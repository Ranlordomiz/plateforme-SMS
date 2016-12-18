#!/bin/sh

message=$1
userId=$2

message=$( printf "%s" "$message" | sed 's/ /%20/g' )
message=$( printf "%s" "$message" | sed 's/\x27/\\%27/g' )
message=$( printf "%s" "$message" | sed 's/\x22/\\%22/g' )

curl -Ss http://localhost/sms/php/addMessageReceivedDatabase.php?userId="$userId"\&message="$message"