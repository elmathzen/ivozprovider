��    	      d               �   A   �   N   �      >     V  a   i  ^   �  �   *  �   �  �  T  I   �  V         w     �  f   �  �     �   �  �   K   **External entities** involved in RTP sessions can be divided in: Both entities exchanges RTP with the same IvozProvider entity: *media-relays*. Carriers/DDI Providers. Clients endpoints. IvozProvider implements *media-relays* using `RTPengine <https://github.com/sipwise/rtpengine>`_. Sessions initiated by SIP signalling protocol imply media streams shared by involved entities. Similar to SIP, these *media-relays* exchanges RTP when is needed with *Application Servers*, but **external entities never talk directly to them**. This media streams use `RTP <https://tools.ietf.org/html/rfc3550>`_ to send and receive the media itself, usually using UDP as a transport protocol. Project-Id-Version: IvozProvider 4.2
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
 **Entidades externas** involucradas en sesiones RTP se pueden dividir en: Ambas entidades intercambian RTP con la misma entidad de IvozProvider: *media-relays*. Operadores/Proveedores DDI. Puntos finales de clientes. IvozProvider implementa *media-relays* utilizando `RTPengine <https://github.com/sipwise/rtpengine>`_. Las sesiones iniciadas por el protocolo de señalización SIP implican flujos de medios compartidos por las entidades involucradas. Similar al SIP, estos *media-relays* intercambian RTP cuando es necesario con *Servidores de Aplicaciones*, pero **las entidades externas nunca hablan directamente con ellos**. Estos flujos de medios utilizan `RTP <https://tools.ietf.org/html/rfc3550>`_ para enviar y recibir los medios en sí, generalmente utilizando UDP como protocolo de transporte. 