const posicao = document.getElementById('posicao')
const caracteristica = document.getElementById('caracteristica')

posicao.addEventListener('click',function(){
posicao.classList.add('active')
caracteristica.classList.remove('active')
});

caracteristica.addEventListener('click',function(){
posicao.classList.remove('active')
caracteristica.classList.add('active')
});