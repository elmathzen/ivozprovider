��    ,      |              �  U   �  E   3  �   y  �        �  ^   �                4     H  I   \     �  @   �  S   �  H   G  �   �     $  �   0  o   �     '  J   .  +   y     �     �  t   �     7	     L	     S	     d	     l	  l   x	     �	  �   �	  �   �
  �   �  K   �  j   �  !   ?  /   a  !   �  �   �  �   C  t   �  �  H  _   �  X   *  �   �  �     $   �  v   �  &   X          �     �  X   �     $  U   1  d   �  U   �  �   B       �     �   �     �  L   �  /   �            �   -     �  	   �  #   �           (  �   4  
   �  �   �  �   �  �   �  T   �  ~   �     c  ?   �  .   �  �   �  �   �  �   J   **List of members** subsection allows adding users or external numbers to each group: **No**: The behaviour of this setting depends on the hunt group type: **Remaining types**: calls generated by the hunt group will generate missed calls on every called member that does not answer the call. **RingAll**: calls generated by the hunt group will generate missed calls on called members only if none of them answers the call. **Use this feature wisely**. **Yes**: calls generated by the hunt group will never generate missed calls on called members. Adding members to hunt group Additional information Allow Call Forwards Basic configuration Describes how will the calls be delivered. See details in glossary below. Description Enabling **Allow Call Forwards** may cause undesired behaviours: For *RingAll hunt groups*, members will be added without any additional parameters. For *Ringall* strategy, defines for how long will the members be called. For remaining groups, priority and timeout will be specified for each member. Priority determines the order, timeout ring duration for each member. Hunt groups Huntgroup's *No answer configuration* never applying (e.g. no answer timeout on called user that applies sooner than Ringall timeout). Huntgroup's members not being called (e.g. sequential huntgroup, first member forwards call to its cell phone). Linear Member marked as boss not being called (assistant will be called instead). Member not being called as has DND enabled. Name No answer configuration Policy when hunt group members do not answer the call after defined timeouts. A locution and a target can be set up. Prevent missed calls Random Ring all timeout Ringall Round robin Section :ref:`Users` also allows adding member to existing hunt groups using **List of hunt groups** option. Strategy The call will *jump* from one user to another in a predefined order ringing during the configured time. If the call is not answered by any user of the group, it will be hung up (or will trigger the no answer logic). The call will *jump* from one user to another in a predefined order ringing during the configured time. If the call is not answered by any user of the group, the call will *jump* again to the first member of the group and keep looping. The call will *jump* from one user to another in a random order, ringing during the configured time.  If the call is not answered by any user of the group, it will be hung up (or will trigger the no answer logic). The call will make all the terminals of the group during a predefined time. The hunt groups allows configuring more complex *ringing* process than the traditional **call to a user**. There are 4 strategies available: These are the fields shown for new hunt groups: Used to reference this hunt group When 'No', user's call forward settings (including DND and boss/assistant) and 3XX responses will be ignored. Otherwise, they will be followed. When 'Yes', calls will never generate a missed call. When 'No', missed calls will be prevented only for RingAll hunt groups if someone answers. When configuring a hunt group, you can prevent missed calls on called members with **Prevent missed calls** setting: Project-Id-Version: IvozProvider 4.2
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
 La subsección **Lista de miembros** permite agregar usuarios o números externos a cada grupo: **No**: El comportamiento de esta configuración depende del tipo de grupo de búsqueda: **Tipos restantes**: las llamadas generadas por el grupo de búsqueda generarán llamadas perdidas en cada miembro llamado que no responda la llamada. **RingAll**: las llamadas generadas por el grupo de búsqueda generarán llamadas perdidas en los miembros llamados solo si ninguno de ellos responde la llamada. **Use esta función con prudencia**. **Sí**: las llamadas generadas por el grupo de búsqueda nunca generarán llamadas perdidas en los miembros llamados. Agregar miembros al grupo de búsqueda Información adicional Permitir desvíos de llamadas Configuración básica Describe cómo se entregarán las llamadas. Ver detalles en el glosario a continuación. Descripción Habilitar **Permitir desvíos de llamadas** puede causar comportamientos no deseados: Para los grupos de búsqueda *RingAll*, los miembros se agregarán sin ningún parámetro adicional. Para la estrategia *Ringall*, define por cuánto tiempo serán llamados los miembros. Para los grupos restantes, se especificarán la prioridad y el tiempo de espera para cada miembro. La prioridad determina el orden, el tiempo de espera la duración de la llamada para cada miembro. Grupos de búsqueda La *Configuración de no respuesta* del grupo de búsqueda nunca se aplica (por ejemplo, tiempo de espera de no respuesta en el usuario llamado que se aplica antes que el tiempo de espera de Ringall). Los miembros del grupo de búsqueda no son llamados (por ejemplo, grupo de búsqueda secuencial, el primer miembro desvía la llamada a su teléfono móvil). Lineal Miembro marcado como jefe no llamado (se llamará al asistente en su lugar). Miembro no llamado porque tiene DND habilitado. Nombre Configuración de no respuesta Política cuando los miembros del grupo de búsqueda no responden la llamada después de los tiempos de espera definidos. Se puede configurar una locución y un destino. Prevenir llamadas perdidas Aleatorio Tiempo de espera de llamada a todos Ringall Round robin La sección :ref:`Usuarios <Users>` también permite agregar miembros a grupos de búsqueda existentes usando la opción **Lista de grupos de búsqueda**. Estrategia La llamada *saltará* de un usuario a otro en un orden predefinido sonando durante el tiempo configurado. Si la llamada no es respondida por ningún usuario del grupo, se colgará (o activará la lógica de no respuesta). La llamada *saltará* de un usuario a otro en un orden predefinido sonando durante el tiempo configurado. Si la llamada no es respondida por ningún usuario del grupo, la llamada *saltará* nuevamente al primer miembro del grupo y seguirá en bucle. La llamada *saltará* de un usuario a otro en un orden aleatorio, sonando durante el tiempo configurado. Si la llamada no es respondida por ningún usuario del grupo, se colgará (o activará la lógica de no respuesta). La llamada hará sonar todos los terminales del grupo durante un tiempo predefinido. Los grupos de búsqueda permiten configurar un proceso de *llamada* más complejo que la tradicional **llamada a un usuario**. Hay 4 estrategias disponibles: Estos son los campos mostrados para nuevos grupos de búsqueda: Usado para referenciar este grupo de búsqueda Cuando 'No', se ignorarán las configuraciones de desvío de llamadas del usuario (incluyendo DND y jefe/asistente) y las respuestas 3XX. De lo contrario, se seguirán. Cuando 'Sí', las llamadas nunca generarán una llamada perdida. Cuando 'No', las llamadas perdidas se evitarán solo para los grupos de búsqueda RingAll si alguien responde. Al configurar un grupo de búsqueda, puede evitar llamadas perdidas en los miembros llamados con la configuración **Prevenir llamadas perdidas**: 