#!/bin/bash
# Created the 07/08/2024
# This script helps to start properly the app inside a container
#   - It checks if mandatory variable are presents
#   - It forces the app to reload the env variables
#   - It creates database schema if asked
#   - It starts the app

#####
# APP parameters
echo "---------------------------"
echo "> Creating env file..."

if [[ -z "${APP_ENV}" ]]; then
  echo "APP_ENV=production" >> ".env"
else
  echo "APP_ENV=${APP_ENV}" >> ".env"
fi

if [[ -z "${APP_KEY}" ]]; then
  echo "APP_KEY is mandatory. Please generate it by running `php artisan key:generate --show`"
  exit 1
else
  echo "APP_KEY=${APP_KEY}" >> ".env"
fi

if [[ -z "${APP_URL}" ]]; then
  echo "APP_URL='http://localhost:8000'" >> ".env"
else
  echo "APP_URL=${APP_URL}" >> ".env"
fi

if [[ -z "${APP_NAME}" ]]; then
  echo "APP_NAME='For the drama fork'" >> ".env"
else
  echo "APP_NAME='${APP_NAME}'" >> ".env"
fi

#####
# DB parameters
if [[ -z "${DB_CONNECTION}" ]]; then
  echo "DB_CONNECTION is mandatory"
  exit 1
else
  echo "DB_CONNECTION=${DB_CONNECTION}" >> ".env"
fi

if [[ -z "${DB_DATABASE}" ]]; then
  echo "DB_DATABASE is mandatory"
  exit 1
else
  echo "DB_DATABASE=${DB_DATABASE}" >> ".env"
fi

if [[ -z "${DB_HOST}" ]]; then
  echo "DB_HOST is mandatory"
  exit 1
else
  echo "DB_HOST=${DB_HOST}" >> ".env"
fi

if [[ -z "${DB_USERNAME}" ]]; then
  echo "DB_USERNAME is mandatory"
  exit 1
else
  echo "DB_USERNAME=${DB_USERNAME}" >> ".env"
fi

if [[ -z "${DB_PASSWORD}" ]]; then
  echo "DB_PASSWORD is mandatory"
  exit 1
else
  echo "DB_PASSWORD=${DB_PASSWORD}" >> ".env"
fi

if [[ -z "${DB_PORT}" ]]; then
  echo "DB_PORT is mandatory"
  exit 1
else
  echo "DB_PORT=${DB_PORT}" >> ".env"
fi

#####
# MAIL parameters
if [[ -z "${MAIL_DRIVER}" ]]; then
  echo "MAIL_DRIVER=smtp" >> ".env"
else
  echo "MAIL_DRIVER=${MAIL_DRIVER}" >> ".env"
fi

if [[ -z "${MAIL_ENCRYPTION}" ]]; then
  echo "MAIL_ENCRYPTION=TLS" >> ".env"
else
  echo "MAIL_ENCRYPTION=${MAIL_ENCRYPTION}" >> ".env"
fi

if [[ -z "${MAIL_FROM}" ]]; then
  echo "MAIL_FROM=hello@exemple.com" >> ".env"
else
  echo "MAIL_FROM=${MAIL_FROM}" >> ".env"
fi

if [[ -z "${MAIL_HOST}" ]]; then
  echo "MAIL_HOST is mandatory"
  exit 1
else
  echo "MAIL_HOST=${MAIL_HOST}" >> ".env"
fi

if [[ -z "${MAIL_USERNAME}" ]]; then
  echo "MAIL_USERNAME is mandatory"
  exit 1
else
  echo "MAIL_USERNAME=${MAIL_USERNAME}" >> ".env"
fi

if [[ -z "${MAIL_PASSWORD}" ]]; then
  echo "MAIL_PASSWORD is mandatory"
  exit 1
else
  echo "MAIL_PASSWORD=${MAIL_PASSWORD}" >> ".env"
fi

if [[ -z "${MAIL_PORT}" ]]; then
  echo "MAIL_PORT=587" >> ".env"
else
  echo "MAIL_PORT=${MAIL_PORT}" >> ".env"
fi

#####
# DEBUG parameters
if [[ -z "${APP_DEBUG}" ]]; then
  echo "APP_DEBUG=false" >> ".env"
else
  echo "APP_DEBUG=${APP_DEBUG}" >> ".env"
fi

if [[ -z "${DEBUGBAR_ENABLED}" ]]; then
  echo "DEBUGBAR_ENABLED=false" >> ".env"
else
  echo "DEBUGBAR_ENABLED=${DEBUGBAR_ENABLED}" >> ".env"
fi

#####
# Redis parameters
if [[ -z "${REDIS_HOST}" ]]; then
  echo "REDIS_HOST=127.0.0.1" >> ".env"
else
  echo "REDIS_HOST=${REDIS_HOST}" >> ".env"
fi

if [[ -z "${REDIS_PASSWORD}" ]]; then
  echo "REDIS_PASSWORD=null" >> ".env"
else
  echo "REDIS_PASSWORD=${REDIS_PASSWORD}" >> ".env"
fi

if [[ -z "${REDIS_PORT}" ]]; then
  echo "REDIS_PORT=6379" >> ".env"
else
  echo "REDIS_PORT=${REDIS_PORT}" >> ".env"
fi

#####
# Other parameters
if [[ -z "${BROADCAST_DRIVER}" ]]; then
  echo "BROADCAST_DRIVER=log" >> ".env"
else
  echo "BROADCAST_DRIVER=${BROADCAST_DRIVER}" >> ".env"
fi

if [[ -z "${CACHE_DRIVER}" ]]; then
  echo "CACHE_DRIVER=file" >> ".env"
else
  echo "CACHE_DRIVER=${CACHE_DRIVER}" >> ".env"
fi

if [[ -z "${LOG_CHANNEL}" ]]; then
  echo "LOG_CHANNEL=stack" >> ".env"
else
  echo "LOG_CHANNEL=${LOG_CHANNEL}" >> ".env"
fi

if [[ -z "${SESSION_DRIVER}" ]]; then
  echo "SESSION_DRIVER=file" >> ".env"
else
  echo "SESSION_DRIVER=${SESSION_DRIVER}" >> ".env"
fi

if [[ -z "${SESSION_LIFETIME}" ]]; then
  echo "SESSION_LIFETIME=480" >> ".env"
else
  echo "SESSION_LIFETIME=${SESSION_LIFETIME}" >> ".env"
fi

if [[ -z "${QUEUE_CONNECTION}" ]]; then
  echo "QUEUE_CONNECTION=sync" >> ".env"
else
  echo "QUEUE_CONNECTION=${QUEUE_CONNECTION}" >> ".env"
fi

# TODO : integrate or not the following parameters if needed
# MIX_PUSHER_APP_CLUSTER=mt1
# MIX_PUSHER_APP_KEY=
# PUSHER_APP_CLUSTER=mt1
# PUSHER_APP_ID=
# PUSHER_APP_KEY=
# PUSHER_APP_SECRET=

# Force the app to reload the env file
echo "> Reloading app config file..."
php artisan config:cache

# Create database schema if asked
if [[ -z "${DB_CREATESCHEMA}" ]]; then
  echo ""
else
  echo "> Creating database schema..."
  php artisan migrate:refresh --seed --force || true
fi

# Start the app
echo "> Starting the app..."
php artisan serve --host=0.0.0.0 --port=8000