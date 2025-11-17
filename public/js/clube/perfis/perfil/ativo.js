const oportuniade = document.getElementById('atoportunidade')
const membro = document.getElementById('atmembros')
const sobre = document.getElementById('atsobre')

oportuniade.addEventListener('click',function(){
oportuniade.classList.add('active')
membro.classList.remove('active')
sobre.classList.remove('active')
});

sobre.addEventListener('click',function(){
oportuniade.classList.remove('active')
membro.classList.remove('active')
sobre.classList.add('active')
});
membro.addEventListener('click',function(){
oportuniade.classList.remove('active')
sobre.classList.remove('active')
membro.classList.add('active')
});