docker run \
--name sudo_api_dev \
--rm --interactive --tty \
--mount type=bind,src=`pwd`,dst=/srv \
--publish 8000:8000 --publish 3000:3000 \
sudouc/api.sudo.org.au-dev:latest || \
docker start sudo_api_dev
