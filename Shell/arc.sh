#!/bin/bash
#sudo tar -cvpzf ../JsonArc/json_$(date +"%Y-%m-%d").tar.gz ../JSON
sudo tar -cvpzf ../JsonArc/json_$1.tar.gz ../JSON
echo "Update done";