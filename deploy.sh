#!/bin/sh
rsync -avz ./ -e "ssh -p 5022"  146.88.236.123:~/public_html/scc-tool --include=public/build --include=public/bundles --include=public/.htaccess --include=vendor --exclude-from=.gitignore --exclude=".*" --exclude="public/images"