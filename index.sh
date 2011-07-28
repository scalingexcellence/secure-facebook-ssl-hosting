#!/bin/bash

curl --connect-timeout 3 https://$1 &> /dev/null
if [ "$?" -eq "0" ]
then
    echo "{'message':'Your domain has ssl','dom':'$1','type':1}"
else
    nh=`host "$1" | grep "has address" | sed 's/.*ess //' | xargs host | sed -e 's/.*name pointer //' -e 's/\.$//'`
    curl --connect-timeout 3 https://$nh &> /dev/null
    if [ "$?" -eq "0" ]
    then
        echo "{'message':'Your domain doesn\'t have ssl but your server does','dom':'$nh','type':2}"
    else
        echo "{'message':'Neither your domain nor your server has ssl. You need to migrate to another server','dom':'','type':3}"
    fi
fi
