FROM nginx:1.17-alpine

COPY ./snippets /etc/nginx/snippets
COPY ./conf.d /etc/nginx/conf.d
COPY ./certificate /etc/nginx/certificate

WORKDIR /app
