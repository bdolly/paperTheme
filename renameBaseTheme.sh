#!/bin/sh
printf "What do you want to name your TPD_BaseTheme theme? "
read -e NAME
cd ../ && mv BaseTheme $NAME
find ./$NAME/ -type f | xargs perl -pi -e "s/'TPD_BaseTheme'/'$NAME'/g"
find ./$NAME/ -type f | xargs perl -pi -e "s//$NAME_/g"
find ./$NAME/ -type f | xargs perl -pi -e "s/ TPD_BaseTheme/ $NAME/g"
