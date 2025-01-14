��          �               �      �             F   1  �   x  �        �  g   �  	   #     -  �   @  
   �  [  �  �  B     �     �     �  I     �   X  �        �  ~   �  	   d	     n	  �   �	  
   ?
  �  J
   Application Server Data storage Distributed Install Each profile is in charge of performing one of the platform functions: For each of this profiles, there's a virtual package that will install all the required dependencies (see :ref:`Installing profile package`). If you want a small installation to make a couple of tests or give a basic service, we have designed all this configuration so they can work in a single machine. Installation Types IvozProvider software is designed to run distributed between multiple systems in what we call profiles: SIP Proxy StandAlone Install We have called this kind of installations **StandAlone** and we have also created :ref:`Automatic ISO CD image` so you can install in a couple of minutes. Web portal You can install as many instances as you want for each profile, but take into account, that while some of them are designed to scale horizontally (for example: asterisk or media-relays) others will require additional software so the systems that have the same profile are synchronized (for example: database replication or http request balancing). Project-Id-Version: IvozProvider 4.2
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2025-01-09 11:13+0000
PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE
Last-Translator: FULL NAME <EMAIL@ADDRESS>
Language: es
Language-Team: es <LL@li.org>
Plural-Forms: nplurals=2; plural=(n != 1)
MIME-Version: 1.0
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit
Generated-By: Babel 2.3.4
 Servidor de aplicaciones Almacenamiento de datos Instalación distribuida Cada perfil se encarga de realizar una de las funciones de la plataforma: Para cada uno de estos perfiles, hay un paquete virtual que instalará todas las dependencias requeridas (ver :ref:`Instalación del paquete de perfil <Installing profile package>`). Si desea una instalación pequeña para realizar un par de pruebas o proporcionar un servicio básico, hemos diseñado toda esta configuración para que puedan funcionar en una sola máquina. Tipos de instalación El software de IvozProvider está diseñado para ejecutarse distribuido entre múltiples sistemas en lo que llamamos perfiles: Proxy SIP Instalación StandAlone Hemos llamado a este tipo de instalaciones **StandAlone** y también hemos creado :ref:`imagen ISO CD automática<Automatic ISO CD image>` para que pueda instalar en un par de minutos. Portal web Puede instalar tantas instancias como desee para cada perfil, pero tenga en cuenta que, mientras que algunos de ellos están diseñados para escalar horizontalmente (por ejemplo: asterisk o media-relays), otros requerirán software adicional para que los sistemas que tienen el mismo perfil estén sincronizados (por ejemplo: replicación de bases de datos o balanceo de solicitudes http). 