#!/bin/bash
 sudo -u root -i forever stopall
 #sudo docker rm $(sudo docker stop $(sudo docker ps -a -q --filter ancestor=dm5xx/minimalraspi --format="{{.ID}}"))
 echo "Stopped!"