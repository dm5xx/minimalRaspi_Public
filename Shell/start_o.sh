#!/bin/bash
#sudo -u root -i forever start /home/shares/ubs/app.js
sudo docker run -it --init -d -p 3000:3000 --restart unless-stopped -v /home/shares/ubs/public:/usr/local/src/public dm5xx/minimalraspi
echo "started"
