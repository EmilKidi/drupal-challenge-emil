FROM phusion/baseimage:0.11

# Expose apache.
EXPOSE 80

# Install Apache and the required modules.
RUN \
    apt-get -q update && \
    apt-get -q install \
        apache2 \
        nano \
            -y -o Dpkg::Options::="--force-confold"

# Delete the default configuration files for Apache.
RUN \
    rm -f /etc/apache2/sites-available/* \
    && rm /etc/apache2/apache2.conf

COPY \
    /etc /etc/

# Enable all the configuration files.
RUN \
    ln -s /etc/apache2/sites-available/* /etc/apache2/sites-enabled/

# Ensure that the service symlink is working.
RUN \
    rm -rf /etc/service && \
    ln -sf /etc/runit/runsvdir/default /etc/service