Back-end Chat Challenge
=============
La lógica de la Api es la siguiente
- Endpoint Login inicia sesión mediante credenciales (Implementación  de JWT pendiente)
- Los Usuarios  pueden ser creados mediante Backoffice o Api
- Para la conversación la secuencia es la siguiente:
	-	Se inicia con una solicitud a http://localhost/Back-endChatChallenge-YANA/index.php/api/v1/send_message enviando el parámetro  usr_id
	-	Si una pregunta No contine respuestas preestablecidas (Array answer). Entonces en el parámetro usr_msg se permite enviar una respuesta abierta
	-	Si una pregunta Si contine respuestas preestablecidas. Entonces en el parámetro usr_msg se debe enviar el id de la respuesta (ans_id).
	-	La secuencia siempre será [BOT]Pregunta->[HUMANO]Respuesta->[BOT]Expresion->[BOT]->pregunta....

Estructura de BD
-	Tabla "question", contiene preguntas que pueden o no estar asociadas a con una "expression"
-	Desde la tabla "expression" siempre estarán asociadas a una "question"
-	Tabla "greeting" contiene los saludos de bienvenida, y siempre estarán asociados a una "question"
-	Tabla answer contiene respuestas predefinidas, asociada a una "question" y siempre estarán además asociadas a una "expression"
		
