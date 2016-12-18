#!/bin/bash

TEXT=$1
userId=$2
registeredId=$3
from=$(curl -Ss http://localhost/sms/php/readNumberDatabase.php?userId=$userId)

sudo sendSMS $from "$TEXT" $3
