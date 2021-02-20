#!/bin/bash
sudo git -C /home/shares/ubs/public/ fetch --all
sudo git -C /home/shares/ubs/public/ reset --hard origin/master
echo "Public Update done - please start Server";