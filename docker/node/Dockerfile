FROM node:20

WORKDIR /var/www/html

COPY package.json package-lock.json ./

RUN npm install --legacy-peer-deps

EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host"]
