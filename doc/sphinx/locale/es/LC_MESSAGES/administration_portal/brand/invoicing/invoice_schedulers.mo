��    +      t              �  K   �  q     Q   �  J   �     (     6  O   =  U   �     �  >   �  $   (  #   M     q     }     �  H   �  I   �     4     L  f   _  t   �  =   ;  ]   y     �     �  j   �  f   e  c   �    0	  _   O
  Y   �
  \   	  H   f     �  )   �  N   �  �   1  �     /   �  5   �  V     %   \  �  �  [     �   `  ]   �  e   B     �     �  P   �  g          L   �  %   �  (        /     <     V  Q   h  W   �          2  �   L  �   �  O   W  ]   �            �   ,  �   �  �   J  :  �  w     n   �  h   �  \   ]     �  5   �  R     �   U  �   R  5      ;   6  ^   r  -   �   **Next execution** value can be mangled, but generated invoice always will: *In date* will be *out date* minus X week(s), X month(s) or X year(s) (X equals to *Frequency* value) + 1 second. *Last execution* shows the date of last execution and its result (success/error). Both *next execution* and *last execution* are shown using brand timezone. Call discount Client Defines the frequency (once a month, every 7 days, etc.) of the programmed task Discard current day (2018/11/01 08:00:00 will set 2018/10/31 23:59:59 as *Out date*). Email Example 1: Unit: month - Frequency 1 - Next execution mangling Example 1: Unit: month - Frequency 3 Example 1: Unit: week - Frequency 2 Fixed costs Frequency definition Frequency/Unit In *Invoices* section, indistinguishable to manually generated invoices. In each row of *Invoice schedulers* section, **List of Invoices** option. Invoice number sequence Invoice schedulers Invoice will include calls from 3nd of previous month at 00:00:00 to 2nd to current month at 23:59:59. Invoices are programmed at 08:00:00 by default on mondays, 1st of month or 1st of January (depending on Unit value). Invoices generated due to a schedule can be seen in two ways: It is interesting to understand how *Frequency* and *Unit* fields define the periodical task: Name Name of the scheduled invoice Next execution will be set to next 1st of month at 08:00 and invoices will include calls of last 3 months. Next execution will be set to next 1st of month at 08:00 but we mangle it to 3rd of month at 10:00:00. Next execution will be set to next monday at 08:00 and invoices will include calls of last 2 weeks. Non-static values are retrieved from client configuration in the date specified in "Next execution". Regenerating the invoice later will not modify assigned value, but you can adapt it manually to the desired value editing the fixed cost in Invoice section and regenerating the invoice. Once created a new schedule, **Next execution** shows when will happen next invoice generation. Percentage to discount calls, prior to tax rate calculation. No effect on fixed concepts. Scheduled invoices will use the next invoice number available in a given predefined sequence Send generated invoices via email. Empty if no automatic mail is wanted. Tax rate Taxes to add to the final cost (e.g. VAT) This section allows programming the automatic periodical creation of invoices. Type **'DDIs'** sets the quantity in the moment of the creation of the invoice to the number of DDIS matching criteria (all, national, international or belonging to specific country) in the client in that specific moment. Type **'Max calls'** sets the quantity in the moment of the creation of the invoice to "Max calls" value of the client in that specific moment. Type **'static'** is used for fixed quantities. When adding a new definition, these fields are shown: When defining a scheduled invoice, you can add fixed costs in a static or dynamic way: Which client calls should be included Project-Id-Version: IvozProvider 4.2
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
 El valor de **Próxima ejecución** puede ser manipulado, pero la factura generada siempre: *Fecha de entrada* será *fecha de salida* menos X semana(s), X mes(es) o X año(s) (X igual al valor de *Frecuencia*) + 1 segundo. *Última ejecución* muestra la fecha de la última ejecución y su resultado (éxito/error). Tanto *próxima ejecución* como *última ejecución* se muestran usando la zona horaria de la marca. Descuento de llamadas Cliente Define la frecuencia (una vez al mes, cada 7 días, etc.) de la tarea programada Descartar el día actual (2018/11/01 08:00:00 establecerá 2018/10/31 23:59:59 como *Fecha de salida*). Correo electrónico Ejemplo 1: Unidad: mes - Frecuencia 1 - Manipulación de próxima ejecución Ejemplo 1: Unidad: mes - Frecuencia 3 Ejemplo 1: Unidad: semana - Frecuencia 2 Costos fijos Definición de frecuencia Frecuencia/Unidad En la sección *Facturas*, indistinguibles de las facturas generadas manualmente. En cada fila de la sección *Programadores de facturas*, opción **Lista de Facturas**. Secuencia de número de factura Programadores de facturas La factura incluirá llamadas desde el 3er día del mes anterior a las 00:00:00 hasta el 2do día del mes actual a las 23:59:59. Las facturas se programan a las 08:00:00 por defecto los lunes, el 1er día del mes o el 1 de enero (dependiendo del valor de la Unidad). Las facturas generadas debido a una programación se pueden ver de dos maneras: Es interesante entender cómo los campos *Frecuencia* y *Unidad* definen la tarea periódica: Nombre Nombre de la factura programada La próxima ejecución se establecerá para el próximo 1er día del mes a las 08:00 y las facturas incluirán llamadas de los últimos 3 meses. La próxima ejecución se establecerá para el próximo 1er día del mes a las 08:00 pero la manipulamos al 3er día del mes a las 10:00:00. La próxima ejecución se establecerá para el próximo lunes a las 08:00 y las facturas incluirán llamadas de las últimas 2 semanas. Los valores no estáticos se recuperan de la configuración del cliente en la fecha especificada en "Próxima ejecución". Regenerar la factura más tarde no modificará el valor asignado, pero puede adaptarlo manualmente al valor deseado editando el costo fijo en la sección de Facturas y regenerando la factura. Una vez creado un nuevo horario, **Próxima ejecución** muestra cuándo ocurrirá la próxima generación de facturas. Porcentaje para descontar llamadas, antes del cálculo de la tasa de impuestos. Sin efecto en conceptos fijos. Las facturas programadas usarán el siguiente número de factura disponible en una secuencia predefinida Enviar facturas generadas por correo electrónico. Vacío si no se desea correo automático. Tasa de impuestos Impuestos a añadir al costo final (por ejemplo, IVA) Esta sección permite programar la creación automática y periódica de facturas. El tipo **'DDIs'** establece la cantidad en el momento de la creación de la factura al número de DDIs que cumplen con los criterios (todos, nacionales, internacionales o pertenecientes a un país específico) en el cliente en ese momento específico. El tipo **'Máximo de llamadas'** establece la cantidad en el momento de la creación de la factura al valor de "Máximo de llamadas" del cliente en ese momento específico. El tipo **'estático'** se usa para cantidades fijas. Al agregar una nueva definición, se muestran estos campos: Al definir una factura programada, puede agregar costos fijos de manera estática o dinámica: Qué llamadas de clientes deben ser incluidas 