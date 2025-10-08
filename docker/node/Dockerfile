FROM node:20

WORKDIR /var/www/html

# Копіюємо package.json та package-lock.json
COPY package.json package-lock.json ./

# Встановлюємо залежності через npm
RUN npm install --legacy-peer-deps

# Експортуємо порт Vite (5173)
EXPOSE 5173

# Запуск Vite для розробки
CMD ["npm", "run", "dev", "--", "--host"]
