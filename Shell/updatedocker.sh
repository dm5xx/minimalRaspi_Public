#!/bin/bash
sudo docker rm -f $(sudo docker ps -aq)
sudo docker system prune -a -f
sudo docker pull dm5xx/minimalraspi

echo "Update done - please start Server";