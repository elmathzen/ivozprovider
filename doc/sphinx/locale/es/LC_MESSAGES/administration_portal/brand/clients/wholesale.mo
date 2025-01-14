��    0      �                r     �   �  ~   I  �   �     J     a  �   x  g   X     �     �  P   �  4   2  }   g     �     �  U   �  6   U     �  2   �     �  �   �     l	     �	  �   �	  1   
  	   E
     O
     _
  r   d
  x   �
     P     g  �   t  M   r     �  F   �  B   &  �   i  �   �  N   z  '   �  0   �  )   "  E   L  	   �  R   �  ?   �  �  /  �   �  �   3  �   -  �   �     l     �  �   �  �   �     ,     H  m   `  K   �  �        �     �  a   �  <   '     d  >   x     �  �   �     �     �  �   �  :   F     �     �     �  �   �  �   C     �     �  4    o   @  )   �  Y   �  I   4  �   ~  �     Y   �  ;   &   ;   b   4   �   H   �   	   !  ]   &!  J   �!   **List of authorized sources**: client identification will be made looking up the source IP address in this table. **List of client admins**: this subsection allows managing portal credentials for this specific client. Read :ref:`acls` for further explanation about restricted client administrators. **List of rating profiles**: this subsection allows managing the rating profiles that will be used to bill its outgoing calls. A notification email will be sent to given address when configured max daily usage is reached. Leave empty to avoid notification. Adding/Editing clients Additional subsections All the fields in this group will be included in invoices generated for this client. This section also allows showing/hiding billing details to client's portal, such as Invoices, Rating Profiles and Price of external calls. Apart from these fields, main operator (*aka* God) will also see a **Platform data** group that allows: Audio transcoding Billing method Calls go directly from users to trunks, without any application server involved. Choosing an specific media relay set for the client. Chosen currency will be used in price calculation, invoices, balance movements and remaining money operations of this client. Currency Default timezone Describes the way the client will "talk" and the way the client wants to be "talked". Each entry in this table has these additional options: Email IP authentication only (no register, no SIP auth). Invoice data It allows trunking services with Carriers without any application server features, focusing on concurrency and quality rather on having lots of services. Just make outgoing calls. Language Limits external outbound calls when this limit is reached within a day. At midnight counters are reset and accounts are re-enabled. Limits outgoing external calls (0 for unlimited). Max calls Max daily usage Name No outgoing call will be allowed for this client unless an active rating profiles that can bill the specific call. No users, no extensions, no internal calls, no DDIs, no voicemail, no call forwards... just **outgoing external calls**. Numeric transformation Routing tags Selecting codecs in **Audio transcoding** may lead to uneeded transcoding. Selecting ALL codecs is always a horrible idea. Do not select any codec unless this client does not support an specific codec that is compulsory for a needed destination/carrier. Some fields described below may not be visible depending on enabled features. Support for audio transcoding. Support for routing tags (client can choose the outgoing route to use) These are the fields shown when **adding** a new wholesale client: This field allows enabling codecs for this specific client. This codecs will be added to the ones offered by the client in its SDP. This field allows enabling routing tags for this specific client. Call preceded with this routing tags will be rated and routed differently. To choose among postpaid, prepaid and pseudo-prepaid. 'none' disables billing. Used for showing call registries dates. Used to choose the language of played locutions. Used to reference this particular client. When **editing** a client, these additional fields can be configured: Wholesale Wholesale clients **do not need to use Brand's SIP domain in their SIP messages**. Wholesale clients are the simplest client type in IvozProvider. Project-Id-Version: IvozProvider 4.2
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
 **Lista de fuentes autorizadas**: la identificación del cliente se realizará buscando la dirección IP de origen en esta tabla. **Lista de administradores de clientes**: esta subsección permite gestionar las credenciales del portal para este cliente específico. Lea :ref:`controles de acceso <acls>` para una mayor explicación sobre administradores de clientes restringidos. **Lista de perfiles de tarifas**: esta subsección permite gestionar los perfiles de tarifas que se utilizarán para facturar sus llamadas salientes. Se enviará un correo electrónico de notificación a la dirección dada cuando se alcance el uso máximo diario configurado. Dejar vacío para evitar la notificación. Agregar/Editar clientes Subsecciones adicionales Todos los campos de este grupo se incluirán en las facturas generadas para este cliente. Esta sección también permite mostrar/ocultar detalles de facturación en el portal del cliente, como Facturas, Perfiles de Tarifas y Precio de llamadas externas. Aparte de estos campos, el operador principal (*también conocido como* Dios) también verá un grupo de **Datos de la plataforma** que permite: Transcodificación de audio Método de facturación Las llamadas van directamente de los usuarios a los trunks, sin ningún servidor de aplicaciones involucrado. Elegir un conjunto específico de retransmisión de medios para el cliente. La moneda elegida se usará en el cálculo de precios, facturas, movimientos de saldo y operaciones de dinero restante de este cliente. Moneda Zona horaria predeterminada Describe la forma en que el cliente "hablará" y la forma en que el cliente quiere ser "hablado". Cada entrada en esta tabla tiene estas opciones adicionales: Correo electrónico Solo autenticación IP (sin registro, sin autenticación SIP). Datos de la factura Permite servicios de trunking con Carriers sin ninguna característica de servidor de aplicaciones, enfocándose en la concurrencia y la calidad en lugar de tener muchos servicios. Solo hacer llamadas salientes. Idioma Limita las llamadas externas salientes cuando se alcanza este límite dentro de un día. A medianoche se restablecen los contadores y se reactivan las cuentas. Limita las llamadas externas salientes (0 para ilimitado). Máximo de llamadas Uso máximo diario Nombre No se permitirá ninguna llamada saliente para este cliente a menos que haya un perfil de tarifas activo que pueda facturar la llamada específica. Sin usuarios, sin extensiones, sin llamadas internas, sin DDI, sin correo de voz, sin desvíos de llamadas... solo **llamadas externas salientes**. Transformación numérica Etiquetas de enrutamiento Seleccionar códecs en **Transcodificación de audio** puede llevar a una transcodificación innecesaria. Seleccionar TODOS los códecs siempre es una idea horrible. No selecciones ningún códec a menos que este cliente no soporte un códec específico que sea obligatorio para un destino/carrier necesario. Algunos campos descritos a continuación pueden no ser visibles dependiendo de las funcionalidades habilitadas. Soporte para transcodificación de audio. Soporte para etiquetas de enrutamiento (el cliente puede elegir la ruta de salida a usar) Estos son los campos mostrados al **agregar** un nuevo cliente mayorista: Este campo permite habilitar códecs para este cliente específico. Estos códecs se agregarán a los ofrecidos por el cliente en su SDP. Este campo permite habilitar etiquetas de enrutamiento para este cliente específico. Las llamadas precedidas por estas etiquetas de enrutamiento se calificarán y enrutarán de manera diferente. Para elegir entre pospago, prepago y pseudo-prepago. 'ninguno' desactiva la facturación. Usado para mostrar las fechas de los registros de llamadas. Usado para elegir el idioma de las locuciones reproducidas. Usado para referenciar a este cliente en particular. Al **editar** un cliente, se pueden configurar estos campos adicionales: Wholesale Los clientes mayoristas **no necesitan usar el dominio SIP de la marca en sus mensajes SIP**. Los clientes Wholesale son el tipo de cliente más simple en IvozProvider. 