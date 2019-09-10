FROM mariadb:10.4
LABEL maintainer "Patrick Baber <patrick.baber@serivvum.com>"

COPY docker/mysql/usr/local/bin/docker-healthcheck.sh /usr/local/bin/docker-healthcheck.sh

HEALTHCHECK --interval=30s --start-period=240s --timeout=5s --retries=3 \
    CMD docker-healthcheck.sh
