��          �               �   
   �   �   �   �   �  K        _  �   u                 �   1  E   �       �  #     �  �   �  �   t  T        n  �   �     <     V     ]  �   p  L   	  "   f	   Black list Blacklisting has precedence over unconditional call forward. Calls from numbers matching associated matchlist won't be forwarded, they will be rejected. Calls forwarded by a filter will keep the original caller identification, adding the forwarding info in a SIP *Diversion* header. Calls to DDIs using this filter will be forwarded to given external number. External call filters External origin will be checked against the associated :ref:`match_lists`, if a coincidence is found, the call will be rejected immediately. Filters Configuration Name Name of the filter. Residential External Filters can be assigned to DDIs to temporary forward calls to an external number or to avoid call from undesirable sources. This are the configurable settings of *Residential external filters*: Unconditional Call Forward Project-Id-Version: IvozProvider 4.2
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
 Lista negra La lista negra tiene prioridad sobre el reenvío de llamadas incondicional. Las llamadas de números que coincidan con la lista de coincidencias asociada no serán reenviadas, serán rechazadas. Las llamadas reenviadas por un filtro mantendrán la identificación del llamante original, añadiendo la información de reenvío en un encabezado SIP *Diversion*. Las llamadas a DDIs que usen este filtro se reenviarán al número externo indicado. Filtros de llamadas externas El origen externo se verificará contra las :ref:`listas de coincidencias <match_lists>` asociadas, si se encuentra una coincidencia, la llamada será rechazada inmediatamente. Configuración de filtros Nombre Nombre del filtro. Los filtros externos residenciales se pueden asignar a DDIs para reenviar temporalmente las llamadas a un número externo o para evitar llamadas de fuentes indeseables. Estos son los ajustes configurables de los *filtros externos residenciales*: Reenvío de llamadas incondicional 