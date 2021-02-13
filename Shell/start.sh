#!/bin/bash
sudo docker run -it --init -p 3000:3000 --privileged --restart unless-stopped -v /home/shares/ubs/public:/usr/local/src/public dm5xx/minimalraspi
echo "started"