��    )      d              �  
   �  ^   �          +     D  (   ^  (   �  O   �  \      	   ]     g     m     �  \   �     �  �        �     �     �  <   �  #   ;  H   _  $   �     �  0   �  d     �   }  '     5   9     o     v     }     �  	   �     �  
   �     �     �     �  	   �  �  �  
   T
  s   _
      �
  #   �
       .   1  /   `  P   �  V   �  
   8     C     W     v  p   �     �  �        �  %        *  D   >  %   �  e   �  -     *   =  3   h  q   �  �     .   �  ;         <     D     M     T  
   Z  	   e     o     �     �     �  	   �   CSV fields Calculated price for the given call (empty if *Display billing details to client* is disabled) Call CSV schedulers Call duration in seconds Call-ID of the SIP dialog Callee number in E.164 format (with '+') Caller number in E.164 format (with '+') Defines the frequency (once a month, every 7 days, etc.) of the programmed task Defines which calls should be included attending to its direction (inbound, outbound, both). Direction Email Empty for wholesale clients Frequency/Unit Generated CSVs of each scheduler can be accessed in **List of Call CSV reports** subsection. Last execution Modifying *Next execution* value allows forcing specific runs. For example, setting *Next execution* to current month's first day will create again last month's CSV report (for a monthly scheduler). Name Name of the scheduled Call CSV Next execution Once created, some new fields and subsections are accesible: Possible values: inbound, outbound. Send generated Call CSV via email. Empty if no automatic mail is wanted. Shows last execution and its result. Shows next execution date These are the fields of the generated CSV files: This section allows programming automatic periodical CSV reports to wholesale client administrators. This section is almost identical to :ref:`Invoice schedulers` except to the fields that do not apply to CSVs (Invoice number sequence, Tax rate...) Time and date of the call establishment When adding a new definition, these fields are shown: callee caller callid ddiId direction duration endpointId endpointName endpointType price startTime Project-Id-Version: IvozProvider 4.2
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
 Campos CSV Precio calculado para la llamada dada (vacío si *Mostrar detalles de facturación al cliente* está deshabilitado) Programadores de CSV de llamadas Duración de la llamada en segundos Call-ID del diálogo SIP Número del llamado en formato E.164 (con '+') Número del llamante en formato E.164 (con '+') Define la frecuencia (una vez al mes, cada 7 días, etc.) de la tarea programada Define qué llamadas deben incluirse según su dirección (entrante, saliente, ambas). Dirección Correo electrónico Vacío para clientes wholesale Frecuencia/Unidad Los CSV generados de cada programador se pueden acceder en la subsección **Lista de informes CSV de llamadas**. Última ejecución Modificar el valor de *Próxima ejecución* permite forzar ejecuciones específicas. Por ejemplo, establecer *Próxima ejecución* al primer día del mes actual creará nuevamente el informe CSV del mes pasado (para un programador mensual). Nombre Nombre del CSV de llamadas programado Próxima ejecución Una vez creado, algunos campos y subsecciones nuevos son accesibles: Valores posibles: entrante, saliente. Enviar el CSV de llamadas generado por correo electrónico. Vacío si no se desea correo automático. Muestra la última ejecución y su resultado. Muestra la fecha de la próxima ejecución Estos son los campos de los archivos CSV generados: Esta sección permite programar informes CSV periódicos automáticos para administradores de clientes wholesale. Esta sección es casi idéntica a :ref:`Programadores de facturas <Invoice schedulers>` excepto por los campos que no se aplican a los CSV (secuencia de número de factura, tasa de impuestos...) Hora y fecha del establecimiento de la llamada Al agregar una nueva definición, se muestran estos campos: llamado llamante callid ddiId dirección duración ID de punto final nombre del punto final tipo de punto final precio startTime 