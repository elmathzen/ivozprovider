��    	      d               �   �   �   �   g  4     -   O  2   }  5   �     �       �    �   �  �   g  K   6  3   �  =   �  @   �  #   5     Y   Impersonate as a brand admin on Auth> /token/exchange (requires a god token and the brand Id. You can impersonate by the username of a brand administrator instead of a brand id as well) Let's put a little use case as an example: A platform admin wants to obtain the companies of one specific brand (companies are exposed on Brand API only). The operation would be: Login (request a token) as god admin on /admin_login On Brand API (https://brand-domain/api/brand) On platform API (https://your-domain/api/platform) Request brand companies using the endpoint /companies Search target brand on /brands Use Case Project-Id-Version: IvozProvider 4.2
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
 Suplantar como administrador de marca en Auth> /token/exchange (requiere un token god y el Id de la marca. También puedes suplantar por el nombre de usuario de un administrador de marca en lugar de un id de marca) Pongamos un pequeño caso de uso como ejemplo: Un administrador de la plataforma quiere obtener las empresas de una marca específica (las empresas solo se exponen en la API de Marca). La operación sería: Iniciar sesión (solicitar un token) como administrador god en /admin_login En la API de Marca (https://brand-domain/api/brand) En la API de la plataforma (https://your-domain/api/platform) Solicitar las empresas de la marca usando el endpoint /companies Buscar la marca objetivo en /brands Caso de Uso 