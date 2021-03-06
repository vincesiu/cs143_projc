#!/bin/bash -ex

#########################################
# INIT
#########################################

SCRIPT_URL="http://oak.cs.ucla.edu/classes/cs143/project/p1c_test"
ZIP_NAME="P1C.zip"
REQUIRED_FILES=( \
        team.txt \
        readme.txt \
        sql \
        www \
        testcase \
        )

function cleanup {
    rm -rf 904280752
    echo "Finished deploy script"
}

trap cleanup EXIT

#########################################
# MAIN
#########################################

echo "Running deploy script..."


### Deploying up webpages
rsync -a ./www/* ~/www/

FILE_LIST=$(echo ~/www/t{1..5}.html)
for file in $FILE_LIST; do
    if [[ -e $file ]]; then
        cp $file ~/cs143_proj1c/testcase/
    fi
done


if [[ "$1" == '--reset' ]]; then
    ### Reseting db
    echo "DROP TABLE IF EXISTS MovieDirector, MovieGenre, Review, MovieActor, MaxPersonID, MaxMovieID, Movie, Actor, Director"  | mysql CS143
    mysql CS143 < ./sql/create.sql
    mysql CS143 < ./sql/load.sql
fi

if [[ "$1" == '--submit' ]]; then
    mkdir 904280752
    cp -r ${REQUIRED_FILES[@]} 904280752
    zip -r ${ZIP_NAME} 904280752/
    rm -rf 904280752
    bash <(curl -sL ${SCRIPT_URL}) 904280752
    if [[ $? -eq 0 ]]; then
        mv ${ZIP_NAME} ~/www/ 
    fi
fi
