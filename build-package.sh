#!/bin/bash

# Create package directories
mkdir -p ivozprovider/DEBIAN
mkdir -p ivozprovider/usr/share/ivozprovider

# Create control file
cat > ivozprovider/DEBIAN/control << 'EOC'
Package: ivozprovider
Version: 4.3.0
Section: comm
Priority: optional
Architecture: all
Maintainer: Irontec IvozProvider Team <ivozprovider@irontec.com>
Description: IvozProvider - VoIP Telephony Platform
 IvozProvider is a VoIP telephony platform designed for standalone companies,
 service providers or multi-tenant companies.
EOC

# Copy essential files
cp -r asterisk ivozprovider/usr/share/ivozprovider/
cp -r kamailio ivozprovider/usr/share/ivozprovider/
cp -r library ivozprovider/usr/share/ivozprovider/
cp -r microservices ivozprovider/usr/share/ivozprovider/
cp -r schema ivozprovider/usr/share/ivozprovider/
cp -r web ivozprovider/usr/share/ivozprovider/

# Build the package
dpkg-deb --build ivozprovider
