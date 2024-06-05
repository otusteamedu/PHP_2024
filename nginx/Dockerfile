FROM nginx

COPY hw1.conf /etc/nginx/conf.d/hw1.conf

ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

CMD [ "nginx", "-g", "daemon off;" ]