#!/bin/bash

# Realiza la solicitud al API

response=$(curl -L -X GET \
  'http://68.183.54.118:8081?proceso=migracionContinua' \
  --header 'Accept: */*' \
)

echo "$response"
