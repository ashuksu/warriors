FROM node:20-alpine

WORKDIR /app

# Copy package.json and install dependencies
COPY package*.json ./
RUN npm install

# Copy the rest of the application code
COPY . .

# Expose Vite dev server port
EXPOSE 5173

# Default command to start Vite dev server
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]