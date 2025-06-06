FROM nginx:stable-alpine
ARG NGINX_ENV=prod
RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d/default-${NGINX_ENV}.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/cache/nginx /var/run/nginx /var/log/nginx \
    && chown -R nginx:nginx /var/cache/nginx /var/run/nginx /var/log/nginx \
    && chmod -R 755 /var/cache/nginx /var/run/nginx /var/log/nginx \
    && chmod 644 /etc/nginx/nginx.conf

EXPOSE 80
EXPOSE 443

CMD ["nginx", "-g", "daemon off;"]