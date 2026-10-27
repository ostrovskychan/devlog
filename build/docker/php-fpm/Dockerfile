
# Base Image; Put all shared dependency here:
FROM php:8.5.12-fpm-alpine3.23@sha256:c60c905773d759f00e5812fb18fc0960aab7cdcb056ad4ca9d3f13722bbc7ebd as base
WORKDIR /var/www/html

# CI include composer, so It could be called for scripts
FROM base as ci
WORKDIR /var/www/html

COPY --from=composer:2@sha256:5946476338742b200bb9ff88f8be56275ddae4b3949c72305cb0dbf10cfcb760 \
    /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --prefer-dist \
    --no-scripts \
    --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

FROM base as production
WORKDIR /var/www/html

COPY --from=composer:2.2.30@sha256:db5a72680c556826fdf498dc16e67b55c10da56928de06929cbc431b81271efb \
	/usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --classmap-authoritative

COPY --chown=www-data:www-data . .

# Clean up
RUN rm /usr/bin/composer

# Provide port
ARG EXPOSED_PORT
EXPOSE ${EXPOSED_PORT}

ARG BUILD_HASH=unknown
ARG BUILD_DATE=unknown
ARG APP_SEMVER_VERSION=0.0.0

ENV APP_BUILD_HASH=${BUILD_HASH} \
    APP_BUILD_DATE=${BUILD_DATE} \
    APP_VERSION=${APP_SEMVER_VERSION}

LABEL org.opencontainers.image.created="${BUILD_DATE}" \
      org.opencontainers.image.title="Devlog" \
      org.opencontainers.image.version="${APP_SEMVER_VERSION}" \
      org.opencontainers.image.revision="${BUILD_HASH}"

CMD ["php-fpm"]
