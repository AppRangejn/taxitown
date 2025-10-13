FROM node:20

WORKDIR /var/www/html

# Копіюємо package.json і package-lock.json
COPY package.json package-lock.json ./

RUN npm install --legacy-peer-deps

EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host"]
