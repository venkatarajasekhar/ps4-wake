#!/bin/bash

JSON_HISTORY=120
JSON_UPDATE=/tmp/ps4-wake-$(date '+%s').json
JSON_LOG=/tmp/ps4-wake.log

rm -f /tmp/ps4-wake-*.json
ps4-wake -vP -H ps4.lan -j 2>/dev/null > $JSON_UPDATE

[ $? -ne 0 ] && exit $?

HASH_NEW=$(cat $JSON_UPDATE | sed -e 's/^.*"fingerprint":"\([0-9a-f]*\)".*$/\1/')

if [ -f $JSON_LOG ]; then
    HASH_OLD=$(head -n 1 $JSON_LOG | sed -e 's/^.*"fingerprint":"\([0-9a-f]*\)".*$/\1/')
    if [ "$HASH_NEW" != "$HASH_OLD" ]; then
        head -n $[ $JSON_HISTORY - 1 ] $JSON_LOG >> $JSON_UPDATE
        mv $JSON_UPDATE $JSON_LOG
    else
        rm $JSON_UPDATE
    fi
else
    mv $JSON_UPDATE $JSON_LOG
fi

#cat $JSON_LOG

exit 0

# vi: expandtab shiftwidth=4 softtabstop=4 tabstop=4
