<html>
<head>
<script>
 function notificarUsuario77(){
 // Caso window.Notification não exista, quer dizer que o browser não possui suporte a web notifications, então cancela a execução
 if(!window.Notification){
     alert('Sem suporte');
 return false;
 }

 // Verificando suporte a tecnologia
if (window.webkitNotifications) {
  console.log('Seu browser suporta Notifications');
}
else {
  console.log('Seu browser não suporta Notifications =(');
}

 // Função utilizada para enviar a notificação para o usuário
 var notificar = function(){
 var tituloMensagem = "Nova Mensagem de Sistema (Automático)!";
 var icone = "http://icon-icons.com/icons2/270/PNG/512/messages_29935.png";
 var mensagem = "Assunto: Nova resposta: crediario \n\n Vá até mensagens e verifique!";
 alert(mensagem);
 return new Notification(tituloMensagem,{
 icon : icone,
 body : mensagem
 });
 };
 
 // Verifica se existe a permissão para exibir a notificação; caso ainda não exista ("default"), então solicita permissão.
 // Existem três estados para a permissão:
 // "default" => o usuário ainda não deu nem negou permissão (neste caso deve ser feita a solicitação da permissão)
 // "denied" => permissão negada (como o usuário não deu permissão, o web notifications não irá funcionar)
 // "granted" => permissão concedida
 
 // A permissão já foi concedida, então pode enviar a notificação
 if(Notification.permission==="granted"){
 notificar();
 }else if(Notification.permission==="default"){
 // Solicita a permissão e caso o usuário conceda, envia a notificação
 Notification.requestPermission(function(permission){
 if(permission=="granted"){
 notificar();
 }
 });
 }
 };</script>


</head>

<body onload="notificarUsuario77();">
                     
 
</body>
</html>