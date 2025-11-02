FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install --quiet --yes --no-install-recommends \
        libzip-dev \
        wget \
        gnupg \
        libpq-dev \
        chromium \
        chromium-driver \
        unzip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install zip pdo sockets \
    && pecl update-channels \
    && apt-get clean autoclean \
    && apt-get autoremove --yes

# chromedriver - Install google chrome
RUN wget -q -O /usr/share/keyrings/google-linux-signing-key.gpg https://dl-ssl.google.com/linux/linux_signing_key.pub \
 && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/google-linux-signing-key.gpg] http://dl.google.com/linux/chrome/deb/ stable main" \
    > /etc/apt/sources.list.d/google-chrome.list \
 && apt-get update \
 && apt-get install -y google-chrome-stable

# chromedriver - install chromedriver
RUN apt-get install -yqq unzip
RUN wget -O /tmp/chromedriver.zip http://chromedriver.storage.googleapis.com/`curl -sS chromedriver.storage.googleapis.com/LATEST_RELEASE`/chromedriver_linux64.zip
RUN unzip /tmp/chromedriver.zip chromedriver -d /usr/local/bin/

# chromedriver - set display port to avoid crash
ENV DISPLAY=:99

RUN rm -rf /var/lib/{apt,dpkg,cache,log}/ \
    && apt remove apt --autoremove -y --allow-remove-essential

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -g appuser \
    -G www-data,root --shell /bin/bash \
    --create-home appuser

USER appuser
