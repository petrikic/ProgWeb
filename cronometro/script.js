/*
 *  Script com a lógica do cronometro.
 *  Ele possui o esqueleto dos método essenciais.
 *  Modifique este arquivo o quanto for necessário.
 *
 */

var intervalo;
var horas = 0;
var minutos = 0;
var segundos = 0;
var milesimos = 0;

// Funcao para atualizar o display do cronometro no html.
// Dica: use do método 'setInterval' para executálo a cada 50 milissegundos.

function leftPad(valor, tamanho) {
  var comprimento = tamanho - valor.toString().length +1;
  return Array(comprimento).join('0') + valor;
};
function updateVisualization() {
  // As próximas linhas buscam pelos respectivos espacos de hora, minuto, segundo e milissegundos
  // Basta implementar a lógica e alterar o conteúdo (innerHTML) com os valores
  var hora = document.getElementsByClassName('hora')[0];
  var minuto = document.getElementsByClassName('minuto')[0];
  var segundo = document.getElementsByClassName('segundo')[0];
  var milissegundo = document.getElementsByClassName('milissegundo')[0];

  if (milesimos < 1000){
    milissegundo.innerHTML = leftPad(milesimos, 3);
  }
  else{
    milesimos -= 1000;
    segundos++;
  }
  if(segundos < 60){
    segundo.innerHTML = leftPad(segundos, 2);
  }
  else{
    segundos = 0;
    minutos++;
  }
  if(minutos < 60){
    minuto.innerHTML = leftPad(minutos, 2);
  }
  else{
    minutos = 0;
    horas++
  }
  milesimos+= 17;
}

// Funcao executada quando o botão 'Inicar' é clicado
// - se o cronometro estiver parado, iniciar contagem.
// - se estiver ativo, reiniciar a contagem
function start() {
  stop();
  intervalo = setInterval(updateVisualization, 17);

  // TODO (implementar)
}

// Funcao executada quando o botão 'Parar' é clicado
// - se o cronometro estiver ativo, parar na contagem atual
function stop() {
  clearInterval(intervalo);
}

// Funcao executada quando o botão 'Reiniciar' é clicado
// - se o cronometro estiver ativo, reiniciar contagem
// - se estiver parado, zerar e permanecer zerado
function reiniciar() {
  horas = 0;
  minutos = 0;
  segundos = 0;
  milesimos = 0;
  updateVisualization();
}
