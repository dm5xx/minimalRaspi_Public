#!/bin/bash
sudo -u pi find /home/shares/ubs/public/Shell -type f -print0 | xargs -0 sudo -u pi dos2unix
echo "Conversion finished!"