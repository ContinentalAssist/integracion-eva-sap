#!/bin/bash

# Realiza la solicitud al API

response=$(curl -L -X GET \
  'http://68.183.54.118:8081?proceso=planes_migrar' \
  --header 'Accept: */*' \
)

#echo "$response"
echo $response >> planes_migrar.txt