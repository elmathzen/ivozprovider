��          �               �   -   �        &   4  &   [  ;   �     �  �   �  '   ]  V   �  =   �  [     &   v  �  �  9        Y  (   s  2   �  :   �     
  �     )   �  i   �  ]   W  n   �  .   $   After 12 hours, source is accepted again and: Anti brute-force attacks Counter is increased on every failure. Counter starts counting again from 80. If it reaches 100 again, it is banned for another 12 hours. It works like this: IvozProvider ships a simple anti brute-force attack in KamUsers that bans sources after continuous SIP auth failures from same IP address. Key: fromUsername@fromDomain::source_ip On SIP failures (invalid user or invalid password cases only), a counter is increased: See :ref:`Brute-force attacks` for currently blocked sources. When counter reaches 100, that specific source (user + domain + ip) is banned for 12 hours. e.g. terminal@vpbx.domain.net::1.2.3.4 Project-Id-Version: IvozProvider 4.2
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
 Después de 12 horas, la fuente es aceptada nuevamente y: Ataques anti fuerza bruta El contador se incrementa en cada fallo. El contador comienza a contar nuevamente desde 80. Si alcanza 100 nuevamente, se prohíbe por otras 12 horas. Funciona así: IvozProvider incluye un simple ataque anti fuerza bruta en KamUsers que prohíbe fuentes después de fallos continuos de autenticación SIP desde la misma dirección IP. Clave: fromUsername@fromDomain::source_ip En fallos de SIP (solo en casos de usuario inválido o contraseña inválida), se incrementa un contador: Vea :ref:`Ataques de fuerza bruta <Brute-force attacks>` para fuentes actualmente bloqueadas. Cuando el contador alcanza 100, esa fuente específica (usuario + dominio + ip) es prohibida durante 12 horas. por ejemplo, terminal@vpbx.domain.net::1.2.3.4 