FROM nginx:stable-alpine

# Remove default Nginx config to avoid conflicts and ensure a clean setup
RUN rm /etc/nginx/conf.d/default.conf

# Copy custom Nginx configurations into the image
COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d/default.conf /etc/nginx/conf.d/default.conf

# Create necessary directories for Nginx state
# Permissions are set for these directories when Nginx starts as 'nginx' user by default from base image.
# If not, ensure the 'nginx' user (or the user Nginx runs as) has write access.
RUN mkdir -p /var/cache/nginx \
             /var/run/nginx \
    && chown -R nginx:nginx /var/cache/nginx /var/run/nginx \
    && chmod -R 700 /var/cache/nginx /var/run/nginx # More restrictive permissions for runtime data

# Ensure main config file is not world-writable
RUN chmod 644 /etc/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# The Nginx base image handles user and standard directory permissions (like /var/cache/nginx, /var/run/nginx).
# No need for explicit mkdir, chown, chmod for these standard Nginx directories.