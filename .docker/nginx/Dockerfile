FROM nginx:stable-alpine

# Remove default config to ensure a clean setup
RUN rm -f /etc/nginx/conf.d/default.conf

# Copy the main nginx.conf and the PRODUCTION default.conf
# For development, docker-compose-dev.yml will mount the dev config over this.
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/conf.d/default-prod.conf /etc/nginx/conf.d/default.conf

# Create log directory. Cache and run directories are handled by the base image.
RUN mkdir -p /var/log/nginx && chown -R nginx:nginx /var/log/nginx

# Set correct permissions for config files
RUN chmod 644 /etc/nginx/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
EXPOSE 443

CMD ["nginx", "-g", "daemon off;"]