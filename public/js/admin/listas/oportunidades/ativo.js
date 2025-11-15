const detalhes = document.getElementById('detalhes')
const inscritos = document.getElementById('inscritos')

detalhes.addEventListener('click',function(){
detalhes.classList.add('active')
inscritos.classList.remove('active')
});

inscritos.addEventListener('click',function(){
detalhes.classList.remove('active')
inscritos.classList.add('active')
});