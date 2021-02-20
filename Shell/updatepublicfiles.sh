#!/bin/bash
sudo git -C /home/shares/ubs/public/ fetch --all https://github.com/dm5xx/minimalRaspi_Public.git
sudo git -C /home/shares/ubs/public/ reset --hard origin/master
sudo git -C /home/shares/ubs/public/ pull https://github.com/dm5xx/minimalRaspi_Public.git
echo "Public Update done - please start Server";