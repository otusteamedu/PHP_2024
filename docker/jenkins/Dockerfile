FROM jenkins/jenkins:lts-jdk17

USER root

# Установка docker, git, sudo
RUN apt-get update && \
    apt-get install -y docker.io git sudo && \
    usermod -aG docker jenkins

# Возвращаемся к jenkins пользователю
USER jenkins
