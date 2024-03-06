#!/bin/bash

# Realiza la solicitud al API

response=$(curl -L -X GET \
  'http://68.183.54.118:8081?proceso=limpiar_tablas_psql' \
  --header 'Accept: */*' \
)
#echo $response >> log_limpiar_tablas.txt
echo "$response"

