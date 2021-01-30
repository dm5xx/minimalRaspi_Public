#!/bin/bash
su -c "unzip -o /home/shares/ubs/public/Shell/default.zip -d /home/shares/ubs/public/JSON" pi
su -c "sudo chmod -R 777 /home/shares/ubs/public/JSON/" pi
echo "Update done";