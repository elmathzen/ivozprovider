��    $      <              \  _   ]  u   �  ;   3  �   o           %     F  �   _     A  h   Q  �   �     B     U     p     �  _   �  y     ]   �  i   �  �   H  <   A	     ~	     �	  �   �	  C   6
     z
  �  �
  �   ~  �   #  �   �  �  ?     �  ^   �  �   Q     �  �  �  m   m  �   �  L   c  �   �     P  !   p     �  �   �     �  z   �  �   <     �  +   �          8  v   X  �   �  ]   b  e   �    &  =   <     z  #   �  �   �  M   b     �    �  �   �  �   u  �     �  �     �!  f   �!  �   "     �"   **Automatic recordings** for the incoming/outgoing calls that use a :ref:`External DDI <ddis>`. **Incoming calls to a DDI**: The call will continue until the external dialer hangups (no matter whom is talking to). **On demand recordings** requested by a user during a call. **Outgoing calls using a DDI** as :ref:`Outgoing DDI <ddis>`: the recording will continue as long as the external destination keeps in the conversation. Activated using *DTMF* codes Activated using the *Record* key Automatic DDI recordings Beware that local legislation may enforce to announce that the call is being recorded (sometimes to both parties). You should include a recording disclaimer in your welcome locutions for DDIs with automatic recording enabled. Call recordings Contrary to automatic ones, on demand recording can be stopped using the same process that started them. Contrary to the :ref:`Services <services>` mentioned in the previous section, the on demand record are activated within a conversation. Disable recordings Enable all call recordings Enable incoming recordings Enable outgoing recordings Enabling this record mode highly affects the performance of the platform. Use at your own risk. For this recording requests, the configured code doesn't matter but the client still must have on demand records enabled. If the recording has been started on demand, it will also include the user that requested it. In this type of recording, **the whole conversation will be recorded**: from the start until it finishes. IvozProvider supports this kind of on demand record activation but with an important downside. In order to capture this codes, the pbx must process each audio packet to detect the code, avoiding the direct flow of media between the final endpoints. IvozProvider supports two different ways of recording calls: On demand recordings Record all the calls of a DDI Recording removal button is shown only if **Allow Client to remove recordings** is enabled for the client in *Client configuration*. Recordings can be heard from the *web* or downloaded in MP3 format. Recordings list Some terminals (for example, *Yealink*) support sending a `SIP INFO <https://tools.ietf.org/html/rfc6086>`_ message during the conversation with a special *Record* header (see `reference <http://www.yealink.com/Upload/document/UsingCallRecordingFeatureonYealinkPhones/UsingCallRecordingFeatureonYealinkSIPT2XPphonesRev_610-20561729764.pdf>`_). This is not a standard for the protocol, but being Yealink one of the supported manufacturers of the solution, we include this kind of on-demand recording. Take into account that the call will be recorded while the external entity is present, even it the call is being transferred between multiple users of the platform. The *client administrator* can access to all the recordings in the section **Client configuration** > **Calls** > **Call recordings**: The *on-demand* recordings must be enabled by the *brand administrator* for the clients that request it. This can be done in the client edit screen: The more traditional approach for this feature is to press a combination of keys during the call. Some notification will be played and the recording will start or stop. This combination is sent to the system using `DTMF tones <https://es.wikipedia.org/wiki/Marcaci%C3%B3n_por_tonos>`_ using the same audio stream that the conversation (as mentioned in `RFC 4733 <https://tools.ietf.org/html/rfc4733>`_). There are 4 available options: To enable this feature, edit the DDI and configure the field under the section recording data: To start or stop this kind of recordings, just press the Record key in the terminal and the system will handle the sent message. Two different scenarios: Project-Id-Version: IvozProvider 4.2
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
 **Grabaciones automáticas** para las llamadas entrantes/salientes que utilizan un :ref:`DDI externo <ddis>`. **Llamadas entrantes a un DDI**: La llamada continuará hasta que el marcador externo cuelgue (sin importar con quién esté hablando). **Grabaciones bajo demanda** solicitadas por un usuario durante una llamada. **Llamadas salientes utilizando un DDI** como :ref:`DDI saliente <ddis>`: la grabación continuará mientras el destino externo permanezca en la conversación. Activado usando códigos *DTMF* Activado usando la tecla *Grabar* Grabaciones automáticas de DDI Tenga en cuenta que la legislación local puede exigir anunciar que la llamada está siendo grabada (a veces a ambas partes). Debe incluir un aviso de grabación en sus locuciones de bienvenida para los DDIs con grabación automática habilitada. Grabaciones de llamadas A diferencia de las automáticas, la grabación bajo demanda se puede detener utilizando el mismo proceso que las inició. A diferencia de los :ref:`Servicios <services>` mencionados en la sección anterior, la grabación bajo demanda se activa dentro de una conversación. Deshabilitar grabaciones Habilitar todas las grabaciones de llamadas Habilitar grabaciones entrantes Habilitar grabaciones salientes Habilitar este modo de grabación afecta en gran medida el rendimiento de la plataforma. Úselo bajo su propio riesgo. Para estas solicitudes de grabación, el código configurado no importa, pero el cliente aún debe tener habilitadas las grabaciones bajo demanda. Si la grabación se ha iniciado bajo demanda, también incluirá al usuario que la solicitó. En este tipo de grabación, **se grabará toda la conversación**: desde el inicio hasta que termine. IvozProvider admite este tipo de activación de grabación bajo demanda, pero con una desventaja importante. Para capturar estos códigos, la pbx debe procesar cada paquete de audio para detectar el código, evitando el flujo directo de medios entre los puntos finales finales. IvozProvider admite dos formas diferentes de grabar llamadas: Grabaciones bajo demanda Grabar todas las llamadas de un DDI El botón de eliminación de grabaciones se muestra solo si **Permitir al cliente eliminar grabaciones** está habilitado para el cliente en *Configuración del cliente*. Las grabaciones se pueden escuchar desde la *web* o descargar en formato MP3. Lista de grabaciones Algunos terminales (por ejemplo, *Yealink*) admiten el envío de un mensaje `SIP INFO <https://tools.ietf.org/html/rfc6086>`_ durante la conversación con un encabezado especial *Grabar* (ver `referencia <http://www.yealink.com/Upload/document/UsingCallRecordingFeatureonYealinkPhones/UsingCallRecordingFeatureonYealinkSIPT2XPphonesRev_610-20561729764.pdf>`_). Esto no es un estándar para el protocolo, pero siendo Yealink uno de los fabricantes compatibles con la solución, incluimos este tipo de grabación bajo demanda. Tenga en cuenta que la llamada se grabará mientras la entidad externa esté presente, incluso si la llamada se transfiere entre varios usuarios de la plataforma. El *administrador del cliente* puede acceder a todas las grabaciones en la sección **Configuración del cliente** > **Llamadas** > **Grabaciones de llamadas**: Las grabaciones *bajo demanda* deben ser habilitadas por el *administrador de la marca* para los clientes que lo soliciten. Esto se puede hacer en la pantalla de edición del cliente: El enfoque más tradicional para esta función es presionar una combinación de teclas durante la llamada. Se reproducirá una notificación y la grabación comenzará o se detendrá. Esta combinación se envía al sistema utilizando `tonos DTMF <https://es.wikipedia.org/wiki/Marcaci%C3%B3n_por_tonos>`_ utilizando el mismo flujo de audio que la conversación (como se menciona en `RFC 4733 <https://tools.ietf.org/html/rfc4733>`_). Hay 4 opciones disponibles: Para habilitar esta función, edite el DDI y configure el campo en la sección de datos de grabación: Para iniciar o detener este tipo de grabaciones, simplemente presione la tecla Grabar en el terminal y el sistema manejará el mensaje enviado. Dos escenarios diferentes: 